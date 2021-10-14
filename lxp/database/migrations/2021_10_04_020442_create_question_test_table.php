<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionTestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('question_test', function(Blueprint $table)
		{
			$table->integer('question_id')->unsigned()->nullable()->index('fk_p_54420_54422_test_que_596eeef70992f');
			$table->integer('test_id')->unsigned()->nullable()->index('fk_p_54422_54420_question_596eeef7099af');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('question_test');
	}

}
