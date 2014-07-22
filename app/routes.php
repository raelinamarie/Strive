<?php
//Routes utilized by the API

use Carbon\Carbon;

Route::get('testjoin',function(){
    $return = User::select('users.first_name','users.last_name','users.address1','users.city','users.state','users.zip')->find(15);
    echo "<pre>";
    print_r($return);
    echo "</pre>";
});

Route::group(['namespace'=>'Controllers\Frontend'],function(){
    Route::post('/',['uses'=>'DashboardController@indexWithData']);
    Route::get('/',['uses'=>'DashboardController@index']);
    Route::post('login',['uses'=>'SessionsController@store']);
    Route::get('logout',function(){
        Auth::logout();
        return Redirect::to('/');
    });
    Route::get('register',['as'=>'register','uses'=>'UsersController@create']);
    Route::post('register',['as'=>'register.store','uses'=>'UsersController@store']);
    Route::group(['before'=>'isLoggedIn'],function(){
        Route::post('availability',['as'=>'availability.update','uses'=>'UsersController@updateAvailability']);
        Route::post('updateProfile',['as'=>'profile.update','uses'=>'UsersController@updateProfile']);
        Route::get('profile',['as'=>'users.profile','uses'=>'UsersController@index']);
        Route::resource('jobs','JobsController',['only'=>['create','store']]);
        Route::get('favorites',['as'=>'favorites','uses'=>'FavoritesController@index']);
        Route::get('/users/{users}/favorites/{job}',['as'=>'users.favorites.add','uses'=>'FavoritesController@userFavoritesSwitch']);
        Route::get('pricing',['as'=>'pricing','uses'=>'DashboardController@pricingView']);
    });
    Route::get('maps',['uses'=>'DashboardController@maps']);
    Route::resource('jobs','JobsController',['only'=>['index','show']]);
    Route::resource('users','UsersController',['only'=>['show']]);
});


Route::post('queue/post', function () {
    Queue::marshal();
});
Route::group(array('prefix' => 'api/v1','before'=>'PublicPageSugar|roleIntegrityCheck','after' => 'apiCall'), function () {
    Route::get('/flush',function(){
        Auth::logout();
        Session::flush();
    });
    Route::post('stripe/webhook', 'WebhooksController@handleWebhook');
    Route::post('register', array('uses' => 'UsersController@store'));
    Route::post('login', array('uses' => 'SessionsController@store'));
    Route::get('logout', array('uses' => 'SessionsController@delete'));
    Route::group(array('before' => 'auth.token'), function () {
        Route::match(['PUT','POST'],'users/{users}/profile',['uses'=>'UsersController@profileUpload']);
        Route::resource('users', 'UsersController', array('only' => array('update','show')));
        Route::resource('users.jobs', 'JobsController', array('only' => array('update','destroy')));
        #Route::resource('jobs','JobsController',['only' => ['update','destroy']]);
        Route::put('/jobs/{jobs}',['uses'=>'JobsController@specialUpdate']);
        Route::resource('users.charges','ChargesController',array('only' => array('create','store')));
        Route::post('users/{users}/favorites',array('as','api.v1.users.favorites.store','uses'=>'UsersController@userFavoritesPost'));
        Route::delete('users/{users}/favorites/{favorites}',array('as','api.v1.users.favorites.destroy','uses'=>'UsersController@userFavoritesDelete'));
        Route::get('users/{users}/grantemployer',array('as'=>'api.v1.users.grantemployer','uses'=>'UsersController@grantemployer'));
        Route::get('users/{users}/grantcontractor',array('as'=>'api.v1.users.grantcontractor','uses'=>'UsersController@grantcontractor'));
        Route::get('users/{users}/grantemployee',array('as'=>'api.v1.users.grantemployee','uses'=>'UsersController@grantemployee'));
        Route::post('users/{users}/addPosts',['as'=>'api.v1.users.addPosts','uses'=>'UsersController@addPosts']);
        Route::resource('users.ratings', 'RatingsController', array('only' => array('update', 'store','destroy')));
        Route::delete('users/{users}/subscriptions',array('as','api.v1.users.subscriptions.cancel','uses'=>'SubscriptionsController@destroy'));
        Route::group(array('before' => 'canPostJob'), function () {
            Route::resource('jobs', 'JobsController', array('only' => array('store')));
        });

        Route::group(array('before' => 'isApiAdmin'), function () {
            Route::resource('categories', 'CategoriesController', array('only' => array('update', 'store', 'destroy')));
            Route::resource('categories.skills', 'SkillsController', array('only' => array('destroy', 'store')));
        });
    });
    Route::resource('users.jobs', 'JobsController', ['only' => ['show']]);
    Route::resource('jobs', 'JobsController', array('only' => array('show', 'index')));
    Route::resource('users', 'UsersController', array('only' => array('index','store', 'create')));
    Route::resource('users.ratings', 'RatingsController', array('only' => array('show')));
    Route::get('users/{users}/jobs', array('as' => 'api.v1.users.jobs.show', 'uses' => 'UsersController@userJobs'));
    Route::get('users/{users}/skills', array('as' => 'api.v1.users.skills.show', 'uses' => 'UsersController@userSkills'));
    Route::get('users/{users}/ratings', array('as' => 'api.v1.users.ratings.show', 'uses' => 'UsersController@userRatings'));
    Route::get('users/{users}/favorites', array('as' => 'api.v1.users.favorites.show', 'uses' => 'UsersController@userFavorites'));
    Route::get('users/{users}/groups',array('as' => 'api.v1.users.groups.show','uses'=>'UsersController@userGroups'));
    Route::resource('users.skills', 'SkillsController', array('only' => array('show')));
    Route::resource('categories', 'CategoriesController', array('only' => array('show', 'index')));
    Route::resource('categories.skills', 'SkillsController', array('only' => array('show', 'index')));
    Route::get('jobs/{jobs}/skills',array('as','api.v1.jobs.skills.show','uses'=>'JobsController@jobSkills'));
    Route::get('jobs/{jobs}/users',array('as','api.v1.jobs.users.show','uses'=>'JobsController@jobUser'));
    Route::get('jobs/{jobs}/days',array('as','api.v1.jobs.days.show','uses'=>'JobsController@jobDays'));
    Route::post('jobs/{jobs}/skills',array('as','api.v1.jobs.skills.store','uses'=>'JobsController@jobsSkillsPost'));
    Route::resource('products','ProductsController',array('only'=>array('index')));
    Route::resource('groups','GroupsController',array('only'=>array('index')));
    Route::get('categoriesskills',array('as','api.v1.categories.skills.showall','uses'=>'CategoriesController@showAllGrouped'));
    Route::post('translate','TranslationsController@index');
    Route::get('/newurl',['uses'=>'RatingsController@testMath']);

    Route::get('updateJobs',function(){
        $jobs = Job::all();
        foreach($jobs as $job){
            if($job->expired == 1){
                $j = Job::find($job->id);
                $j->expired_at = Carbon::createFromFormat("Y-m-d H:i:s",$job->created_at)->addDays(21)->toDateTimeString();
                $j->save();
            }
        }
    });
});