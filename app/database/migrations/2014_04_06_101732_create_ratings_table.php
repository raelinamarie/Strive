<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ratings', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('rating');
            $table->text('review')->nullable();
			$table->unsignedInteger('rating_by');
			$table->unsignedInteger('rating_for');
            $table->softDeletes();
			$table->timestamps();

            $table->foreign('rating_by')->references('id')->on('users');
            $table->foreign('rating_for')->references('id')->on('users');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ratings');
	}

}
