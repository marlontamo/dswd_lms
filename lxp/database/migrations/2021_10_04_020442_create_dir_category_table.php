<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDirCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dir_category', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191)->nullable();
			$table->string('cat_slug', 191)->nullable();
			$table->text('icon', 65535)->nullable();
			$table->integer('cat_type')->nullable()->comment('0-cgs, 1-SWEDLNET');
			$table->integer('status')->default(1)->comment('0 - disabled, 1 - enabled');
			$table->timestamps();
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
		Schema::drop('dir_category');
	}

}
