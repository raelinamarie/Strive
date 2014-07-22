<?php
$i = 0;
$len = count($sales);
sort($sales);
foreach($sales AS $sale){
    if($i == $len -1){
        echo "[".$sale['time'].", ".$sale['sum']."]";
    }
    else{
        echo "[".$sale['time'].", ".$sale['sum']."],";
    }
    $i++;
}