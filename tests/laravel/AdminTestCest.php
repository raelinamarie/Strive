<?php
use \LaravelGuy;

class AdminTestCest
{
    public function _before()
    {
    }

    public function _after()
    {
    }

    public function login_to_the_admin_portal(LaravelGuy $I)
    {
        $I->wantTo('login to the admin portal successfully');
        $I->amOnPage('/admin/login');
        $I->submitForm('//*[@id="login_form"]',['email'=>'admin@strive.com','password'=>'password']);
        $I->seeInCurrentUrl('/admin/dashboard');
    }

    public function add_new_category_to_admin_portal(LaravelGuy $I){
        $I->wantTo('add a new category from the admin portal');
        $I->amLoggedAs(User::find(4));
        $I->amOnPage('/admin/skills');
        $I->submitForm('//*[@id="category_create"]',['name'=>'testNewCategory']);
        $I->see('Category Added');
    }

    public function add_new_skill_to_category(LaravelGuy $I){
        $I->wantTo('add a new skill to a given category');
        $I->amLoggedAs(User::find(4));
        $I->amOnPage('/admin/skills');
        $I->fillField('//*[@id="skill_create_name"]','testNewSkill');
        $I->click('#skill_create_submit');
        $I->see('Skill Added');
    }

    public function delete_job_using_admin_panel(LaravelGuy $I){
        $I->wantTo("delete a skill from the database");
        $I->amLoggedAs(User::find(4));
        $job_id = $I->haveInDatabase('jobs',['title'=>'deleteThisJob','description'=>'description about deleting jobs','posted_by'=>4]);
        $I->amOnPage('/admin/jobs');

        $I->click("ec2-54-186-4-2.us-west-2.compute.amazonaws.com/admin/api/v1/jobs/$job_id/delete");
        $I->dontSee('deleteThisJob');
    }
}