<?php  namespace Controllers\Frontend;

use Auth;
use Authority\Interfaces\CategoryRepositoryInterface;
use Authority\Interfaces\JobRepositoryInterface;
use \View;

class JobsController extends BaseController{
    /** @var \Authority\Repositories\JobRepository  */
    protected $job;
    public function __construct(JobRepositoryInterface $job, CategoryRepositoryInterface $category){
        $this->category = $category;
        $this->job = $job;
    }
    public function index(){
        return View::make('frontend.pages.jobs.index');
    }

    public function show($job_id){
        $job = $this->job->find($job_id);
        $category = $this->category->find($job['skills'][0]['category_id'])->name;
        $canDelete = false;
        if(Auth::check()){
            if($job['posted_by'] == Auth::getUser()->getAuthIdentifier()){
                $canDelete = true;
            }
        }

        $view['canDelete'] = $canDelete;
        $view['jobCategory'] = $category;
        $view['job'] = $job;
        $view['title'] = 'Job Details';
        #echo "<pre>";
        #print_r($category);
        #echo "</pre>";
        return View::make('Frontend::jobs.index',$view);
    }

}