<?php
use \ApiGuy;


class ApiTestingCest
{
    public function _before()
    {
    }

    public function _after()
    {
    }

    // tests
    public function attemp_to_post_a_new_job(ApiGuy $I)
    {
        $I->wantTo('confirm that I can post a new job');
        $I->sendPOST('/login',['email'=>'jobposter@strive.com','password'=>'password']);
        $token = $I->grabDataFromJsonResponse('token');
        $I->haveHttpHeader('X-Auth-Token',$token);
        $I->sendPOST('/jobs',['title'=>'asdfasdfgf dsf adsf dsfg asdf adsfd','max_payrate'=>'35','description'=>'asdfasdfgf dsf adsf dsfg asdf adsfdasdfasdfgf dsf adsf dsfg asdf adsfdasdfasdfgf dsf adsf dsfg asdf adsfdasdfasdfgf dsf adsf dsfg asdf adsfdasdfasdfgf dsf adsf dsfg asdf adsfd','address1'=>'1150 Galapago Street','city'=>'Denver','state'=>'CO','contact_email'=>'jobposter@strive.com','skills[]'=>'2','skills[]'=>'5']);
        $I->seeResponseContains('jobposter@strive.com');
        $I->seeHttpHeader('Content-Type','application/json');
        $I->seeResponseContains('"contact_email":"jobposter@strive.com"');

    }

    public function attempt_to_edit_a_job(ApiGuy $I){
        $I->wantTo('confirm that I can edit a Job that I have posted');
        $I->sendPOST('/login',['email'=>'jobposter@strive.com','password'=>'password']);
        $token = $I->grabDataFromJsonResponse('token');
        $user_id = $I->grabDataFromJsonResponse('id');

        $id = $I->haveInDatabase('jobs',['posted_by'=>$user_id,'title'=>'asdfasdfgf dsf adsf dsfg asdf adsfd','max_payrate'=>'35','description'=>'asdfasdfgf dsf adsf dsfg asdf adsfdasdfasdfgf dsf adsf dsfg asdf adsfdasdfasdfgf dsf adsf dsfg asdf adsfdasdfasdfgf dsf adsf dsfg asdf adsfdasdfasdfgf dsf adsf dsfg asdf adsfd','address1'=>'1150 Galapago Street','city'=>'Wasco','state'=>'IL','contact_email'=>'jobposter@strive.com']);

        $letters = range('a','z');
        $title = '';
        for($i=0;$i<20;$i++){
            $title .= $letters[rand(0,25)];
        }

        $I->haveHttpHeader('X-Auth-Token',$token);
        $I->sendPUT("/jobs/$id",['title'=>$title]);
        $I->seeResponseContains($title);

    }

    public function confirm_200_when_loading_categories(ApiGuy $I){
        $I->wantTo('confirm a successful page load when getting categories');
        $I->sendGET('/categories');
        $I->canSeeResponseCodeIs(200);
    }

    public function confirm_200_when_loading_a_single_category(ApiGuy $I){
        $I->wantTo('confirm successful page load when viewing a category');
        $I->sendGET('/categories/1');
        $I->canSeeResponseCodeIs(200);
    }

    public function confirm_200_when_searching_jobs_based_on_latitude_and_longitude(ApiGuy $I){
        $I->wantTo('confirm successful page load when searching for jobs');
        $I->sendGet('/jobs',array('lat'=>'39.73915','lng'=>'-104.9847'));
        $I->canSeeResponseCodeIs(200);
    }

    public function create_new_user_in_database_by_using_the_register_endpoint(ApiGuy $I){
        $I->wantTo('register a new user');
        $letters = range('a','z');
        $email = '';
        for($i=0;$i<10;$i++){
            $email .= $letters[rand(0,25)];
        }
        $email .= '@gmail.com';
        $I->sendPOST('/register',array('email'=>$email,'password'=>'password','password_confirmation'=>'password'));
        $I->canSeeResponseCodeIs(201);
    }

    public function retrieve_a_single_user_and_confirm_200(ApiGuy $I)
    {
        $I->wantTo('verify that a single user is returned');
        $I->sendGET('/users/10');
        $I->canSeeResponseCodeIs(200);
    }

    public function confirm_200_when_requesting_a_users_skills(ApiGuy $I){
        $I->wantTo('confirm a successful page load for a users skills');
        $I->sendGET('/users/5/skills');
        $I->canSeeResponseCodeIs(200);
    }

    public function confirm_200_when_requesting_a_users_associated_jobs(ApiGuy $I){
        $I->wantTo('confirm a successful page load for a users jobs');
        $I->sendGET('/users/5/jobs');
        $I->canSeeResponseCodeIs(200);
    }

    public function confirm_200_when_retrieving_ratings_of_user(ApiGuy $I){
        $I->wantTo('confirm a successful page load for a users ratings');
        $I->sendGET('/users/5/ratings');
        $I->canSeeResponseCodeIs(200);
    }

    public function confirm_200_when_searching_user_base_by_latitude_and_longitude(ApiGuy $I)
    {
        $I->wantTo('verify that a 200 is returned when searching');
        $I->sendGET('/jobs',array('lat'=>'39.73915','lng'=>'-104.9847'));
        $I->canSeeResponseCodeIs(200);
    }

    public function update_the_users_first_name_via_a_put_request(ApiGuy $I){
        $I->wantTo('update a user profile that I will belong to');
        $I->sendPOST('/login',['email'=>'jobposter@strive.com','password'=>'password']);
        $token = $I->grabDataFromJsonResponse('token');
        $id = $I->grabDataFromJsonResponse('id');
        $letters = range('a','z');
        $first_name = '';
        for($i=0;$i<10;$i++){
            $first_name .= $letters[rand(0,25)];
        }

        $I->haveHttpHeader('X-Auth-Token',$token);
        $I->haveHttpHeader('Content-Type','application/x-www-form-urlencoded');
        $I->sendPUT("/users/$id",['first_name'=>$first_name]);
        $I->seeResponseContains($first_name);

    }

    public function confirm_200_when_retrieving_skills_of_category(ApiGuy $I)
    {
        $I->wantTo('verify that a 200 is returned when getting skills of a category are returned');
        $I->sendGET('/categories/1/skills');
        $I->canSeeResponseCodeIs(200);
    }


}