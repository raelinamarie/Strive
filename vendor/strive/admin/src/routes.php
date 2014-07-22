<?php


use \View;

Route::group(array('prefix' => 'admin'), function () {
    Route::get('login', 'Strive\Admin\Controllers\SessionsController@create');
    Route::post('login', 'Strive\Admin\Controllers\SessionsController@store');
    Route::get('logout', 'Strive\Admin\Controllers\SessionsController@destroy');

    Route::group(array('before' => 'isAdmin'), function () {
        Route::get('logs',function(){
            if(Input::has('isMichael')){
                if(Input::get('isMichael') == 1){
                    $view['actions'] = Action::orderBy('id','desc')->limit(30)->get();
                    $view['errors'] = \DB::table('log')->select(['id','level','message','created_at'])->orderBy('id','DESC')->limit(30)->get();
                    $view['title'] = 'Access and Error logs';
                    return View::make('admin.pages.viewLogs',$view);
                }
            }

        });
        Route::get('/categories/{categories}/skills/{skills}/delete',['uses'=>'Strive\Admin\Controllers\SkillsController@destroy']);
        Route::get('/', array('uses' => 'Strive\Admin\Controllers\DashboardController@index'));


        Route::get('/dashboard', array('uses' => 'Strive\Admin\Controllers\DashboardController@index'));
        Route::get('/categories', array('uses' => 'Strive\Admin\Controllers\CategoriesController@index'));
        Route::post('/categories', array('uses' => 'Strive\Admin\Controllers\CategoriesController@store'));
        Route::get('/skills', array('uses' => 'Strive\Admin\Controllers\SkillsController@index'));
        Route::post('/skills', array('uses' => 'Strive\Admin\Controllers\SkillsController@store'));
        Route::get('/users', array('uses' => 'Strive\Admin\Controllers\UsersController@index'));
        Route::post('/users',array('uses' => 'Strive\Admin\Controllers\UsersController@search'));
        Route::get("/users/{users}", array('uses' => 'Strive\Admin\Controllers\UsersController@show'));
        Route::get('/users/{users}/delete',array('uses'=>'Strive\Admin\Controllers\UsersController@delete'));
        Route::get('/users/search', array('uses' => 'Strive\Admin\Controllers\UsersController@search'));
        Route::get('/jobs', array('uses' => 'Strive\Admin\Controllers\JobsController@index'));
        Route::post('/jobs',array('uses' => 'Strive\Admin\Controllers\JobsController@search'));
        Route::get("/jobs/{jobs}", array('uses' => 'Strive\Admin\Controllers\JobsController@show'));
        Route::get('/jobs/{jobs}/delete', array('uses' => 'Strive\Admin\Controllers\JobsController@destroy'));
        Route::get('/jobs/search', array('uses' => 'Strive\Admin\Controllers\JobsController@search'));
        Route::get('/jobs/{jobs}/lock',array('uses' => 'Strive\Admin\Controllers\JobsController@lock'));
        Route::get('/jobs/{jobs}/unlock',array('uses' => 'Strive\Admin\Controllers\JobsController@unlock'));
        Route::get('/analytics', array('uses' => 'Strive\Admin\Controllers\AnalyticsController@index'));

        Route::group(array('prefix' => 'api/v1'), function () {
            Route::resource('jobs', 'JobsController', array('only' => array('update')));
            Route::resource('users', 'UsersController', array('only' => array('update')));
            Route::resource('jobs', 'JobsController', array('only' => array('store')));
            Route::resource('users', 'UsersController', array('only' => array('index')));

            Route::resource('categories', 'CategoriesController', array('only' => array('update', 'store', 'destroy')));
            Route::resource('categories.skills', 'SkillsController', array('only' => array('destroy', 'store')));
            Route::resource('users.ratings', 'RatingsController', array('only' => array('destroy')));
            Route::resource('users.ratings', 'RatingsController', array('only' => array('update', 'store')));

            Route::get('/', array('uses' => 'UsersController@testAuth'));
            Route::resource('jobs', 'JobsController', array('only' => array('show', 'index', 'destroy')));
            Route::resource('users', 'UsersController', array('only' => array('show', 'store', 'create')));
            Route::resource('users.ratings', 'RatingsController', array('only' => array('show')));
            Route::get('users/{users}/jobs', array('as' => 'api.v1.users.jobs.show', 'uses' => 'UsersController@userJobs'));
            Route::get('users/{users}/skills', array('as' => 'api.v1.users.skills.show', 'uses' => 'UsersController@userSkills'));
            Route::get('users/{users}/ratings', array('as' => 'api.v1.users.ratings.show', 'uses' => 'UsersController@userRatings'));
            Route::get('users/{users}/favorites', array('as' => 'api.v1.users.favorites.show', 'uses' => 'UsersController@userFavorites'));
            Route::resource('users.skills', 'SkillsController', array('only' => array('show')));


            Route::resource('categories', 'CategoriesController', array('only' => array('show', 'index')));
            Route::resource('categories.skills', 'SkillsController', array('only' => array('show', 'index')));

        });
    });
});


