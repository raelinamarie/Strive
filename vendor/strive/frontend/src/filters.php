<?php

Route::filter('isFrontend', function($request, $response){
        if(!Auth::check()){
            return Redirect::to('/frontend/login');
        }
        $result = DB::table('users_groups')->join('groups','users_groups.group_id','=','groups.id')->select('users_groups.group_id')->where('users_groups.user_id','=',Auth::user()->getAuthIdentifier())->where('groups.name','=','Frontends')->get();
        if(!$result){
            return Redirect::to('/frontend/login');
        }
    });