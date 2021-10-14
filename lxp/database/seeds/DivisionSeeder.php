<?php

use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [  "office_id" => 1,
                  "div_shortname" => "PPD",
                "div_title" => "Policy and Plans Division"],
            [ "office_id" => 3,
                "div_shortname" => "ProtSd",
            "div_title" => "Protective Services Division"],

             [   "office_id" => 3,
                 "div_shortname" => "DRMD",
            "div_title" => "Disaster Response Management Division"],
            [  "office_id" => 3,
                "div_shortname" => "PromSD",
            "div_title" => "Promotive Services Division"],
           
            [   "office_id" => 3,
                "div_shortname" => "SWAD Office",
            "div_title" => "Provincial Social Welfare and Development Team"],
            [ "office_id" => 2,
                "div_shortname" => "AD",
            "div_title" => "Administrative Division"],
            [  "office_id" => 2,
            "div_shortname" => "FMD",
        "div_title" => "Financial Management Division"],
            [ "office_id" => 2,
                "div_shortname" => "HRMDD",
            "div_title" => "Human Resource Management and Development Division"],
            [  "office_id" => 1,
                 "div_shortname" => "ORD",
            "div_title" => "Office of the Regional Director"],
            [ "office_id" => 3,
                "div_shortname" => "Pantawid Pamilya",
            "div_title" => "Pantawid Pamilyang Pilipino Program"],
        ];
        DB::table('division')->insert($data);
    }
}
