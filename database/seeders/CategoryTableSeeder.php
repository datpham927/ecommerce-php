<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            [
                'id' => 1,
                'category_name' => "Đồ nam",
                'category_slug' => Str::slug("Đồ nam"),
                'category_parent_id' => 0,
            ],
            [
                'id' => 2,
                'category_name' => "Quần nam",
                'category_slug' => Str::slug("Quần nam"),
                'category_parent_id' => 1,
            ], 
            [
                'id' => 4,
                'category_name' => "Áo khoác nam",
                'category_slug' => Str::slug("Áo khoác nam"),
                'category_parent_id' => 1,
            ],
            [
                'id' => 5,
                'category_name' => "Áo sơ mi nam",
                'category_slug' => Str::slug("Áo sơ mi nam"),
                'category_parent_id' => 1,
            ],
            [
                'id' => 6,
                'category_name' => "Quần jean nam",
                'category_slug' => Str::slug("Quần jean nam"),
                'category_parent_id' => 1,
            ],
            [
                'id' => 7,
                'category_name' => "Quần kaki nam",
                'category_slug' => Str::slug("Quần kaki nam"),
                'category_parent_id' => 1,
            ],
            [
                'id' => 8,
                'category_name' => "Quần thể thao nam",
                'category_slug' => Str::slug("Quần thể thao nam"),
                'category_parent_id' => 1,
            ]
            ,[
                'id' => 9,
                'category_name' => "Đồ nữ",
                'category_slug' => Str::slug("Đồ nữ"),
                'category_parent_id' => 0,
            ], 
            [
                'id' => 11,
                'category_name' => "Áo khoác nữ",
                'category_slug' => Str::slug("Áo khoác nữ"),
                'category_parent_id' => 9,
            ],
            [
                'id' => 12,
                'category_name' => "Áo sơ mi nữ",
                'category_slug' => Str::slug("Áo sơ mi nữ"),
                'category_parent_id' => 9,
            ], 
            [
                'id' => 14,
                'category_name' => "Quần jean nữ",
                'category_slug' => Str::slug("Quần jean nữ"),
                'category_parent_id' => 9,
            ],
            [
                'id' => 15,
                'category_name' => "Quần legging nữ",
                'category_slug' => Str::slug("Quần legging nữ"),
                'category_parent_id' => 9,
            ],
            [
                'id' => 16,
                'category_name' => "Đầm nữ",
                'category_slug' => Str::slug("Đầm nữ"),
                'category_parent_id' => 9,
            ],
        ]);

        
    }
}
