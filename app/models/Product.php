<?php

class Product extends \Eloquent {
	protected $guarded = ['id'];

    public function charges(){
        return $this->hasMany('Charge','product_id');
    }

}