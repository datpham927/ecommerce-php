<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Components\CategoryRecursive;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryControllers extends Controller
{
    private $category;
    
    public function __construct(Category $category){ 
        $this->category = $category;
    }
    
    public function index(){  
        $categories=$this->category::latest()->paginate(5);
        
        return view("admin.category.index",compact("categories"));
    }
    // với sự khác biệt là $this->model->where sử dụng một đối tượng model
    //  đã được khởi tạo trước đó, trong khi Model::where sử dụng tên lớp model trực tiếp.
    public function getCategories($parent_id){
        $recursive = new CategoryRecursive($this->category);
        $htmlOption = $recursive->categoryRecursive($parent_id);
        return $htmlOption;
    }

    public function create(){ 
          $htmlOption= $this->getCategories("");
          return view("admin.category.add",compact('htmlOption') );
    }
    
    public function store(Request $request, Category $category)
    {
            $messages = [
                "category_name.required" => 'Không được để trống',
                "category_name.unique" => 'Tên danh mục đã tồn tại'
            ];
            $request->validate([
                "category_name" => 'required|unique:categories'
            ], $messages);
            
            $slug = Str::of($request->input('category_name'))->slug('-');
            $category = $category->create([
                'category_name' => $request->input('category_name'),
                'category_parent_id' => $request->input("category_parent_id")||0,
                'category_slug' => $slug,
            ]);
            // Gửi thông báo thành công
            // session()->flash('success', 'Thêm danh mục thành công!');
            return back()->with('success', 'Thêm danh mục thành công!');
        
    }
    


    
    public function edit(Request $request,$id){
        $category=$this->category::find($id);
        $htmlOption= $this->getCategories($category->category_parent_id);
        
        return view("admin.category.edit",compact("htmlOption","category"));
    }
    public function update(Request $request,$id){
            $request->validate([
                "category_name"=>'required'
            ],
            ["category_name.required"=>'Không được để trống' ]

        );
        $slug = Str::of($request->input('category_name'))->slug('-');
           $category=$this->category::find($id);
           $category->update([
                'category_name' =>$request->input('category_name'),
                'category_parent_id' =>$request->input("category_parent_id") ,
                'category_slug' => $slug,
            ]);
            session()->flash('success', 'Cập nhật danh mục thành công!');
            return redirect()->route('category.index'); 
    }
    public function delete($id){
        try{
            $this->category->where("category_parent_id",$id)->delete();
            $this->category->find($id)->delete(); 
            session()->flash('success', 'Xóa danh mục thành công!');
            return redirect()->back(); 
            } catch (\Exception $e) {
                // Log lỗi
                Log::error($e->getMessage());
                // Gửi thông báo lỗi
                session()->flash('error', 'Đã xảy ra lỗi khi xóa danh mục.');
            }
        
    }
}