<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class FavoritesTableSeeder extends Seeder {
    public function run()
    {

        $users = User::all();
        $users->each(function($user){
            $faker = Faker::create();
            if($faker->boolean()){
                $jobIds = range(1,Job::max('id'));
                shuffle($jobIds);
                $numFavs = rand(1,5);
                $userFavs = array_slice($jobIds,1,$numFavs);
                $user->favorites()->sync($userFavs);
            }
        });
    }
}