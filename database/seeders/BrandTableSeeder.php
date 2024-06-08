<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('brands')->insert([
            [
                'id' => 1,
                'brand_name' => "Yody",
                'brand_slug' => Str::slug("Yody"),
                'brand_description' => "Thương hiệu thời trang nổi tiếng tại Việt Nam",
                'brand_status' => 1,
            ],
            [
                'id' => 2,
                'brand_name' => "Canifa",
                'brand_slug' => Str::slug("Canifa"),
                'brand_description' => "Thương hiệu thời trang dành cho mọi lứa tuổi",
                'brand_status' => 1,
            ],
            [
                'id' => 3,
                'brand_name' => "Routine",
                'brand_slug' => Str::slug("Routine"),
                'brand_description' => "Thương hiệu thời trang nam năng động và hiện đại",
                'brand_status' => 1,
            ],
            [
                'id' => 4,
                'brand_name' => "Juno",
                'brand_slug' => Str::slug("Juno"),
                'brand_description' => "Thương hiệu giày và túi xách nữ",
                'brand_status' => 1,
            ],
            [
                'id' => 5,
                'brand_name' => "Ninomaxx",
                'brand_slug' => Str::slug("Ninomaxx"),
                'brand_description' => "Thương hiệu thời trang dành cho giới trẻ",
                'brand_status' => 1,
            ],
            [
                'id' => 6,
                'brand_name' => "Blue Exchange",
                'brand_slug' => Str::slug("Blue Exchange"),
                'brand_description' => "Thương hiệu thời trang phổ thông tại Việt Nam",
                'brand_status' => 1,
            ],
            [
                'id' => 7,
                'brand_name' => "The Blues",
                'brand_slug' => Str::slug("The Blues"),
                'brand_description' => "Thương hiệu thời trang denim hàng đầu",
                'brand_status' => 1,
            ],
            [
                'id' => 8,
                'brand_name' => "Biti's",
                'brand_slug' => Str::slug("Biti's"),
                'brand_description' => "Thương hiệu giày dép uy tín tại Việt Nam",
                'brand_status' => 1,
            ],
            [
                'id' => 9,
                'brand_name' => "Vascara",
                'brand_slug' => Str::slug("Vascara"),
                'brand_description' => "Thương hiệu túi xách, giày dép nữ",
                'brand_status' => 1,
            ],
            [
                'id' => 10,
                'brand_name' => "Eva de Eva",
                'brand_slug' => Str::slug("Eva de Eva"),
                'brand_description' => "Thương hiệu thời trang nữ cao cấp",
                'brand_status' => 1,
            ],
        ]);
    }
}
