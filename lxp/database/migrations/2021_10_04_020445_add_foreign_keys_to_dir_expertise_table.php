<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDirExpertiseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('dir_expertise', function(Blueprint $table)
		{
			$table->foreign('category_id', 'expertise_category_id_foreign')->references('id')->on('dir_category')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('dir_expertise', function(Blueprint $table)
		{
			$table->dropForeign('expertise_category_id_foreign');
		});
	}

}
