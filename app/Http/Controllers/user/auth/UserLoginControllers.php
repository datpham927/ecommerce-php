<?php

namespace App\Http\Controllers\user\auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use App\Models\User;
use App\Models\Wards;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Traits\StoreImageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class UserLoginControllers extends Controller
{
    
   use StoreImageTrait;
   protected $userRepository;
   public function __construct(UserRepositoryInterface $userRepository)
   {
       $this->userRepository = $userRepository;
   }
    function login(){
        
        if (Auth::check()) { 
            return redirect()->back();
        }
        return view('client.pages.login');
     }
     
     function storeLogin(Request $request)
     { 
        $user_email = $request->input('user_email');
        $user_password = $request->input('user_password'); 
            if (Auth::attempt(['user_email' => $user_email, 'password' => $user_password])) {
                Auth::user();  
                return redirect()->route("home.index");
            }  
         return redirect()->route("user.login")->withErrors("Tài khoản hoặc mật khẩu không chính xác!");
     }
     
     function register(){ 
        if (Auth::check()) { 
            return redirect()->back();
        }
        return view('client.pages.register');
     }
     public function storeRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_email' => 'unique:users',
        ], [
            'user_email.unique' => 'Địa chỉ email đã tồn tại!',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $password = $request->input('user_password');
        $email=$request->input('user_email');
        $confirmPassword = $request->input('user_confirm_password');
        if ($password != $confirmPassword) {
            return redirect()->back()->withErrors('Mật khẩu xác nhận không chính xác!');
        } 
         $username = explode('@', $email)[0];
         $this->userRepository->create([
            "user_email" =>$email,
            "user_name" =>$username,
            "user_password" => Hash::make($password),
        ]);
        return redirect()->route("user.login");
    }
     function logout(){
        Auth::logout();
        return redirect()->route("home.index");
     }
     function showProfile(){ 
        $cities= City::orderBy("matp",'asc')->get();
        $provinces= Province::orderBy("maqh",'asc')->get();
        $wards= Wards::orderBy("xaid",'asc')->get();
        $user=Auth::user();
        return view('client.pages.user.profile.index',compact("user",'cities','provinces','wards'));
     }


    
public function update(Request $request) {
    $user = Auth::user();
    $userImage='';
    if ($request->hasFile('user_image_url')) {
        $image = $this->HandleTraitUploadMultiple($request->file('user_image_url'), 'image-storage');
       $userImage = $image["file_path"];
    }
    $user->update([
        'user_mobile' => $request->user_mobile,
        'user_name' => $request->user_name,
        'user_city_id' => $request->city,
        'user_province_id' => $request->province,
        'user_ward_id' => $request->ward,
        'user_image_url' => $userImage,
    ]); 
    return  redirect()->back()->with(['success'=>'Cập nhật thành công']);
}
public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}

public function handleGoogleCallback()
{
    try {
        // Lấy thông tin người dùng từ Google
        $user = Socialite::driver('google')->stateless()->user();
        // Tìm người dùng trong cơ sở dữ liệu
        $findUser = User::where('user_email', $user->email)->first();
        // Nếu người dùng đã tồn tại, đăng nhập và chuyển hướng đến trang chính
        if ($findUser) {
            if($findUser->user_google_id){
                Auth::login($findUser);
                return redirect()->route("home.index");
            }else{
                return redirect()->route('user.login')->withErrors('Vui lòng đăng nhập bằng mật khẩu!');
            }
        } else {
            // Tạo người dùng mới trong cơ sở dữ liệu
            $randomPassword = Str::random(12);
            $hashedPassword = bcrypt($randomPassword);
            $data=[
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_google_id' => $user->id,
                'user_image_url' => $user->avatar,
                'user_password' => $hashedPassword // Sử dụng bcrypt để mã hóa mật khẩu
            ];
            $newUser =  $this->userRepository->create($data);

            // Đăng nhập người dùng mới và chuyển hướng đến trang chính
            Auth::login($newUser);
            return redirect()->route("home.index");
        }

    } catch (\Exception $e) {
        // Ghi lại lỗi và chuyển hướng đến trang đăng nhập
       dd('Google OAuth Error: ' . $e->getMessage());
        return redirect()->route('user.login')->withErrors('Có lỗi xảy ra trong quá trình xác thực.');
    }
}

}