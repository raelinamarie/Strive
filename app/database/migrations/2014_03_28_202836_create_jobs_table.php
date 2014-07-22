<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('jobs', function(Blueprint $table) {
			$table->increments('id');
            $table->unsignedInteger('posted_by');
			$table->string('title');
			$table->string('description');
			$table->integer('max_payrate');
            $table->boolean('hourly')->default(0);
            $table->boolean('single_day')->default(0);
            $table->integer('duration_start')->nullable();
            $table->integer('duration_end')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
			$table->string('location')->nullable();
			$table->string('address1')->nullable();
            $table->string('address2')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('zip')->nullable();
            $table->boolean('expired')->default(0);
            $table->timestamp('expired_at')->nullable();
            $table->dateTime('date_closed')->nullable();
            $table->boolean('locked')->default(0);
            $table->boolean('reported')->default(0);
            $table->softDeletes();
			$table->timestamps();

            $table->foreign('posted_by')->references('id')->on('users');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('jobs');
	}

}
