<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use App\Models\Feeship;
use App\Models\Wards;
use Illuminate\Console\View\Components\Warn;
use Illuminate\Http\Request;
use Response;

class DeliveryControllers extends Controller
{
       function index(){
               $cities= City::orderBy("matp",'asc')->get();
               $feeships=Feeship::orderBy("id",'asc')->paginate(5);
               return view('admin.delivery.index',compact("cities",'feeships'));
       }
       public function selectDelivery(Request $request) {
        $output = '';
        // Lấy mã code và chuẩn hóa độ dài mã code
        // trong database lưu 001 mà $request->input('code') = 1 
        //  nên phải chuẩn hóa độ dài thành 001
        $code = str_pad($request->input('code'), $request->input('action') === 'city' ? 2 : 3, '0', STR_PAD_LEFT);
        if ($request->input('action') === 'city') {
            $provinces = Province::where('matp', $code)->orderBy("maqh",'asc')->get();
            $output='<option value="0">Chọn quận huyện</option>';
            foreach ($provinces as $province) {
                $output .= "<option value='{$province->matp}'>{$province->name}</option>";
            }
        } else if ($request->input('action') === 'province'){
            $wards = Wards::where('maqh', $code)->orderBy("xaid",'asc')->get();
            $output='<option value="0">Chọn xã phường</option>';
            foreach ($wards as $ward) {
                $output .= "<option value='{$ward->maqh}'>{$ward->name}</option>";
            }
        }
        return response()->json($output);
    }

    public function add(Request $request){
            // Define custom validation messages
            $messages = [
                "city.required" => 'Vui lòng chọn!', 
                "province.required" => 'Vui lòng chọn!', 
                "ward.required" => 'Vui lòng chọn!', 
                "feeship.required" => 'Vui lòng nhập phí vận chuyển!', 
            ];
    
            // Define validation rules
            $rules = [
                "city" => 'required',
                "province" => 'required',
                "ward" => 'required',
                "feeship" => 'required',
            ];
            // Validate the request data
            $request->validate($rules, $messages);
            // Check if a Feeship record already exists
           
            $foundFeeship = Feeship::where([
                'matp' => $request->city,
                'maqh' => $request->province,
                'xaid' => $request->ward,
            ])->first();
            if ($foundFeeship) {
                // Update the existing Feeship record
                $foundFeeship->update([
                    'feeship' => $request->feeship
                ]);
            } else {
                // Create a new Feeship record
                Feeship::create([
                    'matp' => $request->city,
                    'maqh' => $request->province,
                    'xaid' => $request->ward,
                    'feeship' => $request->feeship
                ]);
            }
            // Redirect back with success message
            return back()->with('success', 'Thành công!');
    }
    
    public function update(Request $request,$id) {
         try {
             Feeship::find($id)->update(
               [ 'feeship'=> $request->feeship]
             );
             return response()->json(['code' => 200]);
         } catch (\Throwable $th) {
            return response()->json(['code' => 500]);
         }
    }
    
    
}