<?php

use Illuminate\Database\Seeder;

class ParticipantGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["title" => "LGU Participants"],
            ["title" => "NGA Participants"],
            ["title" => "NGO Participants"],
            ["title" =>"People's Org Participants"],
            ["title" => "Volunteers"],
            ["title" =>"Different Sectors"]
        ];
        DB::table('participant_group')->insert($data);
    }
}
