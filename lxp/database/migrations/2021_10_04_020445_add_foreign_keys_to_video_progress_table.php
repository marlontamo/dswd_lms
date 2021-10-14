<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToVideoProgressTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('video_progress', function(Blueprint $table)
		{
			$table->foreign('media_id', 'video_progresses_media_id_foreign')->references('id')->on('media')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('user_id', 'video_progresses_user_id_foreign')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('video_progress', function(Blueprint $table)
		{
			$table->dropForeign('video_progresses_media_id_foreign');
			$table->dropForeign('video_progresses_user_id_foreign');
		});
	}

}
