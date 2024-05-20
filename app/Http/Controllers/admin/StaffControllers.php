<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\adminLoginFormRequest;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StaffControllers extends Controller
{

   use StoreImageTrait;
    public function index(Request  $request) {

        $staffName = $request->input('name');
        $customers=[];
        if (!empty($staffName)) {
            // Retrieve users whose user_name matches the given name with pagination
            $customers = User::where('user_name', 'like', "%{$staffName}%")->paginate(5);
        } else {
            // Retrieve the latest users with pagination
            $user_staffs = User::whereIn('user_type', ['employee', 'admin'])->latest()->paginate(5);
        }
    
       
         return view('admin.staff.index',compact("user_staffs",'staffName'));
    }
 
    public function create(){  
          $roles=Role::get();
          return view("admin.staff.add",compact('roles'));
    }
    public function store(AdminLoginFormRequest $request)
    {
       try {
        DB::beginTransaction();
        $image = $this->HandleTraitUploadMultiple($request->file('user_image_url'), 'image-storage');
        $admin= User::create([
            "user_name" => $request->user_name,
            "user_mobile" => $request->user_mobile,
            "user_address" => $request->user_address,
            "user_image_url" => $image["file_path"],
            "user_cmnd" => $request->user_cmnd,
            "user_password" => bcrypt($request->user_password),
            "user_type" => 'employee',
        ]);
        $admin->roles()->attach($request->input('user_roles'));
        DB::commit();
        return back()->with('success', 'Thêm nhân viên thành công!');
       } catch (\Throwable $th) {
        DB::rollback();
           return back()->with('error', $th->getMessage());
       }
    }
    
    public function edit($id){
        $staff=User::find($id); 
        $roles=Role::get();
        return view("admin.staff.edit",compact("staff",'roles'));
    }
    
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = [
                "user_name" => $request->user_name,
                "user_mobile" => $request->user_mobile,
                "user_address" => $request->user_address,
            ];
            if ($request->hasFile('user_image_url')) {
                $image = $this->HandleTraitUploadMultiple($request->file('user_image_url'), 'image-storage');
                $data["user_image_url"] = $image["file_path"];
            }
            if ($request->filled('user_password') && $request->filled('password_confirm')) {
                if ($request->user_password != $request->password_confirm) {
                    return back()->with('error', 'Mật khẩu xác nhận không đúng!');
                } else {
                    $data["user_password"] = bcrypt($request->user_password);
                }
            }
            User::find($id)->update($data);
            $admin = User::find($id);
            $admin->roles()->sync($request->input('user_roles'));
            DB::commit();
            session()->flash('success', 'Cập nhật nhân viên thành công!');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', $th->getMessage());
        }
    }
    
    
    public function delete($id){
        try{
            $staff= User::find($id);
            $staff->roles()->detach();
            $staff->delete();
            return response()->json(['code' => 200, 'message' =>'Xóa nhân viên thành công!']);
            } catch (\Exception $e) {
                // Log lỗi
                Log::error($e->getMessage());
                // Gửi thông báo lỗi
              return response()->json(['code' => 500, 'message' =>'Xó nhân viên không thành công!']);
            }
    }
}