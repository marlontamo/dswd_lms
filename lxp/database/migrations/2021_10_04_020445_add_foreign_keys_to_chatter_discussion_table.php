<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToChatterDiscussionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('chatter_discussion', function(Blueprint $table)
		{
			$table->foreign('chatter_category_id')->references('id')->on('chatter_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
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
		Schema::table('chatter_discussion', function(Blueprint $table)
		{
			$table->dropForeign('chatter_discussion_chatter_category_id_foreign');
			$table->dropForeign('chatter_discussion_user_id_foreign');
		});
	}

}
