<?php

namespace App\Http\Controllers;
use App\Models\product;
use Illuminate\Support\Str;
use App\Components\CategoryRecursive;
use App\Models\admin;
use App\Models\brand;
use App\Models\Category;
use App\Traits\AdminAuthenticationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CategoryControllers extends Controller
{ 
    use AdminAuthenticationTrait;
    private $category,$product,$brand;
   
    public function __construct(Category $category,product $product,brand $brand){ 
        $this->category = $category;
        $this->product =  $product;
        $this->brand =  $brand;
    }
    public function index(){  
        $this->authenticateLogin();
        $categories=$this->category->latest()->paginate(5);
        $quantityProduct=$this->product->where('product_category_id')->count();
        return view("admin.category.index",compact("categories"));
    }
    // với sự khác biệt là $this->model->where sử dụng một đối tượng model
    //  đã được khởi tạo trước đó, trong khi Model::where sử dụng tên lớp model trực tiếp.
    public function getCategories($parent_id){
        $this->authenticateLogin();
        $recursive = new CategoryRecursive($this->category);
        $htmlOption = $recursive->categoryRecursive($parent_id);
        return $htmlOption;
    }

    public function create(){ 
        $this->authenticateLogin();
          $htmlOption= $this->getCategories("");
          return view("admin.category.add",compact('htmlOption') );
    }
    
    public function store(Request $request, Category $category)
    {
        $this->authenticateLogin();
            $messages = [
                "category_name.required" => 'Không được để trống',
                "category_name.unique" => 'Tên danh mục đã tồn tại'
            ];
            $request->validate([
                "category_name" => 'required|unique:categories'
            ], $messages);
            
            $slug = Str::of($request->input('category_name'))->slug('-');
            $admin= admin::find(Session::get('admin_id'));
        
            $category = $category->create([
                'category_name' => $request->input('category_name'),
                'category_parent_id' => $request->input("category_parent_id"),
                'category_slug' => $slug,
                "category_admin_id"=> $admin['id']
            ]);
            // Gửi thông báo thành công
            // session()->flash('success', 'Thêm danh mục thành công!');
            return back()->with('success', 'Thêm danh mục thành công!');
        
    }
    


    
    public function edit(Request $request,$id){
        $this->authenticateLogin();
        $category=$this->category::find($id);
        $htmlOption= $this->getCategories($category->category_parent_id);
        
        return view("admin.category.edit",compact("htmlOption","category"));
    }
    public function update(Request $request,$id){
        $this->authenticateLogin();
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
        $this->authenticateLogin();
        try{ 
            $foundChildrenCategory=$this->category->where("category_parent_id",$id)->get();
           if($foundChildrenCategory->isNotEmpty()){ 
             return response()->json(['code' => 200, 'message' => 'Vui lòng xóa hết danh mục con!']);
           }
           $foundProduct=$this->product->where("product_category_id",$id)->get();
           if($foundProduct->isNotEmpty()){
            session()->flash('error', 'Vui lòng xóa hết sản phẩm thuộc danh mục!');
            return response()->json(['code' => 200, 'message' => 'Vui lòng xóa hết sản phẩm thuộc danh mục!']);
           }
            $this->category->find($id)->delete();  
            return response()->json(['code' => 200, 'message' => 'Xóa sản phẩm thành công!']); 
            } catch (\Exception $e) {
                // Log lỗi
                Log::error($e->getMessage());
                // Gửi thông báo lỗi
                return response()->json(['code' => 500, 'message' => 'Đã xảy ra lỗi khi xóa danh mục.']); 
            }
        
    }



    function showCategoryHome($product_slug,$id){
        $categories = $this->category->orderby('id','desc')->get();
        $brands = $this->brand->orderby('id','desc')->get();
        $products_by_categoryId = $this->product
        ->join('categories', 'categories.id', '=', 'products.product_category_id')
        ->where([
            ['products.product_isPublished',true],
            ['products.product_category_id', $id],
        ])
        ->get();
    
        return view('pages.category.showProduct',compact("products_by_categoryId",'brands','categories'));
    }
}