<?php
class Charge extends Eloquent{
    protected $guarded = ['id'];
    protected $softDelete = true;
    protected $table = 'charges';

    protected $dates = array('timestamp');

    public function user(){
        return $this->belongsTo('User','user_id');
    }

    public function product(){
        return $this->belongsTo('Product','product_id');
    }
}