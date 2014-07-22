<?php namespace Authority\Repositories;

use Authority\AuthToken\Exceptions\NotAuthorizedException;
use Authority\Exceptions\NoSearchResultsException;
use Authority\Exceptions\UpdatingErrorException;
use Authority\Interfaces\SkillRepositoryInterface;
use Authority\Interfaces\UserRepositoryInterface;
use Authority\Exceptions\NonExistantException;
use Authority\Exceptions\NonSkillIdException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Queue;
use Strive\Admin\Controllers\CategoriesController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use \User;
use \Auth;
use Authority\Validation\UserValidator;
use Authority\Service\LocationServices\GoogleController;
use Authority\Exceptions\MissingParametersException;
use \Category;
use \Rating;
use Authority\Exceptions\PostsAvailableException;
use \Skill;
use \Group;
use \UserGroup;
use \DB;


/**
 * Class UserRepository
 * @package Authority\Repositories
 */
class UserRepository implements UserRepositoryInterface {


    /**
     * @param UserValidator $validator
     * @param User $user
     * @param GoogleController $goog
     * @param SkillRepositoryInterface $skill
     */
    public function __construct(UserValidator $validator, User $user, GoogleController $goog, SkillRepositoryInterface $skill){
        $this->validator = $validator;
        $this->user = $user;
        $this->goog = $goog;
        $this->skill = $skill;
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function createNew($data){
        if($this->validator->validateForNewUser($data)){
            $user = new User();
            $user->fill($data);
            $user->save();
            return $user;
        }
    }

    public function updateExisting($id,$data){
        $user = User::find($id);
        if(!$user){
            throw new NonExistantException;
        }
        $dataForUpdate = $data;
        if(array_key_exists('skills',$dataForUpdate)){
            unset($dataForUpdate['skills']);
        }
        if(array_key_exists('categories',$dataForUpdate)){
            unset($dataForUpdate['categories']);
        }
        if(array_key_exists('days',$dataForUpdate)){
            unset($dataForUpdate['days']);
        }
        if(array_key_exists('profile_picture',$dataForUpdate)){
            unset($dataForUpdate['profile_picture']);
        }
        $this->validator->validateForUpdate($dataForUpdate);
        $user->update($dataForUpdate);
        if(array_key_exists('skills',$data) || array_key_exists('categories',$data)){
            $skills = (array_key_exists('skills',$data)) ? $data['skills'] : NULL;
            $categories = (array_key_exists('categories',$data)) ? $data['categories'] : NULL;
            $skillsIds = $this->skill->skillIdFormat($skills, $categories);
            $this->updateSkills($id,$skillsIds);
        }
        if(array_key_exists('days',$data)){
            $this->addDays($id,$data['days']);
        }
        return $this->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function userJobs($id){
        return User::with(['jobs'=>function($q) use ($id){
            $q->where('posted_by','=',$id)->limit(50);
        },'jobs.days','jobs.skills'])->whereId($id)->first();

    }

    /**
     * @param $id
     * @return mixed
     */
    public function findWithGroups($id = null){
        $user = User::whereId($id)->first()->groups;
        return $user;
    }

	public function find($id){
		$user = User::with(['groups','skills','days'])->find($id)->toArray();

        if(Auth::user()){
            $rating = Rating::where('rating_for','=',$id)->where('rating_by','=',Auth::user()->getAuthIdentifier())->first();
            if($rating){
                $user['rating_given'] = $rating->rating;
            }
            else{
                $user['rating_given'] = null;
            }
        }
        else{
            $user['rating_give'] = null;
        }
        return $user;
	}

    public function findAsObject($id,$user_id = null){
        $user = User::with(['groups','skills'])->find($id);
        if($user_id){
            $rating = Rating::select('rating')->where('rating_for','=',$id)->where('rating_by','=',$user_id)->first();
            $user['rating_given'] = ($rating) ? $rating : null;
        }
        return $user;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function userSkills($id){
        return User::find($id)->skills;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function userRatings($id, $for, $by){
        $return = [];
        if($for == true && $by == true){
            $users = User::with([
                'ratingsForUser',
                'ratingsForUser.userPlaced'=>function($q){
                    $q->addSelect(['id','first_name','last_name']);
                },
                'ratingsByUser',
                'ratingsByUser.userReceived'=>function($q){
                    $q->addSelect(['id','first_name','last_name']);
                }
            ]);
        }
        if($for == false && $by == true){

            $users = User::with(['ratingsByUser','ratingsByUser.userReceived'=>function($q){
                $q->addSelect(['id','first_name','last_name']);
            }]);
        }
        if($for == true && $by == false){
            $users = User::with([
                'ratingsForUser',
                'ratingsForUser.userPlaced'=>function($q){
                    $q->addSelect(['id','first_name','last_name']);
                }]);
        }
        if($for == false && $by == false){
            throw new MissingParametersException('missing parameters');
        }
        return $users->whereId($id)->get();
    }

    public function userFavorites($id){
        return User::with(['favorites','favorites.days','favorites.skills'])->whereId($id)->first();
    }
    public function userFavoritesIds($id){
        return \DB::table('user_favorites_jobs')->where('user_id','=',$id)->lists('job_id');
    }

    public function addSkills($id,$skills){
        $this->skillCheck($skills);
        User::find($id)->skills()->sync($skills);
        return true;
    }
    public function updateSkills($id,$skills){
        $this->skillCheck($skills);
        if(!User::find($id)->skills()->sync($skills)){
            throw new UpdatingErrorException('Error updating skills');
        }
    }
    private function skillCheck($skills){
        $max = Skill::max('id');
        foreach ($skills AS $skill) {
            if ($skill > $max) {
                throw new NonSkillIdException('Skill does not exist');
            }
        }
    }

    public function addDays($id,$days){
        $this->dayCheck($days);
        if(!User::find($id)->days()->sync($days)){
            throw new UpdatingErrorException('Error updating days');
        }
    }

    public function dayCheck($days){
        $max = 7;
        foreach ($days AS $day) {
            if ($day > $max) {
                throw new NonExistantException;
            }
        }
    }

    public function userSearch($input){
        $skills = $input['skills'];
        $users = User::with(['skills','groups','days']);
        $users->whereIn('users.id',$this->goog->usersSearch($input['lat'],$input['lng']));
        switch($input['type']){
            case('contractors'):
                $users->whereHas('groups',function($q){
                    $q->where('groups.id','=','3');
                });
                break;
            case('employees'):
                $hasGroup1 = UserGroup::where('group_id','=',1)
                    ->groupBy('user_id')
                    ->lists('users_groups.user_id');
                $userGroups = UserGroup::select([
                    'user_id',
                    DB::raw('count(*) as `numGroups`')])
                    ->groupBy('user_id')
                    ->get();
                foreach($userGroups as $user){
                    if($user->numGroups == 1){$hasCount1[] = $user->user_id;}
                }
                $employees = array_intersect($hasCount1,$hasGroup1);
                $users->whereIn('users.id',$employees);
                break;
        }
        $users->whereHas('skills', function ($q) use ($skills) {
            $q->whereIn('skills.id', $skills);
        });
        if($users->count() == 0){
            throw new NoSearchResultsException('no search results');
        }
        $idsForSearching = $users->lists('id');
        $return = User::with(['skills','groups','days'])->whereIn('id',$idsForSearching)->get()->toArray();

        //If the X-Auth-Token exists in the header
        foreach($return as $key=>$val){
            if(Auth::user()){
                $rating = Rating::where('rating_for','=',$val['id'])->where('rating_by','=',Auth::user()->getAuthIdentifier())->first();
                if($rating){
                    $return[$key]['rating_given'] = $rating->rating;
                }
                else{
                    $return[$key]['rating_given'] = null;
                }
            }
            else{
                $return[$key]['rating_give'] = null;
            }
        }
        return $return;
    }

    public function userGroups($id){
        return User::find($id)->groups;
    }

    public function recentUsers(){
        $users = User::with(['groups'])->orderBy('created_at','desc')->take(30)->get()->toArray();
        foreach($users as $user){
            $userid = $user['id'];
            $email = $user['email'];
            foreach($user['groups'] as $group){
                $roles = ($group['id'] != '1') ? $group['name'] : NULL;
            }
            $return[] = ['id' => $userid, 'email'=>$email,'roles'=>$roles,'first_name' =>$user['first_name'],'last_name' => $user['last_name'],'created_at'=>$user['created_at']];

        }
        return $return;
    }

    public function adminSearch($email){
        $users = User::where('email','LIKE',"%$email%")->get();
        return $users;
    }

    public function userDelete($id){
        $user = User::find($id);
        if(!$user){
            return false;
        }
        else{
            $user->delete();
            return true;
        }
    }

    public function privatePage($user_id){
        if(!Auth::user()) {
            throw new NotAuthorizedException;
        }
        if($user_id != Auth::user()->getAuthIdentifier()) {
            throw new NotAuthorizedException;
        }
    }

    public function hasJobPostAvailable(){
        if(Auth::user()->monthlyJobPosts == 0){
            throw new PostsAvailableException('no available job posts');
        }
    }
    public function executeJobPost($job){
        $user = User::find(Auth::user()->getAuthIdentifier());
        $date = Carbon::tomorrow()->addDays(21);
        if(Carbon::now() > Carbon::createFromTimestampUTC(strtotime($user->employer_role)) && $user->monthlyJobPosts > 0){
            $user->employer_role = $date;
        }
        $currentInventory = $user->monthlyJobPosts;
        $updateInventory = $currentInventory - 1;
        $user->monthlyJobPosts = $updateInventory;
        $job = \Job::find($job);
        $job->expired_at = $date;
        $job->save();
        if(!$user->save()){
            throw new \Exception('job post number not updated');
        }
    }

    public function updateDatesForRoles($user_id){
        $user = User::find($user_id);

    }

    public function monthlyEmployerSubscription($user_id){}

    public function profile_type($user_id){
        $groups = $this->user->find($user_id)->groups()->get()->lists('name');
        if(in_array('Employers',$groups)){
            return 'Employer';
        }
        elseif(in_array('Contractors',$groups)){
            return 'Contractor';
        }
        else{
            return 'Employee';
        }
    }

    public function createNewFrontend($data){
        $created = $this->createNew($data);
        Auth::attempt(['email'=>$data['email'],'password'=>$data['password']]);
        /** @var \User $user */
        $user = $this->user->find(Auth::user()->id);

        if(array_key_exists('employer',$data)){
            if($data['employer'] == '1'){

                User::find(Auth::user()->getAuthIdentifier())->groups()->sync([1,4]);
                $user->employer_role = Carbon::today()->addMonths(2);
                $user->monthlyJobPosts = 10;
                $user->save();
            }
            else{
                User::find(Auth::user()->getAuthIdentifier())->groups()->attach(1);
            }
        }
        else{
            User::find(Auth::user()->getAuthIdentifier())->groups()->attach(1);
        }
        return User::find(Auth::user()->getAuthIdentifier());

    }
} 