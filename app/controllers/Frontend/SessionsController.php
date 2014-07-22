<?php namespace Controllers\Frontend;
/*
 * User: tappleby
 * Date: 2013-05-11
 * Time: 11:26 PM
 */

use Auth;
use Illuminate\Routing\Controller;
use Authority\Interfaces\SessionsAuthTokenInterface;
use Input;
use Redirect;
use Restable;
use Session;
use View;


/**
 * Class SessionsController
 */
class SessionsController extends Controller {
    /**
     * @param SessionsAuthTokenInterface $auth
     */
    public function __construct(SessionsAuthTokenInterface $auth){
        $this->auth = $auth;
    }
    public function index(){
        return View::make('frontend.demo.login');


    }
    public function store(){
        if(Input::has('email') && Input::has('password')) {
            if(Auth::attempt(['email'=>Input::get('email'),'password'=>Input::get('password')])){
                return Redirect::back()->with('message','Successfully logged in');
            }
            return Redirect::back()->with('message','Something went wrong');
        }
    }
    public function delete(){
        Auth::logout();
        Session::flush();
        Session::regenerate();
        return Restable::deleted()->render();
    }

}