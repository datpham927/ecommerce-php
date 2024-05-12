<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use App\Traits\StoreImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerControllers extends Controller
{
    use StoreImageTrait;
   
    public function index() {
        $customers = User::latest()->paginate(5);
         return view('admin.customer.index',compact("customers"));
    }
    
    public function create(){   
          return view("admin.customer.add" );
    }
    public function store(UserLoginRequest $request)
    {
       try {
        $image = $this->HandleTraitUploadMultiple($request->file('user_image_url'), 'image-storage');
         User::create([
            "user_email" => $request->user_email,
            "user_name" => $request->user_name,
            "user_mobile" => $request->user_mobile,
            "user_address" => $request->user_address,
            "user_image_url" => $image["file_path"],
            "user_password" => bcrypt($request->user_password),
        ]);
        DB::commit();
        return back()->with('success', 'Thêm nhân viên thành công!');
       } catch (\Throwable $th) {
           DB::rollback();
           return back()->with('error', $th->getMessage());
       }
    }
    
    public function edit($id){
        $customer=user::find($id); 
        return view("admin.customer.edit",compact("customer"));
    }
    
    public function update(Request $request, $id)
    {
        try {
            $data = [
                "user_email" => $request->user_email,
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
            session()->flash('success', 'Cập nhật nhân viên thành công!');
            return redirect()->back();
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    
    
    public function delete($id){
        try{
            $customer= User::find($id);
            $customer->roles()->detach();
            $customer->delete();
            return response()->json(['code' => 200, 'message' =>'Xóa nhân viên thành công!']);
            } catch (\Exception $e) {
                // Log lỗi
                Log::error($e->getMessage());
                // Gửi thông báo lỗi
              return response()->json(['code' => 500, 'message' =>'Xó nhân viên không thành công!']);
            }
    }
}
