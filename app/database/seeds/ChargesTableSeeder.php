<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Carbon\Carbon;
use \Product;
use \User;
use \Charge;
use \Sum;

class ChargesTableSeeder extends Seeder {

    public function run() {
        $faker = Faker::create();

        foreach (range(1, $_ENV['SEEDER_MAXCHARGES']) as $index) {
            $product = Product::find(rand(1,3));
            $monthly = ($product->billing_interval == 'month') ? 1 : 0;
            $charge = new Charge([
                'amount' => $product->amount,
                'monthly' => $monthly,
                'product_id' => $product->id
            ]);
            $cRand = rand(0,365);
            $created = ($cRand != 0)
                ? Carbon::today()->subDays($cRand)->toDateTimeString()
                : Carbon::today()->toDateTimeString();

            $user = User::find(rand(1,User::max('id')));
            $charge = $user->charges()->save($charge);
            $charge->created_at = $created;
            $charge->save();


            $date = Carbon::createFromFormat("Y-m-d H:i:s",$charge->created_at)->toDateString();
            $amount = $charge->amount;

            if(Sum::where('day','=',$date)->where('for','=','Charge')->get()->isEmpty()){
                Sum::create(['day'=>$date,'sum'=>$amount,'for'=>'Charge']);
            }
            else{
                Sum::updateSum($date,$amount,'Charge');
            }
            print 'Charge: '.$index.PHP_EOL;
        }
    }
}