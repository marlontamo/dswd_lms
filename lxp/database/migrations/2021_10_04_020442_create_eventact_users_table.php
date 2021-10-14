<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventactUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('eventact_users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('eventact_id')->unsigned()->nullable()->index('chapter_students_model_type_model_id_index');
			$table->integer('user_id')->unsigned()->nullable()->index('chapter_students_user_id_foreign');
			$table->integer('event_id')->unsigned()->nullable()->index('chapter_students_course_id_foreign');
			$table->integer('evaluation')->nullable()->default(0)->comment('0-did not answer evaluation, 1- answered evaluation.');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('eventact_users');
	}

}
