<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLibGeoCityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lib_geo_city', function(Blueprint $table)
		{
			$table->integer('province_code');
			$table->integer('city_code')->primary();
			$table->string('city_name', 47);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lib_geo_city');
	}

}
