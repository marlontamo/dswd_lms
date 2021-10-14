<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLessonTimeControlTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lesson_time_control', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->nullable();
			$table->integer('lesson_id')->nullable();
			$table->string('time_first_visit', 30)->nullable();
			$table->string('time_stop', 30)->nullable();
			$table->integer('time_spent')->nullable()->comment('seconds');
			$table->string('updated_at', 30)->nullable();
			$table->string('created_at', 30)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lesson_time_control');
	}

}
