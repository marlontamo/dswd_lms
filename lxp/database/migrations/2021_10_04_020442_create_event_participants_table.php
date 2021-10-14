<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventParticipantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event_participants', function(Blueprint $table)
		{
			$table->integer('event_id')->unsigned()->nullable()->index('course_student_course_id_foreign');
			$table->integer('user_id')->unsigned()->nullable()->index('course_student_user_id_foreign');
			$table->integer('rating')->unsigned()->default(0);
			$table->string('office')->nullable();
			$table->string('odsu')->nullable();
			$table->string('org')->nullable();
			$table->text('reason', 65535)->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('event_participants');
	}

}
