<?php
class Category extends Eloquent{
    protected $guarded = ['id'];
    protected $softDelete = true;
    protected $table = 'categories';

    public function skills(){
        return $this->hasMany('Skill','category_id');
    }

    public static function boot(){
        parent::boot();

        static::deleted(function($model){
            Skill::destroy($model->skills()->lists('id'));
        });
    }
}