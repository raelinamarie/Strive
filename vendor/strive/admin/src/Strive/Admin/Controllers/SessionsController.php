<?php namespace Strive\Admin\Controllers;

use Auth;
use Illuminate\Support\Facades\Validator;
use \View;
use Input;
use \Redirect;
use Authority\Validation\Forms\Login;
use Authority\Exceptions\FormValidationException;
use \Queue;
use \Request;
use \Session;

class SessionsController extends BaseController {
    protected $loginForm;

    public function __construct(Login $loginForm){
        $this->loginForm = $loginForm;
    }
    public function create() {
        $view['title'] = 'Login';
        $userId = (!Auth::user()) ? NULL : Auth::user()->getAuthIdentifier();
        Queue::push('\Authority\Service\Workers\Observer@newAction', array('action' => 'Admin Page', 'uri' => Request::path(), 'method' => Request::method(), 'user_id' => $userId, 'session' => Session::GetId()));
        return View::make('admin.layouts.login', $view);
    }

    public function store() {
        #$this->loginForm->validate(Input::all());

        $validator = \Validator::make(Input::all(),['email' => 'required|email','password' => 'required']);
        if($validator->fails()){
            return Redirect::back()->withInput(Input::all())->withErrors($validator);
        }

        $userData = [
            'email' => Input::get('email'),
            'password' => Input::get('password')
        ];
        if(!Auth::attempt($userData)){
            return Redirect::back();
        }
        else{
            return Redirect::to('/admin/dashboard');
        }


    }

    public function destroy() {
        if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')))) {
            $userId = (!Auth::user()) ? NULL : Auth::user()->getAuthIdentifier();
            Queue::push('\Authority\Service\Workers\Observer@newAction', array('action' => 'Admin Page', 'uri' => Request::path(), 'method' => Request::method(), 'user_id' => $userId, 'session' => Session::GetId()));
            return Redirect::to('admin/dashboard')->with('message', 'Thanks for logging in');
        }

        $userId = (!Auth::user()) ? NULL : Auth::user()->getAuthIdentifier();
        Queue::push('\Authority\Service\Workers\Observer@newAction', array('action' => 'Admin Page', 'uri' => Request::path(), 'method' => Request::method(), 'user_id' => $userId, 'session' => Session::GetId()));
        return Redirect::to('admin/users/login')->with('message', 'Your email/password combo was incorrect');
    }
}