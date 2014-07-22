<?php namespace Strive\Admin\Controllers;

use Authority\Interfaces\CategoryRepositoryInterface;
use \Auth;
use Carbon\Carbon;
use \View;
use \Input;
use \API;
use \Queue;
use \Session;
use \Request;
use Authority\Interfaces\JobRepositoryInterface;
use \Job;
use \User;

class JobsController extends \BaseController {
    public function __construct(JobRepositoryInterface $job){
        $this->job = $job;
    }
    public function index() {
        $view['jobs'] = $this->job->recentJobs();
        $view['title'] = 'Manage Jobs';
        return View::make('admin.pages.manageJobs', $view);
    }

    public function destroy($id) {
        $job = \Job::find($id);
        if ($job) {
            $job->delete();
            return Redirect::to('/admin/jobs')->with('message', 'Job Deleted');
        }
    }

    public function show($id) {
        $job = Job::find($id);
        $skills = $job->skills->toArray();
        $skillList = [];
        $user = User::find($job->posted_by);
        $view['user'] = $user->toArray();
        $userSkills = $user->skills->toArray();
        $view['userjobs'] = $user->jobs;
        $uskills = [];
        foreach($userSkills as $skill){
            $uskills[] = $skill['name'];
        }
        foreach($skills as $skill){
            $skillList[] = $skill['name'];
        }
        $view['skillList'] = implode(',', $skillList);
        $view['userSkills'] = implode(',',$uskills);
        $created_at = $view['user']['created_at'];
        $view['user']['created_at'] = Carbon::createFromTimestampUTC(strtotime($view['user']['created_at']))->toDateString();
        $view['job'] = $job;
        $view['map'] = 'http://maps.googleapis.com/maps/api/staticmap?center=' . $job['lat'] . "," . $job['lng'] . "&zoom=14&size=240x360&maptype=roadmap&format=png&style=feature:all|element:labels|visibility:off&sensor=false&style=feature:water|element:geometry|visibility:simplified|color:0x5291C7&style=feature:landscape|element:geometry|visibility:simplified|color:0x6DBC66&style=feature:road%7Celement:geometry%7Cvisibility:simplified%7Ccolor:0xDFE8EC&style=feature:transit|element:geometry|visibility:off&style=feature:poi|element:geometry|visibility:off&key=AIzaSyD0GkPbrLY6n6ChJ0ZPdr4eUQqmFm4H48E";
        $view['title'] = 'View Job';
        return View::make('admin.pages.viewJob', $view);
    }

    public function search(){
        if(!Input::has('title')){
            return Redirect::to('/admin/jobs');
        }
        $title = Input::get('title');
        $view['jobs'] = Job::where('title','LIKE',"%$title%")->get();
        $view['title'] = 'Search Results';
        return View::make('admin.pages.jobSearch', $view);


    }

    public function lock($job_id){
        $job = Job::find($job_id);

        $job->update(['locked'=>1]);
        $view['jobs'] = $this->job->recentJobs();
        $view['title'] = 'Manage Jobs';
        return View::make('admin.pages.manageJobs', $view);

    }

    public function unlock($job_id){
        $job = Job::find($job_id);

        $job->update(['locked'=>0]);
        $view['jobs'] = $this->job->recentJobs();
        $view['title'] = 'Manage Jobs';
        return View::make('admin.pages.manageJobs', $view);

    }
} 