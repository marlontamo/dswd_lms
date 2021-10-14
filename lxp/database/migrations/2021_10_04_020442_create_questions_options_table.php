<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionsOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions_options', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('question_id')->unsigned()->nullable()->index('54421_596eee8745a1e');
			$table->text('option_text', 65535);
			$table->text('explanation', 65535)->nullable();
			$table->boolean('correct')->nullable()->default(0);
			$table->timestamps();
			$table->softDeletes()->index();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('questions_options');
	}

}
