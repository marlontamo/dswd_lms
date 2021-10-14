<?php

use Illuminate\Database\Seeder;
use App\Models\Activity\ReportingTo;

class ReportingToSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["title" => "Learning and Development Section (LDS-Activity is intended for Internal Participants)"],
            ["title" => "Capability Building Section (CBS- Activity is intended for External Participants/Partners)"],
            ["title" => "Capability Building Section (CBS- Activity is intended for Internal Staff and External Participants"],
        ];
        DB::table('reporting_to')->insert($data);
    }
}
