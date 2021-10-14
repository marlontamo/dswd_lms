<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToQuestionTestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('question_test', function(Blueprint $table)
		{
			$table->foreign('question_id', 'fk_p_54420_54422_test_que_596eeef70992f')->references('id')->on('questions')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('test_id', 'fk_p_54422_54420_question_596eeef7099af')->references('id')->on('tests')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('question_test', function(Blueprint $table)
		{
			$table->dropForeign('fk_p_54420_54422_test_que_596eeef70992f');
			$table->dropForeign('fk_p_54422_54420_question_596eeef7099af');
		});
	}

}
