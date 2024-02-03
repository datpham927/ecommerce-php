<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormBrandRequest;
use App\Models\brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BrandControllers extends Controller
{
    private $brand;
    
    public function __construct(brand $brand){ 
        $this->brand = $brand;
    }
    
    public function index(){  
        $brands=$this->brand->latest()->paginate(5);
       
        return view("admin.brand.index",compact("brands"));
    }
    // với sự khác biệt là $this->model->where sử dụng một đối tượng model
    //  đã được khởi tạo trước đó, trong khi Model::where sử dụng tên lớp model trực tiếp.
   

    public function create(){  
          return view("admin.brand.add",);
    }
    
    public function store(FormBrandRequest $request, brand $brand)
    {
          $request->validate([ 'brand_name'=>"unique:brands" ],
                             [ "brand_name.unique" => 'Tên thương hiệu đã tồn tại!' ]);

        $brandName = $request->input("brand_name");
        $slug = Str::of($brandName)->slug('-');
        // Tạo một mảng chứa dữ liệu thương hiệu
        $brandData = [
            'brand_name' => $brandName,
            'brand_status' =>$request->input("brand_status"),
            'brand_description' => $request->input("brand_description"),
            'brand_slug' => $slug,
        ];
        // Tạo thương hiệu mới
        $this->brand->create($brandData);
        // Gửi thông báo thành công
        return back()->with('success', 'Thêm Thương hiệu thành công!');
            
        
    }
    


    
    public function edit($id){
        $brand=$this->brand::find($id); 
       
        return view("admin.brand.edit",compact("brand"));
    }
    public function update(FormBrandRequest $request,$id){
            // tìm brand
            $brand=$this->brand::find($id); 
            $brandName = $request->input("brand_name");
            $slug = Str::of($brandName)->slug('-');
            
            // Tạo một mảng chứa dữ liệu thương hiệu
            $brandData = [
                'brand_name' => $brandName,
                'brand_status' =>$request->input("brand_status"),
                'brand_description' => $request->input("brand_description"),
                'brand_slug' => $slug,
            ];
            // update brand 
            $brand->update($brandData);

            session()->flash('success', 'Cập nhật thương hiệu thành công!');
            return redirect()->route('brand.index'); 
    }
    public function delete($id){
        try{

            session()->flash('success', 'Xóa thương hiệu thành công!');
            return redirect()->back(); 
            } catch (\Exception $e) {
                // Log lỗi
                Log::error($e->getMessage());
                // Gửi thông báo lỗi
                session()->flash('error', 'Đã xảy ra lỗi khi xóa thương hiệu.');
            }
        
    }
}