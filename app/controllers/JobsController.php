<?php
use Authority\Interfaces\SkillRepositoryInterface;
use \Restable;
use Authority\AuthToken\Exceptions\NotAuthorizedException;
use Authority\Exceptions\MissingParametersException;
use Authority\Exceptions\NonSkillIdException;
use Authority\Exceptions\ValidationException;
use Authority\Exceptions\NonExistantException;
use Authority\Interfaces\JobRepositoryInterface;
use Authority\Service\LocationServices\GoogleController;
use Authority\Exceptions\NonAuthorizedDelete;
use Authority\Interfaces\UserRepositoryInterface;
use Authority\Exceptions\PostsAvailableException;

/**
 * Class JobsController
 */
class JobsController extends BaseController  {


    /**
     * @param JobRepositoryInterface $job
     * @param GoogleController $goog
     * @param UserRepositoryInterface $user
     * @param SkillRepositoryInterface $skill
     */
    public function __construct(JobRepositoryInterface $job, GoogleController $goog, UserRepositoryInterface $user,SkillRepositoryInterface $skill){
        $this->job = $job;
        $this->goog = $goog;
        $this->user = $user;
        $this->skill = $skill;
    }

    public function index(){
        if(!Input::has('lat') || !Input::has('lng')){
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
        if(Input::has('expired')){
            $search = (Input::get('expired') == 0)
                ? $this->job->jobSearchFilterExpired(['lat' => Input::get('lat'),'lng' => Input::get('lng'),'skills' => $skillsIds])
                : $this->job->jobSearchFilterNonExpired(['lat' => Input::get('lat'),'lng' => Input::get('lng'),'skills' => $skillsIds]);
        }
        else{
            $search = $this->job->jobSearch(['lat' => Input::get('lat'),'lng' => Input::get('lng'),'skills' => $skillsIds]);
        }
        return Restable::listing($search)->render();
    }

    public function store(){
        $days = (Input::has('days')) ? Input::get('days') : NULL;
        $skills = (Input::has('skills')) ? Input::get('skills') : NULL;
        $categories = (Input::has('categories')) ? Input::get('categories') : NULL;
        $skillsIds = ($skills != NULL || $categories != NULL) ? $this->skill->skillIdFormat($skills,$categories) : [] ;

        $input = Input::except(['skills','days','categories']);
        $this->user->hasJobPostAvailable();
        $job = $this->job->createNew($input,$skillsIds,$days);
        Event::fire('newJob',$job->id);
        return Restable::created($this->job->find($job->id))->render();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id){
        return Restable::single($this->job->find($id))->render();
    }

    /**
     * @param $id
     */
    public function edit($id)
	{
		//
	}

    /**
     * @param $id
     * @return mixed
     */
    public function update($user_id,$job_id){
        $this->user->privatePage($user_id);
        $job = $this->job->updateExisting($job_id,Input::all());
        return Restable::updated($job)->render();
	}

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($user_id,$job_id)
	{
        $this->job->delete($job_id);
        return Restable::deleted([])->render();
	}

    public function jobSkills($job_id){
        return Restable::listing($this->job->find($job_id)->skills)->render();
    }

    public function jobSkillsPost($job_id){
        if(!Input::get('skills')){
            return Restable::error('no skills passed')->render();
        }
        return Restable::created($this->job->addSkills($job_id, Input::only('skills')['skills']))->render();
    }

    public function jobUser($job_id){
        return Restable::single($this->job->find($job_id)->user)->render();
    }

    public function specialUpdate($job_id){
        $user_id = Job::find($job_id)->posted_by;
        $this->user->privatePage($user_id);
        $job = $this->job->updateExisting($job_id,Input::all());
        return Restable::single($job)->render();
    }


    //originally written because latitudes and longitudes get wonky when put into query strings due to the decimal point
    public function getRealGet()
    {
        if(!$_SERVER['QUERY_STRING']){
            throw new MissingParametersException('missing parameters');
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
    public function jobDays($job_id){
        return Restable::listing($this->job->find($job_id)->days)->render();
    }
}