<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDirExpertiseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dir_expertise', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id')->unsigned()->nullable()->index('expertise_category_id_foreign');
			$table->string('slug', 191)->nullable();
			$table->string('first_name', 191)->nullable();
			$table->string('middle_name', 191)->nullable();
			$table->string('last_name', 191)->nullable();
			$table->string('image', 191)->nullable();
			$table->string('email', 191)->nullable();
			$table->string('position')->nullable();
			$table->string('office')->nullable();
			$table->text('content')->nullable();
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
		Schema::drop('dir_expertise');
	}

}
