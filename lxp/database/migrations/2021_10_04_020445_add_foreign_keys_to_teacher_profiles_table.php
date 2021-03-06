<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTeacherProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('teacher_profiles', function(Blueprint $table)
		{
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('teacher_profiles', function(Blueprint $table)
		{
			$table->dropForeign('teacher_profiles_user_id_foreign');
		});
	}

}
