<?php

use Illuminate\Database\Seeder;

class CourseCategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
           [
               "name" => "Stress Management",
               "slug" => "stress-management",
               "icon" => "fas fa-bomb",
               "status" => "1",
            ],
            [
                "name" => "HITECH LXP",
                "slug" => "hitech-lxp",
                "icon" => "fas fa-compact-disc",
                "status" => "1",
             ],
           
             [
                "name" => "Capacity Building",
                "slug" => "capacity-building",
                "icon" => "",
                "status" => "1",
             ],
            
        ];
       
        DB::table('categories')->insert($data);
    }
}
