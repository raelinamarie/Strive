<?php  namespace Controllers\Frontend;

use Auth;
use Authority\Interfaces\CategoryRepositoryInterface;
use Authority\Interfaces\GMapsInterface;
use Authority\Interfaces\JobRepositoryInterface;
use Authority\Interfaces\SkillRepositoryInterface;
use Authority\Interfaces\UserRepositoryInterface;
use Authority\Service\LocationServices\GMaps;
use Authority\Service\LocationServices\GoogleController;
use Category;
use Input;
use Location;
use Skill;
use \View;

class DashboardController extends BaseController{
    protected $gmaps;
    /** @var \Authority\Repositories\JobRepository  */
    protected $job;

    /**
     * @param GMapsInterface $gmaps
     * @param JobRepositoryInterface $job
     * @param CategoryRepositoryInterface $category
     * @param SkillRepositoryInterface $skill
     * @param UserRepositoryInterface $user
     * @param GoogleController $goog
     */
    public function __construct(GMapsInterface $gmaps, JobRepositoryInterface $job, CategoryRepositoryInterface $category, SkillRepositoryInterface $skill, UserRepositoryInterface $user, GoogleController $goog){
        $this->skill = $skill;
        $this->category = $category;
        $this->job = $job;
        $this->user = $user;
        $this->goog = $goog;
        $this->mapForContractorTab = new GMaps();
        $this->mapForEmployerTab = new GMaps();
        $this->mapForEmployeeTab = new GMaps();
    }
    public function index(){
        $config = array();
        $config['center'] = 'auto';
        $config['class'] = 'map';

        $lat = 39.7187471;
        $lng = -104.9474792;
        $type = 'homePage';

        $skillsIds = Skill::all()->lists('id');
        $categories = Category::all();
        $jobResults = $this->job->jobSearchWithLimit(['lat' => $lat,'lng' => $lng,'skills' => $skillsIds]);
        foreach($jobResults as $job => $content){
            $categoryId = $content['skills'][0]['category_id'];
            $jobResults[$job]['category'] = $categories->get($categoryId);
        }
        $contractors = $this->user->userSearch(['lat' => $lat,'lng' => $lng,'skills' => $skillsIds,'type'=>$type]);
        $employees = $this->user->userSearch(['lat' => $lat,'lng' => $lng,'skills' => $skillsIds,'type'=>$type]);
        $mapForContractor = $this->getMapForContractorTab([]);
        $mapForEmployer = $this->getMapForEmployerTab([]);
        $mapForEmployee = $this->getMapForEmployeeTab([]);

        $view['categories'] = $categories;

        $view['mapForContractorTab'] = $mapForContractor;
        $view['mapForEmployerTab'] = $mapForEmployer;
        $view['mapForEmployeeTab'] = $mapForEmployee;
        $view['jobResults'] = [];
        $view['title'] = 'Strive Connect';
        $view['loggedInUser'] = (Auth::check()) ? Auth::user() : [];
        return View::make('Frontend::home.index',$view);
    }

    public function indexWithData(){
        $config = array();
        $config['center'] = 'auto';
        $config['class'] = 'map';

        $latlng = (Input::get('zip') != 0) ? $this->goog->get_lat_long_zip(Input::get('zip')) : ['lat'=>'39.7187312','lng'=>'-104.9491342'];
        $skillsIds = (Input::get('category_id' != 0)) ? Skill::where('category_id','=',Input::get('category_id'))->get()->lists('id') : Skill::all()->lists('id');
        $type = 'contractor';
        $radius = (Input::get('radius') != 0) ? Input::get('radius') : 25;
        $data = ['lat'=>$latlng['lat'],'lng'=>$latlng['lng'],'skills'=>$skillsIds,'type'=>$type,'distance' => $radius];
        $categories = Category::all();
        $jobResults = $this->job->jobSearchWithLimit(['lat' => $data['lat'],'lng' => $data['lat'],'skills' => $data['skills']],$data['distance']);
        foreach($jobResults as $job => $content){
            $categoryId = $content['skills'][0]['category_id'];
            $jobResults[$job]['category'] = $categories->get($categoryId);
        }
        $contractors = $this->user->userSearch(['lat' => $data['lat'],'lng' => $data['lat'],'skills' => $data['skills'],'type'=>$type],$data['distance']);
        $employees = $this->user->userSearch(['lat' => $data['lat'],'lng' => $data['lat'],'skills' => $data['skills'],'type'=>$type],$data['distance']);
        $mapForContractor = $this->getMapForContractorTab($contractors);
        $mapForEmployer = $this->getMapForEmployerTab($jobResults);
        $mapForEmployee = $this->getMapForEmployeeTab($employees);

        $view['categories'] = $categories;

        $view['mapForContractorTab'] = $mapForContractor;
        $view['mapForEmployerTab'] = $mapForEmployer;
        $view['mapForEmployeeTab'] = $mapForEmployee;
        $view['jobResults'] = $jobResults;
        $view['title'] = 'Strive Connect';
        $view['loggedInUser'] = (Auth::check()) ? Auth::user() : [];
        return View::make('Frontend::home.index',$view);
    }

    /**
     * @param $contractors
     * @return array
    @internal param $jobs
     */
    public function getMapForContractorTab($contractors) {
        $config = array();
        $config['center'] = 'auto';
        $config['zoom'] = 'auto';
        $config['cluster'] = TRUE;
        $config['map_name'] = 'map_contractor';
        $config['map_div_id'] = 'map_canvas_contractor';
        $map = new GMaps();
        $map->initialize($config);
        foreach($contractors as $contractor) {
            $marker = [];
            $marker['position'] = $contractor['lat'].", ".$contractor['lng'];
            $map->add_marker($marker);
        }
        return $map->create_map();
    }
    public function getMapForEmployeeTab($users) {
        $config = array();
        $config['center'] = 'auto';
        $config['zoom'] = 'auto';
        $config['cluster'] = TRUE;
        $config['map_name'] = 'map_employee';
        $config['map_div_id'] = 'map_canvas_employee';
        $map = new GMaps();
        $map->initialize($config);
        foreach($users as $user) {
            $marker = [];
            $marker['position'] = $user['lat'].", ".$user['lng'];
            $map->add_marker($marker);
        }
        return $map->create_map();

    }
    public function getMapForEmployerTab($jobs) {
        $config = array();
        $config['center'] = 'auto';
        $config['zoom'] = 'auto';
        $config['cluster'] = TRUE;
        $config['map_name'] = 'map_employer';
        $config['map_div_id'] = 'map_canvas_employer';
        $map = new GMaps();
        $map->initialize($config);
        foreach($jobs as $job) {
            $marker = [];
            $location = Location::find($job['id']);
            $marker['position'] = $location['lat'].", ".$location['lng'];
            $map->add_marker($marker);
        }
        return $map->create_map();
    }
}