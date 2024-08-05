<?php

namespace App\Http\Controllers\admin;

use App\Classes\SettingConfig;
use App\Http\Controllers\Controller;
use App\Models\setting;
use App\Traits\StoreImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use QrCode;
class SettingControllers extends Controller
{ 
use StoreImageTrait;
    protected $settingLibraries;
      function __construct(SettingConfig $settingLibraries){
        $this->settingLibraries=$settingLibraries;
      }

       public function  index(){
            $config=$this->settingLibraries->config();
            $setting = setting::first();
            return view('admin.setting.index',compact('config','setting'));
       }

       public function store(Request $request){
         try {
          // Kiểm tra xem có bản ghi nào tồn tại chưa
        $setting = setting::first();
        $data = $request->all();
        if ($request->hasFile('setting_logo')) {
          $image = $this->HandleTraitUploadMultiple($request->file('setting_logo'), 'image-storage');
          $data["setting_logo"] = $image["file_path"];
      }
      if ($request->has("setting_phone")) {
          $prcode=QrCode::size(150)->generate('https://zalo.me/'.$request->input("setting_phone"));
          $data["setting_prcode"] = $prcode;
    }
        if ($setting) {
            // Nếu đã có thì cập nhật
            $setting->update($data);
            $setting->save();
        } else {
            // Nếu chưa có thì tạo mới
            $setting = Setting::create($data);
        }
            return back()->with('success', 'Cài đặt thành công!');
         } catch (\Throwable $th) {
          dd($th->getMessage());
          return back()->with('error', 'Cài đặt không thành công!');
         }
   }
}