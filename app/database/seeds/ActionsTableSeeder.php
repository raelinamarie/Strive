<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Carbon\Carbon;

class ActionsTableSeeder extends Seeder {

    public function run() {
        $faker = Faker::create();

        foreach (range(1, $_ENV['SEEDER_MAXACTIONS']) as $index) {
            $action = Action::create([
                'action' => 'API query',
                'uri' => 'admin/login',
                'method' => 'GET',
                'user_id' => rand(1,\User::max('id'))
            ]);
            $cRand = rand(0,365);
            $created = ($cRand != 0)
                ? Carbon::today()->subDays($cRand)->toDateTimeString()
                : Carbon::now()->toDateTimeString();
            $action->created_at = $created;
            $action->save();
            print 'Action: '.$index.PHP_EOL;
        }

    }
}