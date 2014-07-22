<?php namespace Strive\Admin\Controllers;

use Authority\Interfaces\UserRepositoryInterface;
use \Auth;
use \Redirect;
use \View;
use \Input;
use \User;
use \API;
use \Queue;
use \Session;
use \Request;
use \Restable;
use Carbon\Carbon;

class UsersController extends \BaseController {
    public function __construct(UserRepositoryInterface $user){
        $this->user = $user;
    }
    public function index() {
        $view['users'] = $this->user->recentUsers();




        $view['title'] = 'Manage Users';
        return View::make('admin.pages.manageUsers', $view);
    }

    public function show($id) {
        $user = User::find($id);
        $view['user'] = $user;

        $userSkills = $user->skills->toArray();
        $view['userjobs'] = $user->jobs;
        $uskills = [];
        foreach($userSkills as $skill){
            $uskills[] = $skill['name'];
        }
        $view['userSkills'] = implode(',',$uskills);
        $view['user']['created_at'] = Carbon::createFromTimestampUTC(strtotime($view['user']['created_at']))->toDateString();



        $view['title'] = 'View User';

        return View::make('admin.pages.viewUser',$view);
    }

    public function search(){
        $view['email'] = Input::get('email');
        $view['users'] = $this->user->adminSearch($view['email']);

        $view['title'] = 'View User';
        return View::make('admin.pages.userSearch',$view);
    }

    public function delete($id){
        if($this->user->userDelete($id)){
            return Redirect::to('/admin/users')->with('message','User Deleted');
        }
        else{
            return Redirect::to('/admin/users')->with('message','User already deleted');
        }
    }
} 