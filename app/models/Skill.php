<?php
class Skill extends Eloquent{
    protected $guarded = ['id'];
	protected $fillable = ['name','category_id'];


    protected $softDelete = true;
    public static function boot(){
        parent::boot();

        static::deleted(function($model){
            $model->users()->detach();
            $model->jobs()->detach();
        });
        //http://strive.dev/api/v1/users/10/skills
        //skill 17
        //delete skill via skill delete url
        //make sure skill has been removed
    }




    public function category(){
        return $this->belongsTo('Category','category_id');
    }

    public function jobs(){
        return $this->belongsToMany('Job','job_skill','skill_id','job_id');
    }

    public function users(){
        return $this->belongsToMany('User','skill_user','skill_id','user_id');
    }
}