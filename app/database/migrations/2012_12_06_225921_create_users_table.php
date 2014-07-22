<?php
/**
 * Part of the Sentry package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Sentry
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('remember_token')->nullable();
			$table->string('email');
			$table->string('password');
			$table->boolean('activated')->default(0);
			$table->string('activation_code')->nullable();
			$table->timestamp('activated_at')->nullable();
			$table->timestamp('last_login')->nullable();
			$table->string('reset_password_code')->nullable();
			$table->string('first_name')->nullable();
            $table->integer('max_payrate')->nullable();
            $table->integer('duration_start')->nullable();
            $table->integer('duration_end')->nullable();
			$table->string('last_name')->nullable();
            $table->string('display_name')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->text('description')->nullable();
            $table->boolean('hourly')->default(0);
            $table->boolean('single_day')->default(0);
            $table->float('lat',10,6);
            $table->float('lng',10,6);
            $table->dateTime('employer_role')->default(Carbon::yesterday());
            $table->dateTime('contractor_role')->default(Carbon::yesterday());
            $table->tinyInteger('stripe_active')->default(0);
            $table->string('stripe_id')->nullable();
            $table->string('stripe_plan', 25)->nullable();
            $table->string('last_four', 4)->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('subscription_ends_at')->nullable();
            $table->integer('monthlyJobPosts')->default(10)->nullable();
            $table->timestamp('lastJobPost')->nullable();
            $table->integer('total_ratings')->default(0)->nullable();
            $table->decimal('avg_rating',2,1)->default(0);
            $table->boolean('locked')->default(0);
            $table->boolean('reported')->default(0);

            $table->softDeletes();
            $table->timestamps();

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';
			$table->index('activation_code');
			$table->index('reset_password_code');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
