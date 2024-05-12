<?php

namespace App\Http\Controllers\user;

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
         $user_customers=user::where(['user_type'=>"employee"])->latest()->paginate(5);
         return view('user.customer.index',compact("user_customers"));
    }
    public function uploadImage(Request $request){
        try {
            $fileImage = $request->file('user_image');
            $image = $this->HandleTraitUploadMultiple($fileImage, 'image-storage');
            return response()->json(['code' => 200, 'image' => $image["file_path"]]);
        } catch (\Throwable $th) {
            return response()->json(['code' => 500, 'message' => $th->getMessage()]);
        }
    }
    public function create(){   
          return view("user.customer.add" );
    }
    public function store(UserLoginRequest $request)
    {
       try {
        DB::beginTransaction();
        $image = $this->HandleTraitUploadMultiple($request->file('user_image_url'), 'image-storage');
        $user= User::create([
            "user_email" => $request->user_email,
            "user_name" => $request->user_name,
            "user_mobile" => $request->user_mobile,
            "user_address" => $request->user_address,
            "user_image_url" => $image["file_path"],
            "user_password" => bcrypt($request->user_password),
        ]);
        $user->roles()->attach($request->input('user_roles'));
        DB::commit();
        return back()->with('success', 'Thêm nhân viên thành công!');
       } catch (\Throwable $th) {
        DB::rollback();
           return back()->with('error', $th->getMessage());
       }
    }
    
    public function edit($id){
        $customer=user::find($id); 
        return view("user.customer.edit",compact("customer"));
    }
    
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
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
            user::find($id)->update($data);
            $user = user::find($id);
            $user->roles()->sync($request->input('user_roles'));
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
