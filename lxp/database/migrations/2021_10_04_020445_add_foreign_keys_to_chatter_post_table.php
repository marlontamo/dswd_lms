<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToChatterPostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('chatter_post', function(Blueprint $table)
		{
			$table->foreign('chatter_discussion_id')->references('id')->on('chatter_discussion')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('chatter_post', function(Blueprint $table)
		{
			$table->dropForeign('chatter_post_chatter_discussion_id_foreign');
			$table->dropForeign('chatter_post_user_id_foreign');
		});
	}

}
