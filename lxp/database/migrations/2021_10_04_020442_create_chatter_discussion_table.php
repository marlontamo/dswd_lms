<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatterDiscussionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chatter_discussion', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('chatter_category_id')->unsigned()->default(1)->index('chatter_discussion_chatter_category_id_foreign');
			$table->string('title', 191);
			$table->integer('user_id')->unsigned()->index('chatter_discussion_user_id_foreign');
			$table->boolean('sticky')->default(0);
			$table->integer('views')->unsigned()->default(0);
			$table->boolean('answered')->default(0);
			$table->timestamps();
			$table->string('slug', 191)->unique();
			$table->string('color', 20)->nullable()->default('#232629');
			$table->softDeletes();
			$table->timestamp('last_reply_at')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('chatter_discussion');
	}

}
