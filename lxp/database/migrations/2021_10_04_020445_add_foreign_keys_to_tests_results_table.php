<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTestsResultsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tests_results', function(Blueprint $table)
		{
			$table->foreign('test_id')->references('id')->on('tests')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tests_results', function(Blueprint $table)
		{
			$table->dropForeign('tests_results_test_id_foreign');
			$table->dropForeign('tests_results_user_id_foreign');
		});
	}

}
