<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTestsResultsAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tests_results_answers', function(Blueprint $table)
		{
			$table->foreign('option_id')->references('id')->on('questions_options')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('question_id')->references('id')->on('questions')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('tests_result_id')->references('id')->on('tests_results')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tests_results_answers', function(Blueprint $table)
		{
			$table->dropForeign('tests_results_answers_option_id_foreign');
			$table->dropForeign('tests_results_answers_question_id_foreign');
			$table->dropForeign('tests_results_answers_tests_result_id_foreign');
		});
	}

}
