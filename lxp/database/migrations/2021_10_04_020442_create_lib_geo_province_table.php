<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLibGeoProvinceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lib_geo_province', function(Blueprint $table)
		{
			$table->integer('region_code');
			$table->integer('province_code')->primary();
			$table->string('province_name', 52);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lib_geo_province');
	}

}
