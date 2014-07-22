<?php
use \LaravelGuy;
class acceptanceCest
{
    public function _before()
    {
    }

    public function _after()
    {
    }

    // tests

    public function push_a_favorite_into_the_database_and_confirm_it_can_be_retrieved(LaravelGuy $I){
        $I->wantTo('verify that a single user has favorites');
        $id = $I->haveInDatabase('user_favorites_jobs',array('user_id'=>'1','job_id'=>'1'));
        $I->amOnPage("/api/v1/users/1/favorites");
        $I->see('title');
        $I->see('description');
    }







}