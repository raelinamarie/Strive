<?php

class UserGroup extends Eloquent{
    protected $guarded = ['id'];

    protected $table = 'users_groups';

    public function users(){
        return $this->belongsTo('User','user_id');
    }
    public function groups(){
        return $this->belongsTo('Group','group_id');
    }

} 