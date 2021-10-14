<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLibGeoBarangayTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lib_geo_barangay', function(Blueprint $table)
		{
			$table->integer('region_code');
			$table->integer('province_code');
			$table->integer('city_code');
			$table->integer('barangay_code')->primary();
			$table->string('barangay_name', 54);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lib_geo_barangay');
	}

}
