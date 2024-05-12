<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([ 
            [
                'pms_name' => "Danh mục",
                'pms_display_name' => "Danh mục",
                'pms_parent_id' => 0,
                'pms_key_code' => "",
            ],
            [
                'pms_name' => "Thương hiệu",
                'pms_display_name' => "Thương hiệu",
                'pms_parent_id' => 0,
                'pms_key_code' => "",
            ],
            [
                'pms_name' => "Sản phẩm",
                'pms_display_name' => "Sản phẩm",
                'pms_parent_id' => 0,
                'pms_key_code' => "",
            ],
            [
                'pms_name' => "slider",
                'pms_display_name' => "slider",
                'pms_parent_id' => 0,
                'pms_key_code' => "",
            ],
            [
                'pms_name' => "Đơn hàng",
                'pms_display_name' => "Đơn hàng",
                'pms_parent_id' => 0,
                'pms_key_code' => "",
            ],
            
            //danh mục
            [
                'pms_name' => "Danh sách danh mục",
                'pms_display_name' => "Danh sách danh mục",
                'pms_parent_id' => 1,
                'pms_key_code' => "list_category",
            ],
            [
                'pms_name' => "Xóa danh mục",
                'pms_display_name' => "Xóa danh mục",
                'pms_parent_id' => 1,
                'pms_key_code' => "delete_category",
            ],
            [
                'pms_name' => "Thêm danh mục",
                'pms_display_name' => "Thêm danh mục",
                'pms_parent_id' => 1,
                'pms_key_code' => "add_category",
            ],
            [
                'pms_name' => "Sửa danh mục",
                'pms_display_name' => "Sửa danh mục",
                'pms_parent_id' => 1,
                'pms_key_code' => "edit_category",
            ],
            //thương hiệu
            [
                'pms_name' => "Danh sách thương hiệu",
                'pms_display_name' => "Danh sách thương hiệu",
                'pms_parent_id' => 2,
                'pms_key_code' => "list_brand",
            ],
            [
                'pms_name' => "Xóa thương hiệu",
                'pms_display_name' => "Xóa thương hiệu",
                'pms_parent_id' => 2,
                'pms_key_code' => "delete_brand",
            ],
            [
                'pms_name' => "Thêm thương hiệu",
                'pms_display_name' => "Thêm thương hiệu",
                'pms_parent_id' => 2,
                'pms_key_code' => "add_brand",
            ],
            [
                'pms_name' => "Sửa thương hiệu",
                'pms_display_name' => "Sửa thương hiệu",
                'pms_parent_id' => 2,
                'pms_key_code' => "edit_brand",
            ],
            //sản phẩm
            [
                'pms_name' => "Danh sách sản phẩm",
                'pms_display_name' => "Danh sách sản phẩm",
                'pms_parent_id' => 3,
                'pms_key_code' => "list_product",
            ],
            [
                'pms_name' => "Xóa sản phẩm",
                'pms_display_name' => "Xóa sản phẩm",
                'pms_parent_id' => 3,
                'pms_key_code' => "delete_product",
            ],
            [
                'pms_name' => "Thêm sản phẩm",
                'pms_display_name' => "Thêm sản phẩm",
                'pms_parent_id' => 3,
                'pms_key_code' => "add_product",
            ],
            [
                'pms_name' => "Sửa sản phẩm",
                'pms_display_name' => "Sửa sản phẩm",
                'pms_parent_id' => 3,
                'pms_key_code' => "edit_product",
            ],

              // Danh sách slider
              [
                'pms_name' => "Danh sách slider",
                'pms_display_name' => "Danh sách slider",
                'pms_parent_id' => 4,
                'pms_key_code' => "list_slider",
            ],
            [
                'pms_name' => "Xóa slider",
                'pms_display_name' => "Xóa slider",
                'pms_parent_id' => 4,
                'pms_key_code' => "delete_slider",
            ],
            [
                'pms_name' => "Thêm slider",
                'pms_display_name' => "Thêm slider",
                'pms_parent_id' => 4,
                'pms_key_code' => "add_slider",
            ],
            [
                'pms_name' => "Sửa slider",
                'pms_display_name' => "Sửa slider",
                'pms_parent_id' => 4,
                'pms_key_code' => "edit_slider",
            ],
            // đơn hàng
        ]);
    }
}
