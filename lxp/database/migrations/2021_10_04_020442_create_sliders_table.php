<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSlidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sliders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->text('content')->nullable();
			$table->text('bg_image', 65535)->nullable();
			$table->integer('overlay')->nullable()->default(0);
			$table->integer('sequence');
			$table->integer('status')->default(1)->comment('1 - enabled, 0 - disabled');
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
		Schema::drop('sliders');
	}

}
