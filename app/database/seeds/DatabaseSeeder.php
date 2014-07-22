<?php

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call('SentryGroupSeeder');
        $this->call('CategoriesAndSkillsTableSeeder');
        $this->call('TestUsersSeeder');
        $this->call('DaysTableSeeder');
        $this->call('JobTableSeeder');
        $this->call('UsersTableSeeder');
        $this->call('FavoritesTableSeeder');
        $this->call('RatingsTableSeeder');
        $this->call('UpdateUsersRatings');
        $this->call('ProductsTableSeeder');
        #$this->call('LocationTableSeeder');
        $this->call('ChargesTableSeeder');
        $this->call('ActionsTableSeeder');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}