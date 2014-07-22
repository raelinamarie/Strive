<?php
$ratings = $ratingsBreakdown;
$i = 0;
$len = count($ratings);
foreach($ratings as $rate){
    if($i == $len -1){
        echo "[".$rate['time'].", ".$rate['average']."]";
    }
    else{
        echo "[".$rate['time'].", ".$rate['average']."],";
    }
    $i++;
}