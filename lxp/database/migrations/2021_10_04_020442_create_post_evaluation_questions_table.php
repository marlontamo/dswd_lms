<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostEvaluationQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_evaluation_questions', function(Blueprint $table)
		{
			$table->integer('peq_id', true);
			$table->text('question', 65535);
			$table->boolean('sme')->default(0);
			$table->integer('answer_type')->nullable()->default(1)->comment('1- 01 to 05; 2- essay');
			$table->string('date_created', 25);
			$table->integer('created_by');
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
		Schema::drop('post_evaluation_questions');
	}

}
