<?php
$i = 0;
$len = count($signups);
foreach($signups AS $signup){
    if($i == $len -1){
        echo "[".$signup['time'].", ".$signup['count']."]";
    }
    else{
        echo "[".$signup['time'].", ".$signup['count']."],";
    }
    $i++;
}