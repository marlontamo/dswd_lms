<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_user', function(Blueprint $table)
		{
			$table->integer('course_id')->unsigned()->nullable()->index('fk_p_54418_54417_user_cou_596eece522b73');
			$table->integer('user_id')->unsigned()->nullable()->index('fk_p_54417_54418_course_u_596eece522bee');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('course_user');
	}

}
