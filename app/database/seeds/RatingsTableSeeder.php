<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Carbon\Carbon;

class RatingsTableSeeder extends Seeder {

    function uniqueRand($n, $min = 1, $max = null)
    {
        if($max === null)
            $max = getrandmax();
        $array = range($min, $max);
        $return = array();
        $keys = array_rand($array, $n);
        foreach($keys as $key)
            $return[] = $array[$key];
        return $return;
    }

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, $_ENV['SEEDER_MAXUSERS']) as $index)
		{
            $users = $this->uniqueRand(7,1,User::max('id'));
            $cRand = rand(0,365);
            $created = ($cRand != 0)
                ? Carbon::today()->subDays($cRand)->toDateTimeString()
                : Carbon::today()->toDateTimeString();


            foreach($users as $user) {
                if($faker->boolean()){
                    $review = $faker->sentence(100);
                }
                else{
                    $review = NULL;
                }
                $rating = Rating::create([
                    'rating' => rand(0,5),
                    'rating_for' => $user,
                    'rating_by' => $index,
                    'review' => $review
                ]);
                $rating->created_at = $created;
                $rating->save();

                $date = Carbon::createFromFormat("Y-m-d H:i:s",$rating->created_at)->toDateString();
                $amount = 1;

                if(Sum::where('day','=',$date)->where('for','=','Rating')->get()->isEmpty()){
                    Sum::create(['day'=>$date,'sum'=>$amount,'for'=>'Rating']);
                }
                else{
                    Sum::updateSum($date,$amount,'Rating');
                }
            }
            print 'Rating: '.$index.' - '.$_ENV['SEEDER_MAXUSERS'].PHP_EOL;
		}
	}

}