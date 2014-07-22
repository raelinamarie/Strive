<?php
$i = 0;
$len = count($hits);
foreach($hits AS $hit){
    if($i == $len -1){
        echo "[".$hit['time'].", ".$hit['count']."]";
    }
    else{
        echo "[".$hit['time'].", ".$hit['count']."],";
    }
    $i++;
}