<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatterPostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chatter_post', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('chatter_discussion_id')->unsigned()->index('chatter_post_chatter_discussion_id_foreign');
			$table->integer('user_id')->unsigned()->index('chatter_post_user_id_foreign');
			$table->text('body', 65535);
			$table->timestamps();
			$table->boolean('markdown')->default(0);
			$table->boolean('locked')->default(0);
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('chatter_post');
	}

}
