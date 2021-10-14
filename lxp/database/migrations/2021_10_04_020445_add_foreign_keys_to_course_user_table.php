<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCourseUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('course_user', function(Blueprint $table)
		{
			$table->foreign('user_id', 'fk_p_54417_54418_course_u_596eece522bee')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('course_id', 'fk_p_54418_54417_user_cou_596eece522b73')->references('id')->on('courses')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('course_user', function(Blueprint $table)
		{
			$table->dropForeign('fk_p_54417_54418_course_u_596eece522bee');
			$table->dropForeign('fk_p_54418_54417_user_cou_596eece522b73');
		});
	}

}
