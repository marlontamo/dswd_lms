<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminMenuItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_menu_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('label', 191);
			$table->string('link', 191);
			$table->integer('parent')->unsigned()->default(0);
			$table->integer('sort')->default(0);
			$table->string('class', 191)->nullable();
			$table->integer('menu')->unsigned()->index('admin_menu_items_menu_foreign');
			$table->integer('depth')->default(0);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('admin_menu_items');
	}

}
