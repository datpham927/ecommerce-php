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
        DB::table('users')->insert([
            'id'=>1,
            'user_name' => "admin", 
            'user_email' => "admin@gmail.com", 
            'user_mobile' => "0917442948",
            'user_password' => Hash::make('123'),
            'user_type'=>'admin'
        ]);
    }
}