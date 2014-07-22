<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class DaysTableSeeder extends Seeder {

    public function run() {

        $day = new Day();
        $day->day = 'sunday';
        $day->save();
        $day = new Day();
        $day->day = 'monday';
        $day->save();
        $day = new Day();
        $day->day = 'tuesday';
        $day->save();
        $day = new Day();
        $day->day = 'wednesday';
        $day->save();
        $day = new Day();
        $day->day = 'thursday';
        $day->save();
        $day = new Day();
        $day->day = 'friday';
        $day->save();
        $day = new Day();
        $day->day = 'saturday';
        $day->save();

    }
} 