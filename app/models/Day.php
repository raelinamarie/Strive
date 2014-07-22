<?php
class Day extends Eloquent{
    protected $guarded = ['id'];
    protected $table = 'days';

    public function jobs(){
        return $this->belongsToMany('Job','day_job','day_id','job_id');
    }

    public function users(){
        return $this->belongsToMany('User','day_user','day_id','user_id');
    }
}