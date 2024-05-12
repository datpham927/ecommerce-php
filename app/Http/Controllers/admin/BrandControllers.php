<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormBrandRequest;
use App\Models\admin;
use App\Models\brand;
use App\Models\Category;
use App\Models\product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class BrandControllers extends Controller
{
    private $category,$product,$brand, $slider;
   
    public function __construct(Category $category,product $product,brand $brand,Slider $slider){ 
        $this->category = $category;
        $this->product =  $product;
        $this->brand =  $brand;
        $this->slider =  $slider;
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
            
            $foundProduct=$this->product->where("product_brand_id",$id)->get();
            if($foundProduct->isNotEmpty()){
              return response()->json(['code' => 500, 'message' =>'Vui lòng xóa hết sản phẩm thuộc nhãn hàng này!']);
            } 
            $this->brand->find($id)->delete();
            return response()->json(['code' => 200, 'message' =>'Xóa thương hiệu thành công!']);
            } catch (\Exception $e) {
                // Log lỗi
                Log::error($e->getMessage());
                // Gửi thông báo lỗi
              return response()->json(['code' => 500, 'message' =>'Đã xảy ra lỗi']);
            }
        
    }
}
