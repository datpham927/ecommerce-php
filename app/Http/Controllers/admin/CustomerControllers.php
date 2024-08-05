<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Models\City;
use App\Models\Province;
use App\Models\User;
use App\Models\Wards;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Traits\StoreImageTrait;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerControllers extends Controller
{
    use StoreImageTrait;
    protected $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function index(Request $request)
{
    $userName = $request->input('name');
    if (!empty($userName)) {
        // Retrieve users whose user_name matches the given name with pagination
        $customers = $this->userRepository->findUserByName($userName,5);
    } else {
        // Retrieve the latest users with pagination
        $customers =$this->userRepository->findCustomer(5);
    }
    return view('admin.customer.index', compact('customers','userName'));
}

    public function create(){   
          $cities= City::orderBy("matp",'asc')->get();
          return view("admin.customer.add",compact("cities") );
    }
    public function store(UserLoginRequest $request)
    {
       try {
        $image = $this->HandleTraitUploadMultiple($request->file('user_image_url'), 'image-storage');
        $data=[
            "user_email" => $request->user_email,
            "user_name" => $request->user_name,
            "user_mobile" => $request->user_mobile,
            "user_image_url" => $image["file_path"],
            "user_city_id" => $request->city,
            "user_province_id" =>$request->province,
            "user_ward_id" =>$request->ward,
            "user_password" => bcrypt($request->user_password),
        ];
        $this->userRepository->create($data);
        DB::commit();
        return back()->with('success', 'Thêm khách hàng thành công!');
       } catch (\Throwable $th) {
           DB::rollback();
        dd($th->getMessage());

           return back()->with('error', $th->getMessage());
       }
    }
    public function edit($id){
        $customer=$this->userRepository->findById($id); 
        $cities= City::orderBy("matp",'asc')->get();
        $provinces= Province::orderBy("maqh",'asc')->get();
        $wards= Wards::orderBy("xaid",'asc')->get();
        return view("admin.customer.edit",compact("customer",'cities','provinces','wards'));
    }
    public function update(Request $request, $id)
    {
        try {
            $data = [
                "user_email" => $request->user_email,
                "user_mobile" => $request->user_mobile,
                "user_name" => $request->user_name,
                "user_city_id" => $request->city,
                "user_province_id" =>$request->province,
                "user_ward_id" =>$request->ward,
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
            $this->userRepository->findByIdAndUpdate($id,$data);
            session()->flash('success', 'Cập nhật khách hàng thành công!');
            return redirect()->back();
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    
    
    public function delete($id){
        try{
            $this->userRepository->findByIdAndDelete($id);
            return response()->json(['code' => 200, 'message' =>'Xóa khách hàng thành công!']);
            } catch (\Exception $e) {
                // Log lỗi
                Log::error($e->getMessage());
                // Gửi thông báo lỗi
              return response()->json(['code' => 500, 'message' =>'Xóa khách hàng không thành công!']);
            }
    }

    public function isBlock($id){
        try{
            $customer=$this->userRepository->findById($id);
            $customer->user_is_block=true;
            $customer->save();
            return response()->json(['code' => 200, 'message' =>'Chặn tài khoản thành công!']);
            } catch (\Exception $e) {
                // Log lỗi
                Log::error($e->getMessage());
                // Gửi thông báo lỗi
              return response()->json(['code' => 500, 'message' =>'Chặn không thành công!']);
            }
    }
    public function isActive($id){
        try{
            $customer=$this->userRepository->findById($id);
            $customer->user_is_block=false;
            $customer->save();
            return response()->json(['code' => 200, 'message' =>'Khách hàng đã được hoạt động trở lại!']);
            } catch (\Exception $e) {
                // Log lỗi
                Log::error($e->getMessage());
                // Gửi thông báo lỗi
              return response()->json(['code' => 500, 'message' =>'Không thành công!']);
            }
    }

}