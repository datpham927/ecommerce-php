<?php

namespace App\Http\Controllers;

use App\Models\permission;
use App\Models\permission_role;
use App\Models\role;
use App\Traits\AdminAuthenticationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleControllers extends Controller
{
   
    public function index() {
        $roles=role::latest()->paginate(5);
         return view('admin.role.index',compact("roles"));
    }

    public function create(){  
          
          $permissionParents=permission::where(["pms_parent_id"=>0])->get();
          return view("admin.role.add",compact('permissionParents'));
    }
    
    public function store(Request  $request)
    {
            
            $request->validate([
                'role_name' => "required|unique:roles,role_name",
                'role_display_name' => "required|unique:roles,role_display_name"
            ], [
                "role_name.unique" => 'Tên vai trò đã tồn tại!',
                "role_name.required" => 'Nhập tên vai trò!',
                "role_display_name.required" => 'Nhập mô tả vai trò!',
                "role_display_name.unique" => 'Mô tả vai trò đã tồn tại!'
            ]);
            DB::beginTransaction();
            // Tạo vai trò mới
            $role = Role::create([
                "role_name" => $request['role_name'],
                "role_display_name" => $request['role_display_name']
            ]);
           
            $role->permissions()->attach( $request->input('permission_id'));
            DB::commit();
            // Gửi thông báo thành công
            return back()->with('success', 'Thêm vai trò thành công!');
    }
    
    public function edit($id){
        
        $permissionParents=permission::where(["pms_parent_id"=>0])->get();
        $role=role::where('role_id',$id)->first();  
        $permissionChecked = $role->permissions;
        return view("admin.role.edit",compact("role",'permissionParents','permissionChecked'));
    }
    public function update(Request $request,$id){
        try {
            
            DB::beginTransaction();
            Role::where(["role_id"=>$id])->update([
                "role_name" => $request->input('role_name'),
                "role_display_name" => $request->input('role_display_name')
            ]);
            $role = Role::where(["role_id"=>$id])->first(); 
              $role->permissions()->sync( $request->input('permission_id'));
              DB::commit();
            session()->flash('success', 'Cập nhật vai trò thành công!');
            return redirect()->route('role.index'); 
        } catch (\Throwable $th) {
            dd( $th->getMessage());
            return back()->with('error', $th->getMessage());
        }
    }
    public function delete($id){
        try{
            
            $role=  role::where('role_id',$id)->first();
            $role->permissions()->detach();
             $role->delete();
            return response()->json(['code' => 200, 'message' =>'Xóa vai trò thành công!']);
            } catch (\Exception $e) {
                // Log lỗi
                Log::error($e->getMessage());
                // Gửi thông báo lỗi
              return response()->json(['code' => 500, 'message' =>'Xóa vai trò không thành công!']);

            }
        
    }
}