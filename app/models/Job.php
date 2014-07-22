<?php
class Job extends Eloquent{
    protected $guarded = ['id'];
    protected $softDelete = true;

    public static function boot(){
        parent::boot();
        static::deleted(function($model){
            $model->favorites()->detach();
            $model->skills()->detach();
        });
    }

    public function user(){
        return $this->belongsTo('User','posted_by');
    }

    public function skills(){
        return $this->belongsToMany('Skill','job_skill','job_id','skill_id');
    }
    public function favorites(){
        return $this->belongsToMany('User','user_favorites_jobs','job_id','user_id');
    }
    public function days(){
        return $this->belongsToMany('Day','day_job','job_id','day_id');
    }



}