<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\adminLoginFormRequest;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\admin;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StaffControllers extends Controller
{

    use StoreImageTrait;
   
    public function index() {
         $admin_staffs=admin::where(['admin_type'=>"employee"])->latest()->paginate(5);
         return view('admin.staff.index',compact("admin_staffs"));
    }
    public function uploadImage(Request $request){
        try {
            $fileImage = $request->file('admin_image');
            $image = $this->HandleTraitUploadMultiple($fileImage, 'image-storage');
            return response()->json(['code' => 200, 'image' => $image["file_path"]]);
        } catch (\Throwable $th) {
            return response()->json(['code' => 500, 'message' => $th->getMessage()]);
        }
    }
    public function create(){  
          $roles=Role::get();
          return view("admin.staff.add",compact('roles'));
    }
    public function store(AdminLoginFormRequest $request)
    {
       try {
        DB::beginTransaction();
        $image = $this->HandleTraitUploadMultiple($request->file('admin_image_url'), 'image-storage');
        $admin= admin::create([
            "admin_name" => $request->admin_name,
            "admin_mobile" => $request->admin_mobile,
            "admin_address" => $request->admin_address,
            "admin_image_url" => $image["file_path"],
            "admin_cmnd" => $request->admin_cmnd,
            "admin_password" => bcrypt($request->admin_password),
            "admin_type" => 'employee',
        ]);
        $admin->roles()->attach($request->input('admin_roles'));
        DB::commit();
        return back()->with('success', 'Thêm nhân viên thành công!');
       } catch (\Throwable $th) {
        DB::rollback();
           return back()->with('error', $th->getMessage());
       }
    }
    
    public function edit($id){
        $staff=admin::find($id); 
        $roles=Role::get();
        return view("admin.staff.edit",compact("staff",'roles'));
    }
    
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = [
                "admin_name" => $request->admin_name,
                "admin_mobile" => $request->admin_mobile,
                "admin_address" => $request->admin_address,
            ];
            if ($request->hasFile('admin_image_url')) {
                $image = $this->HandleTraitUploadMultiple($request->file('admin_image_url'), 'image-storage');
                $data["admin_image_url"] = $image["file_path"];
            }
            if ($request->filled('admin_password') && $request->filled('password_confirm')) {
                if ($request->admin_password != $request->password_confirm) {
                    return back()->with('error', 'Mật khẩu xác nhận không đúng!');
                } else {
                    $data["admin_password"] = bcrypt($request->admin_password);
                }
            }
            admin::find($id)->update($data);
            $admin = admin::find($id);
            $admin->roles()->sync($request->input('admin_roles'));
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
            $staff= admin::find($id);
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