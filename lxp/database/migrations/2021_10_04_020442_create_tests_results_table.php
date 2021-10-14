<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestsResultsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tests_results', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('test_id')->unsigned()->nullable()->index('tests_results_test_id_foreign');
			$table->integer('user_id')->unsigned()->nullable()->index('tests_results_user_id_foreign');
			$table->integer('test_result');
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
		Schema::drop('tests_results');
	}

}
