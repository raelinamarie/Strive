<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChargesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('charges', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('user_id');
			$table->integer('amount');
            $table->boolean('monthly');
            $table->integer('product_id');
            $table->text('description');
            $table->softDeletes();
			$table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('charges');
	}

}
