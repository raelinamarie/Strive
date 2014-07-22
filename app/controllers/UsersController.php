<?php

use Authority\Exceptions\MissingParametersException;
use Authority\Exceptions\NonSkillIdException;
use Authority\Exceptions\NoSearchResultsException;
use Authority\Exceptions\UpdatingErrorException;
use Authority\Exceptions\ValidationException;
use Authority\Exceptions\NonExistantException;
use Authority\Interfaces\SkillRepositoryInterface;
use Authority\Interfaces\UserRepositoryInterface;
use Authority\Service\LocationServices\GoogleController;
use \Auth;
use Authority\Interfaces\SessionsAuthTokenInterface;
use Authority\Interfaces\ChargeRepositoryInterface;
use Authority\Validation\ProfileValidator;
use \Config;
use Authority\AuthToken\Exceptions\NotAuthorizedException;
use \Session;


/**
 * Class UsersController
 */
class UsersController extends BaseController  {
    /**
     * @param UserRepositoryInterface $user
     * @param GoogleController $goog
     * @param SessionsAuthTokenInterface $auth
     * @param ChargeRepositoryInterface $charge
     * @param SkillRepositoryInterface $skill
     * @param ProfileValidator $profile
     */
    public function __construct(UserRepositoryInterface $user, GoogleController $goog, SessionsAuthTokenInterface $auth, ChargeRepositoryInterface $charge, SkillRepositoryInterface $skill, ProfileValidator $profile){
        $this->user = $user;
        $this->goog = $goog;
        $this->auth = $auth;
        $this->charge = $charge;
        $this->skill = $skill;
        $this->profileValidator = $profile;
    }

    public function getRealGet()
    {
        if(!$_SERVER['QUERY_STRING']){
            throw new MissingParametersException('Missing parameters');
        }
        $pairs = explode( '&', $_SERVER['QUERY_STRING'] );
        $vars = array();
        foreach ($pairs as $pair) {
            $nv = explode("=", $pair);
            $name = urldecode($nv[0]);
            $value = urldecode($nv[1]);
            $vars[$name] = $value;
        }
        return $vars;
    }
    public function index(){
        if(!Input::has('lat') || !Input::has('lng') || !Input::has('type')){
            return \Restable::error('missing latitude, longitude, or type')->render();
        }
        if(Input::has('skills') || Input::has('categories')){
            $skills = (Input::has('skills')) ? Input::get('skills') : NULL;
            $categories = (Input::has('categories')) ? Input::get('categories') : NULL;
            $skillsIds = $this->skill->skillIdFormat($skills,$categories);

        }
        else{
            $skillsIds = \Skill::all()->lists('id');
        }
        $searchResults = $this->user->userSearch(['lat' => Input::get('lat'),'lng' => Input::get('lng'),'skills' => $skillsIds,'type'=>Input::get('type')]);
        return Restable::listing($searchResults)->render();
    }

    /**
     * @return mixed
     * @throws Authority\Exceptions\MissingParametersException
     */
    public function getByLocation() {
        $input = $this->getRealGet();
        $ids = $this->goog->search($input['lat'], $input['lng']);
        $users = User::orderBy('updated_at', 'desc')->with('skills', 'jobs')->whereIn('id', $ids)->take(30)->get()->toArray();
        return $users;
    }

