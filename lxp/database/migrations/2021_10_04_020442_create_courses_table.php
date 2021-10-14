<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id')->unsigned()->nullable()->index('courses_category_id_foreign');
			$table->string('title', 191);
			$table->string('slug', 191)->nullable();
			$table->text('description', 65535)->nullable();
			$table->string('course_image', 191)->nullable();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->integer('duration_days')->nullable();
			$table->string('user_type', 50)->nullable();
			$table->integer('featured')->nullable()->default(0);
			$table->string('prerequisite', 150)->nullable();
			$table->text('meta_title', 65535)->nullable();
			$table->text('meta_description')->nullable();
			$table->text('meta_keywords')->nullable();
			$table->boolean('published')->nullable()->default(0);
			$table->timestamps();
			$table->softDeletes()->index();
			$table->integer('pes_id')->nullable();
			$table->text('smes', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('courses');
	}

}
