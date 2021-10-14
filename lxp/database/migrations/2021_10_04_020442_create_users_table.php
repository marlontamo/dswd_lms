<?php

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
			$table->char('uuid', 36);
			$table->string('first_name', 191)->nullable();
			$table->string('middle_name', 191)->nullable();
			$table->string('last_name', 191)->nullable();
			$table->string('email', 191)->unique();
			$table->string('username', 191)->unique();
			$table->string('dob', 191)->nullable();
			$table->string('phone', 191)->nullable();
			$table->string('gender', 191)->nullable();
			$table->text('address')->nullable();
			$table->string('province', 191)->nullable();
			$table->string('city', 191)->nullable();
			$table->string('barangay', 191)->nullable();
			$table->string('pincode', 191)->nullable();
			$table->string('state', 191)->nullable();
			$table->string('country', 191)->nullable();
			$table->string('avatar_type', 191)->default('gravatar');
			$table->string('avatar_location', 191)->nullable();
			$table->string('temp_password', 191)->nullable();
			$table->string('password', 191)->nullable();
			$table->dateTime('password_changed_at')->nullable();
			$table->boolean('active')->default(1);
			$table->string('confirmation_code', 191)->nullable();
			$table->boolean('confirmed')->default(0);
			$table->string('user_type', 50)->nullable();
			$table->string('position', 191)->nullable();
			$table->boolean('privacy');
			$table->string('timezone', 191)->nullable();
			$table->dateTime('last_login_at')->nullable();
			$table->string('last_login_ip', 191)->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('last_session');
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
