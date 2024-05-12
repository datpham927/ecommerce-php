<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'admin_name' => "admin", 
            'admin_mobile' => "0917442948",
            'admin_password' => Hash::make('123'),
            'admin_cmnd' =>  '043982737828',
            'admin_type'=>'admin'
        ]);
    }
}