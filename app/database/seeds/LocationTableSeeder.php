<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class LocationTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        foreach(range(1, 10) as $index)
        {
            $lat = number_format(mt_rand(36998900, 41107100)/1000000, 6);
            $lng = number_format(mt_rand(-109092900, -101964000)/1000000, 6);
            Location::create(array('job_id'=>$faker->randomNumber(5),'lat'=>$lat,'lng'=>$lng));
        }
    }
}