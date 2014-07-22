<?php

class SentryGroupSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Group::create([
            'name' => 'Users'
        ]);

        Group::create([
            'name' => 'Admins'
        ]);

        Group::create([
            'name' => 'Contractors'
        ]);

        Group::create([
            'name' => 'Employers'
        ]);
	}

}