<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseTimelineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_timeline', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('model_type', 191)->nullable();
			$table->bigInteger('model_id')->unsigned()->nullable();
			$table->integer('course_id');
			$table->integer('sequence');
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
		Schema::drop('course_timeline');
	}

}
