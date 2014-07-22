<?php
class Rating extends Eloquent{
	protected $fillable = ['rating','rating_for','rating_by','review'];
    public static $rules = array(
        'rating' => 'required|numeric|max:5|min:0',
        'rating_for' => 'required|numeric|exists:users,id',
        'review' => 'max:500|min:10'
    );
    protected $softDelete = true;

    public function userPlaced(){
        return $this->belongsTo('User','rating_by');
    }
    public function userReceived(){
        return $this->belongsTo('User','rating_for');
    }
}