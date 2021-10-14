<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLessonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lessons', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('course_id')->unsigned()->nullable()->index('54419_596eedbb6686e');
			$table->string('title', 191)->nullable();
			$table->string('slug', 191)->nullable();
			$table->string('lesson_image', 191)->nullable();
			$table->text('short_text', 65535)->nullable();
			$table->text('full_text', 65535)->nullable();
			$table->integer('position')->unsigned()->nullable();
			$table->boolean('published')->nullable()->default(0);
			$table->timestamps();
			$table->softDeletes()->index();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lessons');
	}

}