    public function store(){
        Auth::logout();
        Session::flush();
        Session::regenerate();
        $this->user->createNew(Input::except('lat','lng'));
        $session = $this->auth->store(['username' => Input::get('email'), 'password' => Input::get('password')]);
        $user = User::find($session['id']);
        $user->groups()->attach(1);
        if(Input::has('lat') && Input::has('lng')){
            $latlng = ['lat'=>Input::get('lat'),'lng'=>Input::get('lng')];
            $user->lat = $latlng['lat'];
            $user->lng = $latlng['lng'];
        }
        if(Input::has('first_name')){
            $user->first_name = Input::get('first_name');
        }
        if(Input::has('last_name')){
            $user->last_name = Input::get('last_name');
        }
        if(Input::has('phone_number')){
            $user->phone_number = Input::get('phone_number');
        }
        #$user->stripe_id = $this->charge->newCust(Input::get('email'));
        $user->save();
        $return = $this->user->find($session['id']);
        $return['token'] = $session['token'];
        return Restable::created($return)->render();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $return = $this->user->find($id);

        return Restable::single($return)->render();

    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function userJobs($user_id){
        $user = $this->user->userJobs($user_id);
        if($user){
            return Restable::listing($user['jobs'])->render();
        }
        else{
            return Restable::listing([])->render();
        }
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function userSkills($user_id){
        $user = $this->user->userSkills($user_id);
        if($user){
            return Restable::listing($user)->render();
        }
        else{
            return Restable::listing([])->render();
        }
    }

    public function userFavorites($user_id){
        $user = $this->user->userFavorites($user_id);
        if($user){
            return Restable::listing($user['favorites'])->render();
        }
        else{
            return Restable::listing([])->render();
        }
    }

    public function userFavoritesPost($user_id) {
        if (!$this->sessionCheck($user_id)) {
            return Restable::unauthorized()->render();
        } else {
            $validator = Validator::make(Input::all(), ['job_id' => 'required|integer|exists:jobs,id|']);
            if ($validator->fails()) {
                return Restable::bad('bad job id')->render();
            }
            $job_id = Input::get('job_id');
            $favorites = DB::table('user_favorites_jobs')->where('job_id', '=', $job_id)->where('user_id', '=', $user_id)->first();
            if ($favorites == NULL) {
                $user = User::find($user_id);
                $user->favorites()->attach(Input::get('job_id'));
                $user->save();
                $favorite = DB::select('SELECT * from user_favorites_jobs where user_id = ? and job_id = ?', array($user_id, $job_id));
                return Restable::created($favorite)->render();
            }
        }
    }

    public function userFavoritesDelete($user_id,$job_id){
        if (!$this->sessionCheck($user_id)) {
            return Restable::unauthorized()->render();
        } else {
            #$validator = Validator::make([$job_id], ['job_id' => 'required|integer|exists:user_favorites_jobs,job_id|']);
            #if ($validator->fails()) {
            #    return Restable::bad('bad')->render();
            #}
            $return = DB::delete('delete from user_favorites_jobs where user_id = ? and job_id = ?',array($user_id,$job_id));
            if($return){
                return Restable::deleted()->render();
            }
            else{
                return Restable::bad()->render();
            }
        }
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function userRatings($user_id){
        $for = (Input::has('for')) ? true : false;
        $by = (Input::has('by')) ? true : false;
        return Restable::listing($this->user->userRatings($user_id, $for, $by))->render();

    }

    public function update($id){
        $this->user->privatePage($id);
        $this->user->updateExisting($id, Input::all());
        return Restable::updated($this->user->find($id))->render();
    }

    public function userGroups($id){
        return Restable::listing($this->user->userGroups($id))->render();
    }

    public function grantcontractor($user_id){
        $this->user->privatePage($user_id);
        User::find($user_id)->groups()->sync([1,3]);
        return Restable::single(User::with(['groups'])->find($user_id)->toArray())->render();
    }

    public function grantemployer($user_id){
        $this->user->privatePage($user_id);
        User::find($user_id)->groups()->sync([1,4]);
        return Restable::single(User::with(['groups'])->find($user_id)->toArray())->render();
    }

    public function grantemployee($user_id){
        $this->user->privatePage($user_id);
        User::find($user_id)->groups()->sync([1]);
        return Restable::single(User::with(['groups'])->find($user_id)->toArray())->render();
    }

    public function profileUpload($user_id){
        $this->user->privatePage($user_id);
        if(!Input::hasFile('profile_picture')){throw new MissingParametersException('missing profile_picture');}
        $extension = Input::file('profile_picture')->getClientOriginalExtension();
        $filename = sha1($user_id.time()).".{$extension}";
        $directory = public_path().'/profilePictures/';
        if(Input::file('profile_picture')->move($directory,$filename)) {
            User::find($user_id)->update(['profile_image'=>$filename]);
            return Restable::created([$filename])->render();
        }
        else{
            throw new Exception('error');
        }

    }

    public function profileUploadForm(){
        return View::make('testUpload');
    }

    public function addPosts($user_id){
        $this->user->privatePage($user_id);
        $user = User::find($user_id);
        if(!Input::has('num')){
            throw new MissingParametersException('missing num parameter');
        }
        $fromUser = Input::get('num');
        $jobPosts = $user->monthlyJobPosts;
        $newPosts = $jobPosts + $fromUser;
        $user->monthlyJobPosts = $newPosts;
        $user->save();
        return Restable::single($this->user->find($user_id))->render();
    }
}
