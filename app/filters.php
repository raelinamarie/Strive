<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use \Authority\AuthToken\Exceptions\NotAuthorizedException;
use \Authority\Exceptions\PostsAvailableException;


App::error(function (ModelNotFoundException $e) {
    Bugsnag::notifyException($e);
    return Restable::missing()->render();
});

App::error(function (AuthTokenNotAuthorizedException $exception) {
    Bugsnag::notifyException($exception);
    return Restable::unauthorized()->render();
});

App::missing(function ($exception) {
    Bugsnag::notifyException($exception);
    return Restable::missing()->render();
});



App::before(function ($request) {
    #if( ! Request::secure()){return Redirect::secure(Request::getRequestUri());}
});


App::after(function ($request, $response) {
    //
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/


/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function () {
    if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function () {
    // var_dump($_SESSION);
    //            var_dump($_POST);
    //            die();

    // TODO: Rewrite this tree of conditionals
    if (Session::token() !== Input::get('_token') || Session::token() === null || Input::get('_token') === null) {
        // Session token and form tokens do not match or one is empty
        if (App::environment() === 'testing') {
            // We only want to allow CSRF override if we're running tests
            if (Input::get('IgnoreCSRFTokenError') === true) {
                // Allow CSRF override in testing environment
                return;
            } else {
                // Handle CSRF normally
                throw new Illuminate\Session\TokenMismatchException;
            }
        } else {
            // @codeCoverageIgnoreStart

            // Handle CSRF normally
            throw new Illuminate\Session\TokenMismatchException;

            // @codeCoverageIgnoreEnd
        }
    }
});
Route::filter('isApiAdmin', function($request, $response){
    $result = DB::table('users_groups')->join('groups','users_groups.group_id','=','groups.id')->select('users_groups.group_id')->where('users_groups.user_id','=',Auth::user()->getAuthIdentifier())->where('groups.name','=','Admins')->get();
    if(!$result){
        throw new NotAuthorizedException();
    }
});

Route::filter('isEmployer', function ($request, $response) {
    $result = DB::table('users_groups')->join('groups', 'users_groups.group_id', '=', 'groups.id')->select('users_groups.group_id')->where('users_groups.user_id', '=', Auth::user()->getAuthIdentifier())->where('groups.name', '=', 'Employers')->get();
    $otherResult = DB::table('users')->select('monthlyJobPosts')->where('id','=',Auth::user()->getAuthIdentifier())->where('monthlyJobPosts','>','0')->get();
    if (!$result && !$otherResult) {
        throw new NotAuthorizedException();
    }
});

Route::filter('isContractor', function ($request, $response) {
    $result = DB::table('users_groups')->join('groups', 'users_groups.group_id', '=', 'groups.id')->select('users_groups.group_id')->where('users_groups.user_id', '=', Auth::user()->id)->where('groups.name', '=', 'Contractors')->get();
    if (!$result) {
        throw new NotAuthorizedException();
    }
});

Route::filter('roleIntegrityCheck', function ($request, $response) {
    if(Auth::user()){}
});

Route::filter('apiCall',function($request,$response){
    if(Auth::user()){
        $userId = Auth::user()->getAuthIdentifier();
    }
    else{
        $userId = NULL;
    }
    $action = (Session::get('action')) ? Session::get('action') : 'API query';
    $messages = (Session::get('messages')) ? Session::get('messages') : NULL;
    $description = (Session::get('description')) ? Session::get('description') : NULL;
    $payload = (Session::get('payload')) ? Session::get('payload') : NULL;
    Queue::push('\Authority\Service\Workers\Observer@newAction',array('action'=>$action,'uri'=>Request::path(),'method'=>Request::method(),'description'=>$description,'messages'=>$messages,'payload'=>$payload,'user_id'=>$userId,'session'=>Session::GetId()));
});

Route::filter('PublicPageSugar',function($request,$response){
    $payload = Request::header('X-Auth-Token');
    //If the X-Auth-Token exists in the header
    if($payload){
        $user = AuthToken::validate($payload);

        if ($user) {
            Event::fire('auth.token.valid',$user);
        }
    }
});

Route::filter('canPostJob',function($request,$response){
    if(Auth::user()->monthlyJobPosts == 0){
        throw new PostsAvailableException('no available posts');
    }
});

Route::filter('isLoggedIn',function($request,$response){
    if(!Auth::check()){
        return Redirect::to('/')->with('message','you must be logged in');
    }
});