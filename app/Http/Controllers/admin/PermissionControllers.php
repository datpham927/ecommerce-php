<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\permission;
use Illuminate\Http\Request;

class PermissionControllers extends Controller
{
    function create(){
        return view("admin.permission.add");
  }

  function store(Request $request){
    $request->validate([
        'pms_name' => "required|unique:permissions,pms_name",
    ], [
        "pms_name.unique" => 'Permission đã tồn tại!',
        "pms_name.required" => 'Không được để trống',
    ]);
    $permission = permission::create([
        "pms_name" => $request->input("pms_name"),
        "pms_display_name" => $request->input("pms_name"),
        "pms_parent_id" => 0,
        "pms_key_code" => ""
    ]);
    $displayName = [
        'list' => 'Danh sách',
        'add' => 'Thêm',
        'edit' => 'Sửa',
        'delete' => 'Xóa',
    ];
    if(!$request->has("module_children")){
        session()->flash('error', 'Vui lòng chọn quyền!');
        return redirect()->back();
    }
    foreach($request->input("module_children") as $module_children){
        permission::create([
            "pms_name" => $module_children . " " . $permission->pms_name,
            "pms_display_name" => $displayName[$module_children] . " " . $permission->pms_name,
            "pms_parent_id" => $permission->pms_id,
            "pms_key_code" => $module_children . "_" . $permission->pms_name
        ]);
    } 
    session()->flash('success', 'Thêm thành công!');
    return redirect()->back();
    
  }
}
