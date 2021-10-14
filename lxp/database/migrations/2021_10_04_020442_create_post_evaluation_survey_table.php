<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostEvaluationSurveyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_evaluation_survey', function(Blueprint $table)
		{
			$table->integer('pes_id', true);
			$table->string('title', 250);
			$table->text('description', 65535);
			$table->string('date_created', 25);
			$table->integer('created_by');
			$table->string('deleted_at', 50)->nullable();
			$table->string('updated_at', 50)->nullable();
			$table->string('created_at', 50)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('post_evaluation_survey');
	}

}
