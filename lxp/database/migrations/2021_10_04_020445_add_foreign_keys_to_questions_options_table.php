<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToQuestionsOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('questions_options', function(Blueprint $table)
		{
			$table->foreign('question_id', '54421_596eee8745a1e')->references('id')->on('questions')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('questions_options', function(Blueprint $table)
		{
			$table->dropForeign('54421_596eee8745a1e');
		});
	}

}
