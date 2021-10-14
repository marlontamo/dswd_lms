<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        $this->truncateMultiple([
            'admin_menus',
            'admin_menu_items',
        ]);
        $data = '[{"id":2,"label":"Courses","link":"courses","parent":2,"sort":0,"class":null,"menu":1,"depth":0,"created_at":"2020-04-22 10:28:51","updated_at":"2020-11-19 07:59:03"},{"id":5,"label":"Contact","link":"contact","parent":5,"sort":1,"class":null,"menu":1,"depth":0,"created_at":"2020-04-22 10:28:51","updated_at":"2021-01-27 23:53:32"},{"id":6,"label":"About Us","link":"about-us","parent":6,"sort":2,"class":null,"menu":1,"depth":0,"created_at":"2020-04-22 10:28:51","updated_at":"2021-01-27 23:53:32"},{"id":14,"label":"Online Resources","link":"#","parent":14,"sort":3,"class":null,"menu":1,"depth":0,"created_at":"2021-03-26 04:53:30","updated_at":"2021-03-26 04:57:26"},{"id":15,"label":"FAQs","link":"faq","parent":14,"sort":4,"class":null,"menu":1,"depth":1,"created_at":"2021-03-26 04:53:52","updated_at":"2021-03-26 04:57:26"},{"id":16,"label":"Reference Materials","link":"blog","parent":14,"sort":5,"class":null,"menu":1,"depth":1,"created_at":"2021-03-26 04:54:08","updated_at":"2021-03-26 04:57:26"},{"id":17,"label":"Directory of Expertise","link":"#","parent":14,"sort":6,"class":null,"menu":1,"depth":1,"created_at":"2021-03-26 04:54:26","updated_at":"2021-03-26 04:57:26"},{"id":18,"label":"Subject Matter Expert Or Instructional Designer","link":"teachers","parent":17,"sort":7,"class":null,"menu":1,"depth":2,"created_at":"2021-03-26 04:55:35","updated_at":"2021-03-26 04:57:26"},{"id":19,"label":"Core Group of Specialist (CGS)","link":"expertise?type=0","parent":17,"sort":8,"class":null,"menu":1,"depth":2,"created_at":"2021-03-26 04:56:14","updated_at":"2021-03-26 04:57:26"},{"id":20,"label":"Social Welfare and Development Learning Network (SWDLNet)","link":"expertise?type=1","parent":17,"sort":9,"class":null,"menu":1,"depth":2,"created_at":"2021-03-26 04:56:28","updated_at":"2021-03-26 04:57:26"},{"id":21,"label":"Events","link":"events","parent":21,"sort":10,"class":null,"menu":1,"depth":0,"created_at":"2021-03-30 05:47:03","updated_at":"2021-04-22 03:53:18"}]';

        $data = json_decode($data, true);
        DB::table('admin_menu_items')->insert($data);
        $this->enableForeignKeys();
    }
}
