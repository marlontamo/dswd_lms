<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tests', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('course_id')->unsigned()->nullable()->index('54422_596eeef514d00');
			$table->integer('lesson_id')->unsigned()->nullable()->index('54422_596eeef53411a');
			$table->string('title', 191)->nullable();
			$table->text('description', 65535)->nullable();
			$table->boolean('published')->nullable()->default(0);
			$table->string('slug', 191)->nullable();
			$table->integer('overall_score')->nullable();
			$table->integer('passing_score')->nullable();
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
		Schema::drop('tests');
	}

}
