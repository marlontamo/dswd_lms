<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToChatterUserDiscussionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('chatter_user_discussion', function(Blueprint $table)
		{
			$table->foreign('discussion_id')->references('id')->on('chatter_discussion')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
		Schema::table('chatter_user_discussion', function(Blueprint $table)
		{
			$table->dropForeign('chatter_user_discussion_discussion_id_foreign');
			$table->dropForeign('chatter_user_discussion_user_id_foreign');
		});
	}

}
