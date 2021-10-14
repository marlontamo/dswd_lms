<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseStudentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_student', function(Blueprint $table)
		{
			$table->integer('course_id')->unsigned()->nullable()->index('course_student_course_id_foreign');
			$table->integer('user_id')->unsigned()->nullable()->index('course_student_user_id_foreign');
			$table->integer('rating')->unsigned()->default(0);
			$table->timestamps();
			$table->integer('evaluation')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('course_student');
	}

}
