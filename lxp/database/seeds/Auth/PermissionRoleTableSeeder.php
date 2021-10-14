<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;


    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Create Roles
        $admin = Role::create(['name' => config('access.users.super_admin_role')]);
        $teacher = Role::create(['name' => 'teacher']);
        $student = Role::create(['name' => 'student']);
        $user = Role::create(['name' => 'user']);


      

        //        $admin_permissions = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67];

        // $teacher_permissions = [1, 21, 22, 23, 24,25, 26, 27, 28, 29,30, 31, 32, 33, 34,35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 47, 48, 49, 51, 68, 69, 70, 71, 72];

        // $student_permission = [47];


        // $admin->syncPermissions(Permission::all());
        // $teacher->syncPermissions($teacher_permissions);
        // $student->syncPermissions($student_permission);
        // $this->truncateMultiple([
        //     'permissions',
        //     'role_has_permissions',
        // ]);
        $permission_data = '[{"id":1,"name":"user_management_access","guard_name":"web","created_at":"2020-04-22 10:28:47","updated_at":"2020-04-22 10:28:47"},{"id":2,"name":"user_management_create","guard_name":"web","created_at":"2020-04-22 10:28:47","updated_at":"2020-04-22 10:28:47"},{"id":3,"name":"user_management_edit","guard_name":"web","created_at":"2020-04-22 10:28:47","updated_at":"2020-04-22 10:28:47"},{"id":4,"name":"user_management_view","guard_name":"web","created_at":"2020-04-22 10:28:47","updated_at":"2020-04-22 10:28:47"},{"id":5,"name":"user_management_delete","guard_name":"web","created_at":"2020-04-22 10:28:47","updated_at":"2020-04-22 10:28:47"},{"id":6,"name":"permission_access","guard_name":"web","created_at":"2020-04-22 10:28:47","updated_at":"2020-04-22 10:28:47"},{"id":7,"name":"permission_create","guard_name":"web","created_at":"2020-04-22 10:28:47","updated_at":"2020-04-22 10:28:47"},{"id":8,"name":"permission_edit","guard_name":"web","created_at":"2020-04-22 10:28:47","updated_at":"2020-04-22 10:28:47"},{"id":9,"name":"permission_view","guard_name":"web","created_at":"2020-04-22 10:28:47","updated_at":"2020-04-22 10:28:47"},{"id":10,"name":"permission_delete","guard_name":"web","created_at":"2020-04-22 10:28:47","updated_at":"2020-04-22 10:28:47"},{"id":11,"name":"role_access","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":12,"name":"role_create","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":13,"name":"role_edit","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":14,"name":"role_view","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":15,"name":"role_delete","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":16,"name":"user_access","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":17,"name":"user_create","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":18,"name":"user_edit","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":19,"name":"user_view","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":20,"name":"user_delete","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":21,"name":"course_access","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":22,"name":"course_create","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":23,"name":"course_edit","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":24,"name":"course_view","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":25,"name":"course_delete","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":26,"name":"lesson_access","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":27,"name":"lesson_create","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":28,"name":"lesson_edit","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":29,"name":"lesson_view","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":30,"name":"lesson_delete","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":31,"name":"question_access","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":32,"name":"question_create","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":33,"name":"question_edit","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":34,"name":"question_view","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":35,"name":"question_delete","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":36,"name":"questions_option_access","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":37,"name":"questions_option_create","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":38,"name":"questions_option_edit","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":39,"name":"questions_option_view","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":40,"name":"questions_option_delete","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":41,"name":"test_access","guard_name":"web","created_at":"2020-04-22 10:28:48","updated_at":"2020-04-22 10:28:48"},{"id":42,"name":"test_create","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":43,"name":"test_edit","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":44,"name":"test_view","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":45,"name":"test_delete","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":46,"name":"order_access","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":47,"name":"view backend","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":48,"name":"category_access","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":49,"name":"category_create","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":50,"name":"category_edit","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":51,"name":"category_view","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":52,"name":"category_delete","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":53,"name":"blog_access","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":54,"name":"blog_create","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":55,"name":"blog_edit","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":56,"name":"blog_view","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":57,"name":"blog_delete","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":58,"name":"reason_access","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":59,"name":"reason_create","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":60,"name":"reason_edit","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":61,"name":"reason_view","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":62,"name":"reason_delete","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":63,"name":"page_access","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":64,"name":"page_create","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":65,"name":"page_edit","guard_name":"web","created_at":"2020-04-22 10:28:49","updated_at":"2020-04-22 10:28:49"},{"id":66,"name":"page_view","guard_name":"web","created_at":"2020-04-22 10:28:50","updated_at":"2020-04-22 10:28:50"},{"id":67,"name":"page_delete","guard_name":"web","created_at":"2020-04-22 10:28:50","updated_at":"2020-04-22 10:28:50"},{"id":68,"name":"bundle_access","guard_name":"web","created_at":"2020-04-22 10:28:50","updated_at":"2020-04-22 10:28:50"},{"id":69,"name":"bundle_create","guard_name":"web","created_at":"2020-04-22 10:28:50","updated_at":"2020-04-22 10:28:50"},{"id":70,"name":"bundle_edit","guard_name":"web","created_at":"2020-04-22 10:28:50","updated_at":"2020-04-22 10:28:50"},{"id":71,"name":"bundle_view","guard_name":"web","created_at":"2020-04-22 10:28:50","updated_at":"2020-04-22 10:28:50"},{"id":72,"name":"bundle_delete","guard_name":"web","created_at":"2020-04-22 10:28:50","updated_at":"2020-04-22 10:28:50"}]';
        $permission_data = json_decode($permission_data, true);
        DB::table('permissions')->insert($permission_data);

        $data = '[{"permission_id":1,"role_id":1},{"permission_id":2,"role_id":1},{"permission_id":3,"role_id":1},{"permission_id":4,"role_id":1},{"permission_id":5,"role_id":1},{"permission_id":6,"role_id":1},{"permission_id":7,"role_id":1},{"permission_id":8,"role_id":1},{"permission_id":9,"role_id":1},{"permission_id":10,"role_id":1},{"permission_id":11,"role_id":1},{"permission_id":12,"role_id":1},{"permission_id":13,"role_id":1},{"permission_id":14,"role_id":1},{"permission_id":15,"role_id":1},{"permission_id":16,"role_id":1},{"permission_id":17,"role_id":1},{"permission_id":18,"role_id":1},{"permission_id":19,"role_id":1},{"permission_id":20,"role_id":1},{"permission_id":21,"role_id":1},{"permission_id":22,"role_id":1},{"permission_id":23,"role_id":1},{"permission_id":24,"role_id":1},{"permission_id":25,"role_id":1},{"permission_id":26,"role_id":1},{"permission_id":27,"role_id":1},{"permission_id":28,"role_id":1},{"permission_id":29,"role_id":1},{"permission_id":30,"role_id":1},{"permission_id":31,"role_id":1},{"permission_id":32,"role_id":1},{"permission_id":33,"role_id":1},{"permission_id":34,"role_id":1},{"permission_id":35,"role_id":1},{"permission_id":36,"role_id":1},{"permission_id":37,"role_id":1},{"permission_id":38,"role_id":1},{"permission_id":39,"role_id":1},{"permission_id":40,"role_id":1},{"permission_id":41,"role_id":1},{"permission_id":42,"role_id":1},{"permission_id":43,"role_id":1},{"permission_id":44,"role_id":1},{"permission_id":45,"role_id":1},{"permission_id":46,"role_id":1},{"permission_id":47,"role_id":1},{"permission_id":48,"role_id":1},{"permission_id":49,"role_id":1},{"permission_id":50,"role_id":1},{"permission_id":51,"role_id":1},{"permission_id":52,"role_id":1},{"permission_id":53,"role_id":1},{"permission_id":54,"role_id":1},{"permission_id":55,"role_id":1},{"permission_id":56,"role_id":1},{"permission_id":57,"role_id":1},{"permission_id":58,"role_id":1},{"permission_id":59,"role_id":1},{"permission_id":60,"role_id":1},{"permission_id":61,"role_id":1},{"permission_id":62,"role_id":1},{"permission_id":63,"role_id":1},{"permission_id":64,"role_id":1},{"permission_id":65,"role_id":1},{"permission_id":66,"role_id":1},{"permission_id":67,"role_id":1},{"permission_id":68,"role_id":1},{"permission_id":69,"role_id":1},{"permission_id":70,"role_id":1},{"permission_id":71,"role_id":1},{"permission_id":72,"role_id":1},{"permission_id":21,"role_id":2},{"permission_id":22,"role_id":2},{"permission_id":23,"role_id":2},{"permission_id":24,"role_id":2},{"permission_id":25,"role_id":2},{"permission_id":26,"role_id":2},{"permission_id":27,"role_id":2},{"permission_id":28,"role_id":2},{"permission_id":29,"role_id":2},{"permission_id":30,"role_id":2},{"permission_id":31,"role_id":2},{"permission_id":32,"role_id":2},{"permission_id":33,"role_id":2},{"permission_id":34,"role_id":2},{"permission_id":35,"role_id":2},{"permission_id":36,"role_id":2},{"permission_id":37,"role_id":2},{"permission_id":38,"role_id":2},{"permission_id":39,"role_id":2},{"permission_id":40,"role_id":2},{"permission_id":41,"role_id":2},{"permission_id":42,"role_id":2},{"permission_id":43,"role_id":2},{"permission_id":44,"role_id":2},{"permission_id":45,"role_id":2},{"permission_id":47,"role_id":2},{"permission_id":48,"role_id":2},{"permission_id":49,"role_id":2},{"permission_id":51,"role_id":2},{"permission_id":68,"role_id":2},{"permission_id":69,"role_id":2},{"permission_id":70,"role_id":2},{"permission_id":71,"role_id":2},{"permission_id":72,"role_id":2},{"permission_id":47,"role_id":3},{"permission_id":1,"role_id":5},{"permission_id":2,"role_id":5},{"permission_id":3,"role_id":5},{"permission_id":4,"role_id":5},{"permission_id":5,"role_id":5},{"permission_id":6,"role_id":5},{"permission_id":7,"role_id":5},{"permission_id":8,"role_id":5},{"permission_id":9,"role_id":5},{"permission_id":10,"role_id":5},{"permission_id":11,"role_id":5},{"permission_id":12,"role_id":5},{"permission_id":13,"role_id":5},{"permission_id":14,"role_id":5},{"permission_id":15,"role_id":5},{"permission_id":16,"role_id":5},{"permission_id":17,"role_id":5},{"permission_id":18,"role_id":5},{"permission_id":19,"role_id":5},{"permission_id":20,"role_id":5},{"permission_id":21,"role_id":5},{"permission_id":22,"role_id":5},{"permission_id":23,"role_id":5},{"permission_id":24,"role_id":5},{"permission_id":25,"role_id":5},{"permission_id":26,"role_id":5},{"permission_id":27,"role_id":5},{"permission_id":28,"role_id":5},{"permission_id":29,"role_id":5},{"permission_id":30,"role_id":5},{"permission_id":31,"role_id":5},{"permission_id":32,"role_id":5},{"permission_id":33,"role_id":5},{"permission_id":34,"role_id":5},{"permission_id":35,"role_id":5},{"permission_id":36,"role_id":5},{"permission_id":37,"role_id":5},{"permission_id":38,"role_id":5},{"permission_id":39,"role_id":5},{"permission_id":40,"role_id":5},{"permission_id":41,"role_id":5},{"permission_id":42,"role_id":5},{"permission_id":43,"role_id":5},{"permission_id":44,"role_id":5},{"permission_id":45,"role_id":5},{"permission_id":47,"role_id":5},{"permission_id":48,"role_id":5},{"permission_id":49,"role_id":5},{"permission_id":50,"role_id":5},{"permission_id":51,"role_id":5},{"permission_id":52,"role_id":5},{"permission_id":53,"role_id":5},{"permission_id":54,"role_id":5},{"permission_id":55,"role_id":5},{"permission_id":56,"role_id":5},{"permission_id":57,"role_id":5}]';
        $data = json_decode($data, true);
        DB::table('role_has_permissions')->insert($data);



        $this->enableForeignKeys();
    }
}
