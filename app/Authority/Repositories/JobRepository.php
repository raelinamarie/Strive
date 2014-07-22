<?php namespace Authority\Repositories;

use Authority\Exceptions\NoSearchResultsException;
use Authority\Exceptions\UpdatingErrorException;
use Authority\Interfaces\JobRepositoryInterface;
use Authority\Exceptions\NonExistantException;
use Authority\Exceptions\NonAuthorizedDelete;
use Authority\Exceptions\NonSkillIdException;
use Authority\Exceptions\MissingParametersException;
use Authority\Interfaces\SkillRepositoryInterface;
use \Job;
use Authority\Validation\JobValidator;
use \Auth;
use \Skill;
use Authority\Service\LocationServices\GoogleController;
use Authority\Interfaces\UserRepositoryInterface;


/**
 * Class JobRepository
 * @package Authority\Repositories
 */
class JobRepository implements JobRepositoryInterface{
    /**
     * @param JobValidator $validator
     * @param Job $job
     * @param \Queue $queue
     * @param \Authority\Service\LocationServices\GoogleController $goog
     */
    public function __construct(JobValidator $validator, Job $job, \Queue $queue, GoogleController $goog, UserRepositoryInterface $user, SkillRepositoryInterface $skill){
        $this->validator = $validator;
        $this->job = $job;
        $this->queue = $queue;
        $this->goog = $goog;
        $this->user = $user;
        $this->skill = $skill;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id){
        return Job::with(['skills','days'])->where('id','=',$id)->first();
    }

    /**
     * @param null $user_id
     * @param null $active
     * @return array
     */
    public function getAll($user_id = NULL, $active = NULL){
        $return = ($user_id == NULL)
            ? ($active == NULL)
                ? Job::where('posted_by','=',$user_id)->get()
                : Job::where('posted_by','=',$user_id)->where('active','=',$active)->get()
            : ($active == NULL)
                ? Job::all()
                : Job::where('active','=',$active)->get();
        return $return->toArray();
    }

    public function jobSearch($input,$distance=10){
        $skills = $input['skills'];
        $jobs = Job::with(['skills']);
        $jobs->whereIn('jobs.id',$this->goog->search($input['lat'],$input['lng'],$distance));
        $jobs->whereHas('skills', function ($q) use ($skills) {
            $q->whereIn('skills.id', $skills);
        });
        if($jobs->count() == 0){
            throw new NoSearchResultsException('no search results');
        }
        $idsForSearching = $jobs->lists('id');
        $j = Job::with(['user','skills','days'])->whereIn('jobs.id',$idsForSearching)->get()->toArray();
        $favorites = (Auth::user()) ? $this->user->userFavoritesIds(Auth::user()->getAuthIdentifier()) : [];
        foreach($j as $key=>$val) {
            $j[$key]['stared'] = (in_array($val['id'], $favorites)) ? 1 : 0;
        }
        return $j;

    }
    public function jobSearchWithLimit($input,$distance=10){
        $skills = $input['skills'];
        $jobs = Job::with(['skills']);
        $jobs->whereIn('jobs.id',$this->goog->search($input['lat'],$input['lng'],$distance));
        $jobs->whereHas('skills', function ($q) use ($skills) {
            $q->whereIn('skills.id', $skills);
        });
        if($jobs->count() == 0){
            throw new NoSearchResultsException('no search results');
        }
        $idsForSearching = $jobs->lists('id');
        $j = Job::with(['skills','days'])->whereIn('jobs.id',$idsForSearching)->limit(30)->get()->toArray();
        $favorites = (Auth::user()) ? $this->user->userFavoritesIds(Auth::user()->getAuthIdentifier()) : [];
        foreach($j as $key=>$val) {
            $j[$key]['stared'] = (in_array($val['id'], $favorites)) ? 1 : 0;
        }
        return $j;

    }
    public function jobSearchFilterExpired($input,$distance=10){
        $skills = $input['skills'];
        $jobs = Job::with(['skills']);
        $jobs->whereIn('jobs.id',$this->goog->search($input['lat'],$input['lng'],$distance));
        $jobs->whereHas('skills', function ($q) use ($skills) {
            $q->whereIn('skills.id', $skills);
        });
        if($jobs->count() == 0){
            throw new NoSearchResultsException('no search results');
        }
        $idsForSearching = $jobs->lists('id');
        $j = Job::with(['user','skills','days'])->whereIn('jobs.id',$idsForSearching)->where('jobs.expired','=',0)->get()->toArray();
        $favorites = (Auth::user()) ? $this->user->userFavoritesIds(Auth::user()->getAuthIdentifier()) : [];
        foreach($j as $key=>$val) {
            $j[$key]['stared'] = (in_array($val['id'], $favorites)) ? 1 : 0;
        }
        return $j;

    }
    public function jobSearchFilterNonExpired($input,$distance=10){
        $skills = $input['skills'];
        $jobs = Job::with(['skills']);
        $jobs->whereIn('jobs.id',$this->goog->search($input['lat'],$input['lng'],$distance));
        $jobs->whereHas('skills', function ($q) use ($skills) {
            $q->whereIn('skills.id', $skills);
        });
        if($jobs->count() == 0){
            throw new NoSearchResultsException('no search results');
        }
        $idsForSearching = $jobs->lists('id');
        $j = Job::with(['user','skills','days'])->whereIn('jobs.id',$idsForSearching)->where('jobs.expired','=',1)->get()->toArray();
        $favorites = (Auth::user()) ? $this->user->userFavoritesIds(Auth::user()->getAuthIdentifier()) : [];
        foreach($j as $key=>$val) {
            $j[$key]['stared'] = (in_array($val['id'], $favorites)) ? 1 : 0;
        }
        return $j;

    }


