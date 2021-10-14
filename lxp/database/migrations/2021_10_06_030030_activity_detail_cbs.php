<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivityDetailCbs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_details_cbs', function (Blueprint $table) {
            $table->bigIncrements('activity_detail_id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('activity_id')->unsigned();
            $table->foreign('activity_id')->references('id')->on('activity_accomplishment_entry')->onDelete('cascade');
            $table->string('activity_title');
            $table->string('proposed_date_of_conduct');
            $table->string('proposed_venue');
            $table->integer('field_office');
            $table->integer('central_office');
            $table->integer('CIS');
            $table->double('obligated_amount');
            $table->integer('LGU');
            $table->integer('NGO');
            $table->integer('NGA');
            $table->integer('PO');
            $table->integer('volunteers');
            $table->integer('stakeholders');
            $table->integer('academe');
            $table->integer('religious_sector');
            $table->integer('Business_sector');
            $table->integer('media');
            $table->integer('beneficiaries');
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
        Schema::dropIfExists('activity_details_cbs');
    }
}
