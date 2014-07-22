<?php

Route::filter('isAdmin', function($request, $response){
    Auth::loginUsingId(4);
    /*if(!Auth::check()){
        return Redirect::to('/admin/login');
    }


    $result = DB::table('users_groups')->join('groups', 'users_groups.group_id', '=', 'groups.id')->select('users_groups.group_id')->where('users_groups.user_id', '=', Auth::user()->getAuthIdentifier())->where('groups.name', '=', 'Admins')->get();
    if (!$result) {
        return Redirect::to('/admin/login');
    }*/

});