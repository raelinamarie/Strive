<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder {
    public function run()
    {
        DB::connection()->disableQueryLog();
        $this->createUsers(34000000,43000000,-112000000,-98000000);
        $this->createUsers(36000000,45000000,-81000000,-67000000);

    }
    private function createUsers($latLow, $latHigh, $lngLow, $lngHigh){
        $faker = Faker::create();

        foreach(range(1, $_ENV['SEEDER_MAXUSERS']) as $index)
        {
            $email = $faker->email;
            $activated = $faker->boolean();
            $display_name = $faker->userName;
            $first_name = $faker->firstName;
            $last_name = $faker->lastName;
            $password = 'password';
            $phone_number = $faker->phoneNumber;
            $address1 = $faker->streetAddress;
            $city = $faker->city;
            $state = $faker->stateAbbr;
            $zip = $faker->postcode;
            $lat = number_format(mt_rand($latLow, $latHigh) / 1000000, 6);
            $lng = number_format(mt_rand($lngLow, $lngHigh) / 1000000, 6);
            $avg_rating = $faker->randomFloat(1,0,5);
            if($faker->boolean()) {$address2 = "";}
            else{$address2 = $faker->secondaryAddress;}

            $cRand = rand(0,60);
            $created = ($cRand != 0)
                ? Carbon::today()->subDays($cRand)->toDateTimeString()
                : Carbon::now()->toDateTimeString();

            $user = User::create([
                'email' => $email,
                'display_name' => $display_name,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'password' => $password,
                'phone_number' => $phone_number,
                'address1' => $address1,
                'address2' => $address2,
                'lat'=>$lat,
                'lng'=>$lng,
                'city' => $city,
                'state' => $state,
                'zip' => $zip,
                'avg_rating' => $avg_rating,
                'monthlyJobPosts' => 500
            ]);
            DB::table('users_groups')->insert(array('user_id'=>$user->id,'group_id'=>1));
            $roleRng = rand(1,4);
            if($roleRng == 2){
                DB::table('users_groups')->insert(array('user_id'=>$user->id,'group_id'=>3));
            }
            if($roleRng == 3){
                DB::table('users_groups')->insert(array('user_id'=>$user->id,'group_id'=>4));
            }
            if($roleRng == 4){
                $second = rand(1,2);
                if($second == 1){
                    DB::table('users_groups')->insert(array('user_id'=>$user->id,'group_id'=>3));
                    DB::table('users_groups')->insert(array('user_id'=>$user->id,'group_id'=>4));
                }
            }

            $skillIds = range(1, Skill::max('id'));
            shuffle($skillIds);
            $numSkills = rand(0,20);
            $usersSkills = array_slice($skillIds,0,$numSkills);
            $user->skills()->sync($usersSkills);
            $user->days()->sync([1,3,5,6]);
            $user->created_at = $created;
            $user->save();
            print 'User: '.$index.PHP_EOL;
        }
    }
}