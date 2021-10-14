<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMessageThreadParticipantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('message_thread_participants', function(Blueprint $table)
		{
			$table->foreign('thread_id')->references('id')->on('message_threads')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('message_thread_participants', function(Blueprint $table)
		{
			$table->dropForeign('message_thread_participants_thread_id_foreign');
			$table->dropForeign('message_thread_participants_user_id_foreign');
		});
	}

}
