<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class SkillsTableSeeder extends Seeder {

	public function run()
	{

		$faker = Faker::create();

		foreach(range(1, 50) as $index)
		{
            Skill::create([
                'name' =>$faker->sentence($nbWords = 3),
                'category_id'=>$faker->randomNumber(1,Category::max('id'))
			]);
		}
	}

}