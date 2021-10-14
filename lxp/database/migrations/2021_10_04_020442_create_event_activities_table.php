<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event_activities', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('event_id')->unsigned()->nullable()->index('54419_596eedbb6686e');
			$table->integer('pes_id')->nullable();
			$table->string('title', 191)->nullable();
			$table->string('slug', 191)->nullable();
			$table->string('activity_image', 191)->nullable();
			$table->text('act_posters', 65535)->nullable();
			$table->text('short_text', 65535)->nullable();
			$table->text('full_text', 65535)->nullable();
			$table->date('activity_date')->nullable();
			$table->integer('sequence')->nullable();
			$table->string('link')->nullable();
			$table->boolean('published')->nullable()->default(0);
			$table->text('smes', 65535)->nullable();
			$table->timestamps();
			$table->softDeletes()->index('lessons_deleted_at_index');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('event_activities');
	}

}
