<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostEvaluationAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_evaluation_answers', function(Blueprint $table)
		{
			$table->integer('pea_id', true);
			$table->integer('event_id');
			$table->integer('activity_id');
			$table->integer('user_id');
			$table->integer('pes_id');
			$table->integer('peq_id');
			$table->text('question', 65535);
			$table->text('answer', 65535);
			$table->text('sme', 65535);
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
		Schema::drop('post_evaluation_answers');
	}

}
