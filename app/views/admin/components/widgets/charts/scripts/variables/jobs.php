<?php
$i = 0;
$len = count($jobs);
foreach($jobs AS $job){
    if($i == $len-1){
        echo "[".$job['time'].", ".$job['count']."]";
    }
    else{
        echo "[".$job['time'].", ".$job['count']."],";
    }
    $i++;
}
 