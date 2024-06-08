<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

 
        DB::table('roles')->insert( 
            [['role_name' => "admin",'role_display_name' =>"Quản trị hệ thống"], 
            ['role_name' => "content",'role_display_name' =>"Chỉnh sửa nội dung"]]
        );
        DB::table('user_roles')->insert( 
            ['ur_user_id' => 1,'ur_role_id' =>1]
        );
    }
}