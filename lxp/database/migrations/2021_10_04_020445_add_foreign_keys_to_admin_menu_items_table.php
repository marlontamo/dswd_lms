<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAdminMenuItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('admin_menu_items', function(Blueprint $table)
		{
			$table->foreign('menu')->references('id')->on('admin_menus')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('admin_menu_items', function(Blueprint $table)
		{
			$table->dropForeign('admin_menu_items_menu_foreign');
		});
	}

}
