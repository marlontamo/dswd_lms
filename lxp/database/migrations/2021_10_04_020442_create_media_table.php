<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('model_type', 191)->nullable();
			$table->bigInteger('model_id')->unsigned()->nullable();
			$table->string('name', 191);
			$table->text('url', 65535)->nullable();
			$table->string('type', 191)->nullable();
			$table->string('file_name', 191);
			$table->integer('size')->unsigned();
			$table->timestamps();
			$table->index(['model_type','model_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('media');
	}

}
