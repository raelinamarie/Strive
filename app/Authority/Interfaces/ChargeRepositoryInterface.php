<?php namespace Authority\Interfaces;


interface ChargeRepositoryInterface {
    public function newCust($email);
    public function newOrder($user_id,$dataForCharge);
    public function getNewToken($data);
} 