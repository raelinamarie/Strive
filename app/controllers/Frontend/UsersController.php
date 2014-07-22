<?php namespace Controllers\Frontend;

use Authority\Exceptions\MissingParametersException;
use Authority\Exceptions\NonSkillIdException;
use Authority\Exceptions\ValidationException;
use Authority\Exceptions\NonExistantException;
use Authority\Interfaces\UserRepositoryInterface;
use Authority\Service\LocationServices\GoogleController;
use \Auth;
use Authority\Interfaces\SessionsAuthTokenInterface;
use Authority\Interfaces\ChargeRepositoryInterface;
use Carbon\Carbon;
use \Config;
use Authority\AuthToken\Exceptions\NotAuthorizedException;
use DB;
use Input;
use Job;
use Redirect;
use \Session;
use Teepluss\Restable\Facades\Restable;
use User;
use \View;

/**
 * Class UsersController
 */
class UsersController extends BaseController  {
    /**
     * @param UserRepositoryInterface $user
     */
    public function __construct(UserRepositoryInterface $user, GoogleController $goog, SessionsAuthTokenInterface $auth, ChargeRepositoryInterface $charge){
        $this->user = $user;
        $this->goog = $goog;
        $this->auth = $auth;
        $this->charge = $charge;
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
        if(Input::get('profile')){
            Auth::logout();
            switch(Input::get('profile')){
                case 'employee';
                    /** @var \User $user */
                    $user = User::where('email','=','employee@strive.com')->first();
                    Auth::setUser($user);
                    break;
                case 'employer';
                    /** @var \User $user */
                    $user = User::where('email','=','employer@strive.com')->first();
                    Auth::setUser($user);
                    break;
                case 'contractor';
                    /** @var \User $user */
                    $user = User::where('email','=','contractor@strive.com')->first();
                    Auth::setUser($user);
                    break;
            }
        }
        $user_id = Auth::user()->id;
        $favoritedJobIds =  DB::table('user_favorites_jobs')->where('user_id', '=', $user_id)->lists('job_id');
        $favorites = ($favoritedJobIds != []) ? Job::whereIn('id',$favoritedJobIds)->limit(30)->get() : [];
        $userDetails = $this->user->find($user_id);
        $daysFromProfile = User::find($user_id)->days->lists('id');
        $returnDays = [];
        if(in_array(1,$daysFromProfile)){
            $returnDays[] = ['day' => 1, 'data' => "<li>SU</li>"];
        }
        else{
            $returnDays[] = ['day' => 1, 'data' => "<li></li>"];
        }
        if(in_array(2,$daysFromProfile)){
            $returnDays[] = ['day' => 2, 'data' => "<li>M</li>"];
        }
        else{
            $returnDays[] = ['day' => 2, 'data' => '<li></li>'];
        }
        if(in_array(3,$daysFromProfile)){
            $returnDays[] = ['day' => 3, 'data' => "<li>TU</li>"];
        }
        else{
            $returnDays[] = ['day' => 3, 'data' => '<li></li>'];
        }
        if(in_array(4,$daysFromProfile)){
            $returnDays[] = ['day' => 4, 'data' => "<li>W</li>"];
        }
        else{
            $returnDays[] = ['day' => 4, 'data' => '<li></li>'];
        }
        if(in_array(5,$daysFromProfile)){
            $returnDays[] = ['day' => 5, 'data' => "<li>TH</li>"];
        }
        else{
            $returnDays[] = ['day' => 5, 'data' => '<li></li>'];
        }
        if(in_array(6,$daysFromProfile)){
            $returnDays[] = ['day' => 6, 'data' => "<li>F</li>"];
        }
        else{
            $returnDays[] = ['day' => 6, 'data' => '<li></li>'];
        }
        if(in_array(7,$daysFromProfile)){
            $returnDays[] = ['day' => 7, 'data' => "<li>SA</li>"];
        }
        else{
            $returnDays[] = ['day' => 7, 'data' => '<li></li>'];
        }

        $view['title'] = 'My Profile';
        $view['subview'] = $this->user->profile_type($user_id);
        $view['user_details'] = $userDetails;
        $view['user_jobs'] = Job::with('skills')->where('posted_by','=',$user_id)->limit(15)->get()->toArray();
        $view['returnDays'] = $returnDays;


        $view['favorites'] = $favorites;
        return View::make('Frontend::profile.index', $view);
    }

    /**
     * @return mixed
     * @throws \Authority\Exceptions\MissingParametersException
     * @throws \Authority\Exceptions\NoSearchResultsException
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
        try{
            /** @var \User $user */
            $user = $this->user->createNewFrontend(Input::all());
            if($user){
                $user->update(['stripe_id' => $this->charge->newCust(Input::get('email'))]);
                return Redirect::back(201)->with('message','Registered Successfully');
            }
        }
        catch(ValidationException $e){
            echo "<pre>";
            return print_r($e->getErrors());
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        try{
            $view['user'] = \User::with(['jobs','skills','skills.categories','jobs.skills','ratingsForUser','ratingsByUser','favorites'])->where('id','=',$id)->get();
            return View::make('frontend.pages.users.show',$view);
        }
        catch(NonExistantException $e){
            return View::make('frontend.pages.users.show',$view)->withErrors($e->getErrors());
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

    public function update($id){
        try{
            $this->user->privatePage($id);
            $this->user->updateExisting($id, Input::except('skills'));
            try{if(Input::get('skills') != ''){
                $this->user->updateSkills($id,Input::only('skills')['skills']);
            }}
            catch(NonSkillIdException $e){
                return Restable::error($e->getErrors())->render();
            }
        }
        catch(NonExistantException $e){
            return Restable::missing()->render();
        }
        catch(ValidationException $e){
            return Restable::error($e->getErrors())->render();
        }
        return Restable::updated($this->user->find($id))->render();
    }

    public function userGroups($id){
        try{
            return Restable::listing($this->user->userGroups($id))->render();
        }
        catch(NotAuthorizedException $e){
            return Restable::unauthorized()->render();
        }
    }

    public function updateAvailability(){
        $user_id = Auth::user()->id;
        User::find($user_id)->days()->sync(Input::get('availability'));
        return Redirect::back()->with('message','Availability Updated');
    }

    public function updateProfile(){
        try{
            $user_id = Auth::user()->id;
            $this->user->updateExisting($user_id, Input::except('skills'));
            try{if(Input::get('skills') != ''){
                $this->user->updateSkills($user_id,Input::only('skills')['skills']);
            }}
            catch(NonSkillIdException $e){
                return Redirect::back()->withErrors($e->getErrors());
            }
        }
        catch(NonExistantException $e){
            return Redirect::back()->withErrors($e->getMessage());
        }
        catch(ValidationException $e){
            return Redirect::back()->withErrors($e->getErrors());
        }
        return Redirect::back()->with('message','Successfully Update');
    }

    public function create(){

    }
}
