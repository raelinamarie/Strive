<?php
/*
 * User: tappleby
 * Date: 2013-05-11
 * Time: 11:26 PM
 */

use Illuminate\Routing\Controller;
use Authority\Interfaces\SessionsAuthTokenInterface;


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
        Auth::logout();
        Session::regenerate();
        Session::flush();

        if(Input::has('email') && Input::has('password')) {
            $response = $this->auth->store(['username' => Input::get('email'), 'password' => Input::get('password')]);
            $toUpdate = User::with(['groups'])->where('id','=',$response['id'])->first();
            $user = $toUpdate->toArray();
            $user['token'] = $response['token'];
            if (Input::has('lat') && Input::has('lng')) {
                $toUpdate->lat = Input::get('lat');
                $toUpdate->lng = Input::get('lng');
                $toUpdate->save();
            }
            return Restable::single($user)->render();
        }
    }
    public function delete(){
        Auth::logout();
        Session::flush();
        Session::regenerate();
        return Restable::deleted()->render();
    }

}