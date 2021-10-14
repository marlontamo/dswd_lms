<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCertificatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('certificates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191)->nullable();
			$table->integer('user_id')->unsigned()->nullable()->index('certificates_user_id_foreign');
			$table->integer('course_id')->unsigned()->nullable()->index('certificates_course_id_foreign');
			$table->text('url', 65535)->nullable();
			$table->boolean('status')->default(1)->comment('1-Generated 0-Not Generated');
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
		Schema::drop('certificates');
	}

}
