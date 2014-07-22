<?php
use Carbon\Carbon;

class Sum extends \Eloquent {
    protected $guarded = ['id'];
    protected $dates = array('day');
    protected $table = 'sums';

    public function hasDayBeenSet($date,$for){
        $sum = Sum::where('day','=',$date)->where('for','=',$for)->get();
        if($sum->isEmpty()){
            return false;
        }
        else{
            return true;
        }
    }
    public static function updateSum($date,$amount,$for){
        $sum = Sum::where('day','=',$date)->where('for','=',$for)->first();
        $currentAmount = $sum->sum;
        $sum->sum = $currentAmount+$amount;
        $sum->save();
    }
}