<?php

use Illuminate\Database\Seeder;

class dirCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            ['name' => 'Child and Youth Welfare', 'cat_slug' => 'cyw', 'icon' => 'fas fa-bug', 'cat_type' => '0', 'status' => '1'],
            ['name' => 'Women Welfare', 'cat_slug' => 'ww', 'icon' => 'fas fa-bug', 'cat_type' => '0', 'status' => '1'],
            ['name' => 'Family and Community Welfare', 'cat_slug' => 'fcw', 'icon' => 'fas fa-bug', 'cat_type' => '0', 'status' => '1'],
            ['name' => 'Older Persons Welfare and Persons with Disabilities Welfare', 'cat_slug' => 'opwp', 'icon' => 'fas fa-bug', 'cat_type' => '0', 'status' => '1'],
            ['name' => 'Academe', 'cat_slug' => 'academe', 'icon' => 'fas fa-bug', 'cat_type' => '1', 'status' => '1'],
            ['name' => 'National Government Agencies', 'cat_slug' => 'nga', 'icon' => 'fas fa-bug', 'cat_type' => '1', 'status' => '1'],
            ['name' => 'Non-Governmental Organizations', 'cat_slug' => 'ngo', 'icon' => 'fas fa-bug', 'cat_type' => '1', 'status' => '1'],
            ['name' => 'Organizations', 'cat_slug' => 'org', 'icon' => 'fas fa-bug', 'cat_type' => '1', 'status' => '1'],
            ['name' => 'Functional Expertise', 'cat_slug' => 'fe', 'icon' => 'fas fa-bug', 'cat_type' => '0', 'status' => '1'],

        ];
       
        DB::table('dir_category')->insert($data);
    }
}
