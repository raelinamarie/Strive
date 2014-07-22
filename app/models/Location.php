<?php
/**
 * Created by PhpStorm.
 * User: hopkinsAppit
 * Date: 4/17/14
 * Time: 4:51 PM
 */

class Location extends Eloquent{

    protected $guarded = ['id'];
    protected $fillable = ['job_id','lat','lng'];
    public $timestamps = false;
} 