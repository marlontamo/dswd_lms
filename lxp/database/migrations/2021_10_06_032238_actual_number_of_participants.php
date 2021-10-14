<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActualNumberOfParticipants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actual_number_of_participants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('activity_id')->unsigned();
            $table->foreign('activity_id')->references('id')->on('activity_accomplishment_entry')->onDelete('cascade');
            $table->integer('staff_FO_male');
            $table->integer('staff_FO_female');
            $table->integer('province_code');
            $table->foreign('province_code')->references('province_code')->on('lib_geo_province');
            $table->unsignedBigInteger('participant_group_id');
            $table->foreign('participant_group_id')->references('id')->on('participant_group');
            $table->integer('city_code');
            $table->foreign('city_code')->references('city_code')->on('lib_geo_city');
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
        Schema::dropIfExists('actual_number_of_participants');
    }
}