    /**
     * @param $input
     */
    public function saveJob($input){

    }

    /**
     * @param $input
     */
    public function isValidForCreation($input){

    }

    /**
     * @param $data
     * @return mixed
     */
    public function createNew($data,$skills,$days){
        $input = $data;
        $input['posted_by'] = Auth::user()->getAuthIdentifier();
        $this->validator->validateForCreate($input);
        $j = Job::create($input);
        $job = $j->id;
        #$this->queue->push('Authority\Service\Workers\Modifier@locationIndexer',array('id'=>$job->id));
        if($skills != NULL){
            $j->skills()->sync($skills);
        }
        if($days != NULL) {
            $this->addDays($job,$days);
        }
        $this->user->executeJobPost($job);
        return Job::with(['days','skills'])->where('id','=',$job)->first();

    }

    /**
     * @param $job_id
     * @param $user_id
     * @return bool
     * @throws NonAuthorizedDelete
     * @throws \Authority\Exceptions\NonExistantException
     */
    public function delete($job_id){
        $job = Job::find($job_id);
        $this->user->privatePage($job->posted_by);
        if(!$job){
            throw new NonExistantException;
        }
        else{
            $job->delete();
            return true;
        }
    }

    /**
     * @param $data
     * @param $job_id
     * @return mixed
     * @throws \Authority\Exceptions\NonExistantException
     */
    public function updateExisting($job_id,$data){
        $job = $this->find($job_id);
        if(!$job){
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
        $this->validator->validateForUpdate($dataForUpdate);
        $job->fill($dataForUpdate)->save();
        if(array_key_exists('skills',$data) || array_key_exists('categories',$data)){
            $skills = (array_key_exists('skills',$data)) ? $data['skills'] : NULL;
            $categories = (array_key_exists('categories',$data)) ? $data['categories'] : NULL;
            $skillsIds = $this->skill->skillIdFormat($skills, $categories);
            $this->updateSkills($job_id,$skillsIds);
        }
        if(array_key_exists('days',$data)){
            $this->addDays($job->id,$data['days']);
        }
        return $this->find($job->id);

    }

    public function addSkills($id, $skills){
        $this->skillCheck($skills);
        Job::find($id)->skills()->sync($skills);
        return true;
    }

    public function addDays($id,$days){
        $this->dayCheck($days);
        if(!Job::find($id)->days()->sync($days)){
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

    public function updateSkills($job,$skills){
        $this->skillCheck($skills);
        if(!Job::find($job)->skills()->sync($skills)){
            throw new UpdatingErrorException('Error updating skills');
        }
    }

    /**
     * @param $skills
     * @throws \Authority\Exceptions\NonSkillIdException
     */
    private function skillCheck($skills)
    {
        $max = \Skill::max('id');
        foreach ($skills AS $skill) {
            if ($skill > $max) {
                throw new NonSkillIdException('Skill does not exist');
            }
        }
    }

    public function recentJobs(){
        return Job::orderBy('created_at','desc')->take(30)->get();
    }

    public function adminSearch($title){
        $users = \User::where('email','LIKE',"%$email%")->get();
        return $users;
    }


    /**
     * @return array
     */

} 