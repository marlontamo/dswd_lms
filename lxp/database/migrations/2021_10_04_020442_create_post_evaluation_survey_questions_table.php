<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostEvaluationSurveyQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_evaluation_survey_questions', function(Blueprint $table)
		{
			$table->integer('pesq_id', true);
			$table->integer('pes_id');
			$table->integer('peq_id');
			$table->integer('added_by');
			$table->string('date_created', 25);
			$table->string('deleted_at', 25)->nullable();
			$table->string('updated_at', 25)->nullable();
			$table->string('created_at', 25)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('post_evaluation_survey_questions');
	}

}
