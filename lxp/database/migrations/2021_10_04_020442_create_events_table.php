<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id')->nullable();
			$table->string('title', 191);
			$table->string('slug', 191)->nullable();
			$table->text('description', 65535)->nullable();
			$table->string('event_image', 191)->nullable();
			$table->text('event_poster', 65535)->nullable();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->boolean('published')->nullable()->default(0);
			$table->timestamps();
			$table->softDeletes()->index('courses_deleted_at_index');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('events');
	}

}
