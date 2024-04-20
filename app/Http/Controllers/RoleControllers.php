<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Traits\AdminAuthenticationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleControllers extends Controller
{
    use AdminAuthenticationTrait;
    public function index() {
        $roles=role::latest()->paginate(5);
         return view('admin.role.index',compact("roles"));
    }

    public function create(){  
        $this->authenticateLogin();
          return view("admin.role.add",);
    }
    
    public function store(Request  $request)
    {
        $this->authenticateLogin();
        $request->validate([ 'role_name'=>"unique:roles" ,'role_display_name'=>"unique:roles"],
                           [ "role_name.unique" => 'Tên vai trò đã tồn tại!',
                           "role_display_name.unique" => 'Tên hiển thị vai trò đã tồn tại!' 
                           ]);
       
      // Tạo thương hiệu mới
      role::create([
        "role_name"=> $request['role_name'],
        "role_display_name"=> $request['role_display_name']
      ]);
        // Gửi thông báo thành công
        return back()->with('success', 'Thêm vai trò thành công!');
        
    }
    


    
    public function edit($id){
        $this->authenticateLogin();
        $role=role::where('role_id',$id)->first();  
        return view("admin.role.edit",compact("role"));
    }
    public function update(Request $request,$id){
        try {
            $this->authenticateLogin();
            $role=role::where('role_id',$id); 
            $role->update([   "role_name"=> $request['role_name'],
            "role_display_name"=> $request['role_display_name']]);
            session()->flash('success', 'Cập nhật vai trò thành công!');
            return redirect()->route('role.index'); 
        } catch (\Throwable $th) {
            return back()->with('failed', 'Cập nhật vai trò không thành công!');
        }
    }
    public function delete($id){
        try{
            $this->authenticateLogin();
            role::where('role_id',$id)->delete();
            return response()->json(['code' => 200, 'message' =>'Xóa vai trò thành công!']);
            } catch (\Exception $e) {
                // Log lỗi
                Log::error($e->getMessage());
                // Gửi thông báo lỗi
              return response()->json(['code' => 500, 'message' =>'Xóa vai trò không thành công!']);

            }
        
    }
}