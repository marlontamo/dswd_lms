<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAnswerTextFieldOnTestResultsAnswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tests_results_answers', function (Blueprint $table) {
            $table->text('answer_text', 65535)->nullable()->after('option_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('tests_results_answers', function (Blueprint $table) {
            $table->dropColumn('answer_text');
        });
    }
}
