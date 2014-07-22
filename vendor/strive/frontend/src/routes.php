<?php

Route::group(['namespace'=>'Strive\Frontend\Controllers'],function(){
    Route::get('/',['uses'=>'DashboardController@index']);
    Route::get('maps',['uses'=>'DashboardController@maps']);
    
    Route::resource('jobs','JobsController',['only'=>['index','show','create','store']]);
    Route::resource('users','UsersController',['only'=>['show']]);
    #Route::get('/memberships','ChargesController@create');
    #Route::post('/memberships','ChargesController@store');
    route::get('/test/', function(){
        $view['title'] = 'title';
        return View::make('frontend.pages.home',$view);
    });
    
    route::get('/test/create', function(){
        $view['title'] = 'title';
        return View::make('frontend.pages.jobs.create',$view);
    });
    
    
    route::get('/test/job', function(){
        $view['title'] = 'title';
        return View::make('frontend.pages.jobs.show',$view);
    });
});