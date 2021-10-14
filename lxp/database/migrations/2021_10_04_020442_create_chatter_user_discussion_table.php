<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatterUserDiscussionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chatter_user_discussion', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned()->index();
			$table->integer('discussion_id')->unsigned()->index();
			$table->primary(['user_id','discussion_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('chatter_user_discussion');
	}

}
