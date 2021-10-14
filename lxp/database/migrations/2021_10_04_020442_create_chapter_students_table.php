<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChapterStudentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chapter_students', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('model_type', 191)->nullable();
			$table->bigInteger('model_id')->unsigned()->nullable();
			$table->integer('user_id')->unsigned()->nullable()->index('chapter_students_user_id_foreign');
			$table->integer('course_id')->unsigned()->nullable()->index('chapter_students_course_id_foreign');
			$table->timestamps();
			$table->index(['model_type','model_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('chapter_students');
	}

}
