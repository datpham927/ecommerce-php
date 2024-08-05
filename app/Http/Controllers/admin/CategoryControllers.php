<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\product;
use App\Repository\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class CategoryControllers extends Controller
{
    protected $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function index(){  
        $categories=$this->categoryRepository->getAllWithPaginate(5);
        $quantityProduct=product::where('product_category_id')->count();
        return view("admin.category.index",compact("categories"));
    }
    // với sự khác biệt là $this->model->where sử dụng một đối tượng model
    //  đã được khởi tạo trước đó, trong khi Model::where sử dụng tên lớp model trực tiếp.

    public function create(){ 
        
          $htmlOption= $this->categoryRepository->getAll();
          return view("admin.category.add",compact('htmlOption') );
    }
    
    public function store(Request $request)
    {
            $messages = [
                "category_name.required" => 'Không được để trống',
                "category_name.unique" => 'Tên danh mục đã tồn tại'
            ];
            $request->validate([
                "category_name" => 'required|unique:categories'
            ], $messages);

            $slug = Str::of($request->input('name'))->slug('-');
            $data=[
                'category_name' => $request->input('category_name'),
                'category_parent_id' => $request->input("category_parent_id")||0,
                'category_slug' => $slug,
            ];
             $this->categoryRepository->create($data);
            // Gửi thông báo thành công
            session()->flash('success', 'Thêm danh mục thành công!');
            return back()->with('success', 'Thêm danh mục thành công!');

    }
    public function edit(Request $request,$id){
        
        $category=$this->categoryRepository->findById($id);
        
        return view("admin.category.edit",compact("category"));
    }
    public function update(Request $request,$id){
        
            $request->validate([
                "category_name"=>'required'
            ],
            ["category_name.required"=>'Không được để trống' ]

        );
        $slug = Str::of($request->input('category_name'))->slug('-');
        $data=[
            'category_name' =>$request->input('category_name'),
            'category_slug' => $slug,
        ];
           $this->categoryRepository->findByIdAndUpdate($id, $data);
            session()->flash('success', 'Cập nhật danh mục thành công!');
            return redirect()->route('category.index'); 
    }
    public function delete($id){
        
        try{  
           $foundProduct=Product::where("product_category_id",$id)->get();
           if($foundProduct->isNotEmpty()){
            session()->flash('error', 'Vui lòng xóa hết sản phẩm thuộc danh mục!');
            return response()->json(['code' => 500, 'message' => 'Vui lòng xóa hết sản phẩm thuộc danh mục này!']);
           }
            $this->categoryRepository->findByIdAndDelete($id) ;  
            return response()->json(['code' => 200, 'message' => 'Xóa sản phẩm thành công!']); 
            } catch (\Exception $e) {
                // Log lỗi
                Log::error($e->getMessage());
                // Gửi thông báo lỗi
                return response()->json(['code' => 500, 'message' => 'Đã xảy ra lỗi khi xóa danh mục.']); 
            }
        
    }
}