<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder {

	public function run()
	{
        Product::create([
            'name' => 'monthlyEmployer',
            'amount' => '50',
            'currency' => 'USD',
            'billing_interval' => 'month',
            'trial_period' => '30'
        ]);
        Product::create([
            'name' => 'monthlyContractor',
            'amount' => '5',
            'currency' => 'USD',
            'billing_interval' => 'month',
            'trial_period' => '30'
        ]);
        Product::create([
            'name' => 'singleJobPost',
            'amount' => '20',
            'currency' => 'USD',
            'billing_interval' => 'single'
        ]);
    }

}