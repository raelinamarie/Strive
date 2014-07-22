<?php

use Authority\Service\LocationServices\GoogleController;
use Authority\Service\Workers\Observer;
use \Location;
use Authority\Interfaces\UserRepositoryInterface;
use \Product;
use Carbon\Carbon;

// Subscribe to User Mailer events
#Event::subscribe('Authority\Mailers\UserMailer');


#Event::listen('category.creating','Authority\Validation\CategoryValidator@fire');

Event::listen('auth.token.valid', function($user)
{
    //Token is valid, set the user on auth system.;
    Auth::setUser($user);
    Session::set('user_id',$user->id);
});

Event::listen('invoiceitem.created',function($payload){
    $charge = New Observer();
    $charge->invoiceitem_created($payload);
});

Event::listen('newJob',function($job_id){
    $goog = new GoogleController(new Location);
    $goog->addressSearch($job_id);
});

Event::listen('task.created', function($task)
{
    $managers = getManagersForThisTask($task);

    foreach($managers as $manager ){
        Event::fire('task.created_step2', $task, $manager );
    }
});

Event::listen('monthlyEmployerSubscription',function($user_id){
    $user = User::find($user_id);
    $inventory = 5;
    $employerRole = Carbon::tomorrow()->addMonth();
    $user->monthlyJobPosts = $inventory;
    $user->employer_role = $employerRole;
    $user->save();
});

