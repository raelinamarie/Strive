<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class TestUsersSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $userEmail = 'user@strive.com';
        $jobEmail = 'employer@strive.com';
        $serviceEmail = 'contractor@strive.com';
        $adminEmail = 'admin@strive.com';


        User::create([
            'email' => $userEmail,
            'activated' => 1,
            'display_name' => $faker->userName,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'phone_number' => $faker->phoneNumber,
            'address1' => $faker->streetAddress,
            'city' => $faker->city,
            'stripe_id' => 'cus_3yrm3MxUVYBrdI',
            'monthlyJobPosts' => 500,
            'state' => $faker->stateAbbr,
            'zip' => $faker->postcode,
            'avg_rating' => $faker->randomFloat(1,0,5),
            'password' => 'password'
        ]);
        User::create([
            'email' => $jobEmail,
            'activated' => 1,
            'stripe_id' => 'cus_3yrnNc3gxU9wD9',
            'display_name' => $faker->userName,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'phone_number' => $faker->phoneNumber,
            'address1' => $faker->streetAddress,
            'monthlyJobPosts' => 500,
            'city' => $faker->city,
            'state' => $faker->stateAbbr,
            'zip' => $faker->postcode,
            'avg_rating' => $faker->randomFloat(1,0,5),
            'password' => 'password',
            'employer_role'=>'2015-04-01 01:01:01'
        ]);
        User::create([
            'email' => $serviceEmail,
            'activated' => 1,
            'display_name' => $faker->userName,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'phone_number' => $faker->phoneNumber,
            'monthlyJobPosts' => 500,
            'address1' => $faker->streetAddress,
            'city' => $faker->city,
            'state' => $faker->stateAbbr,
            'zip' => $faker->postcode,
            'stripe_id' => 'cus_3yroubRJnPJ5fO',
            'avg_rating' => $faker->randomFloat(1,0,5),
            'password' => 'password',
            'contractor_role'=>'2015-04-01 01:01:01'
        ]);

        User::create([
            'email' => $adminEmail,
            'activated' => 1,
            'display_name' => $faker->userName,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'phone_number' => $faker->phoneNumber,
            'address1' => $faker->streetAddress,
            'city' => $faker->city,
            'state' => $faker->stateAbbr,
            'zip' => $faker->postcode,
            'avg_rating' => $faker->randomFloat(1,0,5),
            'password' => 'password'
        ]);
        DB::table('users_groups')->insert(array('user_id'=>1,'group_id'=>1));
        DB::table('users_groups')->insert(array('user_id'=>2,'group_id'=>1));
        DB::table('users_groups')->insert(array('user_id'=>3,'group_id'=>1));
        DB::table('users_groups')->insert(array('user_id'=>2,'group_id'=>4));
        DB::table('users_groups')->insert(array('user_id'=>3,'group_id'=>3));
        DB::table('users_groups')->insert(array('user_id'=>4,'group_id'=>1));
        DB::table('users_groups')->insert(array('user_id'=>4,'group_id'=>2));
        DB::table('users_groups')->insert(array('user_id'=>4,'group_id'=>3));
        DB::table('users_groups')->insert(array('user_id'=>4,'group_id'=>4));

    }

}