<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVideoProgressTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('video_progress', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('media_id')->unsigned()->index('video_progresses_media_id_foreign');
			$table->integer('user_id')->unsigned()->index('video_progresses_user_id_foreign');
			$table->float('duration');
			$table->float('progress');
			$table->boolean('complete')->default(0)->comment('0.Pending 1.Complete');
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
		Schema::drop('video_progress');
	}

}
