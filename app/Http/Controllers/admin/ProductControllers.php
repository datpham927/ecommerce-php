<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormAddProductRequest;
use App\Http\Requests\FormEditProductRequest;
use App\Models\attribute;
use App\Models\brand;
use App\Models\Category;
use App\Models\Images;
use App\Models\Notification;
use App\Models\Size;
use App\Models\User;
use App\Repository\Interfaces\ProductRepositoryInterface;
use App\Traits\StoreImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Str; 

class ProductControllers extends Controller
{
    use StoreImageTrait;
    private $category,$brand,$image,$size,$attribute;
    protected $productRepository;
    public function __construct( Category $category, 
    brand $brand, Images $image, Size $size,attribute $attribute,ProductRepositoryInterface $productRepository){ 
        $this->category = $category;
        $this->brand = $brand;
        $this->image = $image;
        $this->size = $size;
        $this->attribute = $attribute;
        $this->productRepository = $productRepository;
    }
    public function index(Request $request)
    {
        // Retrieve the product name from the request input
        $productName = $request->input('name');
        // Apply pagination and order by latest
        $products = $this->productRepository->getPublishedProducts($productName);
        // Return the view with the products and the productName
        return view('admin.product.index', compact('products', 'productName'));
    }
    // với sự khác biệt là $this->model->where sử dụng một đối tượng model
    //  đã được khởi tạo trước đó, trong khi Model::where sử dụng tên lớp model trực tiếp.
    
    public function create(){ 
        $brands= $this->brand->get();
        $categories= $this->category->get();
        return view("admin.product.add",compact('brands',"categories") );
    }
    public function store(FormAddProductRequest $request){
        try { 
            DB::beginTransaction();
        // *********    insert table Product  *********  
        $dataProduct= array();
        $dataProduct['product_name']=$request->input('product_name');
        $dataProduct['product_slug']=  Str::of($request->input('product_name'))->slug('-');
        $dataProduct['product_price']=$request->input('product_price');
        $dataProduct['product_origin_price']=$request->input('product_origin_price');
        $dataProduct['product_description']=$request->input('product_description');
        $dataProduct['product_category_id']=$request->input('product_category_id');
        $dataProduct['product_brand_id']=$request->input('product_brand_id');
        $dataProduct['product_discount']=$request->input('product_discount')||0;
        $product_thumb=$this->handleTraitUpdateImage($request,'product_thumb',"productImages");
        if($product_thumb){
          $dataProduct['product_thumb']=$product_thumb["file_path"];
       } 
        // bản nháp  product_isDraft
         if($request->input('product_isDraft')){
          $dataProduct['product_isDraft']=true;
          $dataProduct['product_isPublished']=false;
         }
         // ------- create product ----------
         // lấy array số lượng product theo size
          $dataProductQuantities=$request->input('product_quantities');
        // ----- tính tổng số sản phẩm -------
          if ($dataProductQuantities) {
              // Use the sum method to calculate the total quantity 
           $dataProduct['product_stock']=collect($dataProductQuantities)->sum();
       } 
          $newProduct = $this->productRepository->create($dataProduct);
//*********   insert table size  *********  
          $dataSizes=$request->input('product_sizes'); //array tên kích thước 
          if($dataSizes){
                  foreach ($dataSizes as $key => $value) {
                      $this->size->create([
                          'size_name' =>$value,
                          'size_product_quantity' =>$dataProductQuantities[$key],
                          'size_product_id' =>$newProduct['id']
                      ]);
                  }
          }
// *********   insert table images *********  
         $fileImages=$request->file('product_images');
       if($fileImages){
          foreach ($fileImages as $key => $image) {
                $images=$this->HandleTraitUploadMultiple($image,'productImages'); 
                $this->image->create([
                    "image_name"=>$images['file_name'],
                    "image_url"=>$images['file_path'],
                    'image_product_id'=>$newProduct['id'],
                ]);
          }
       }
// *********   insert table attribute *********  
         $dataKeyAttributes=$request->input('product_attribute_keys');
         $dataNameAttributes=$request->input('product_attribute_names');
       if($dataKeyAttributes&&$dataNameAttributes){
          foreach ($dataKeyAttributes as $key => $keyValue) {
              $this->attribute->create([
                  "attribute_name"=>$keyValue,
                  "attribute_description"=> $dataNameAttributes[$key],
                  'attribute_product_id'=>$newProduct['id'],
              ]);
          }
       }
       Notification::create([
        'n_user_id' => null,
        'n_title' => 'Có một sản phẩm mới',
        'n_subtitle' => $newProduct->product_name,
        'n_image' => $newProduct->product_thumb,'n_type' =>"system",
        'n_link' => '/product/' . $newProduct->product_slug . '/' . $newProduct->id
    ]);
       DB::commit();
       return back()->with('success', 'Thêm sản phẩm thành công!');
        } catch (\Throwable $exception) {
              DB::rollBack(); //khôi phục giao dịch (không lưu)
              dd($exception->getMessage());
              return back()->with('error', 'Thêm sản phẩm không thành công!');
        }
    }
    public function edit($id){
            $product=$this->productRepository->findById($id);
            $images=$this->image->where('image_product_id',$product["id"])->get();
            $attributes=$this->attribute->where('attribute_product_id',$product["id"])->get();
            $sizes= $this->size->where('size_product_id',$product["id"])->get();
            $categories= $this->category->get();
            $brands= $this->brand->get();
           return view('admin.product.edit',compact('product','images','attributes',
                                                    'brands','categories','sizes'));
    }
    public function update(FormEditProductRequest $request,$id){
        try {
            DB::beginTransaction();
        // *********    insert table Product  *********  
        $dataProduct= array();
        $pid = Str::uuid(); // Generate a UUID
        $dataProduct['id']=$pid ;
        $dataProduct['product_name']=$request->input('product_name');
        $dataProduct['product_slug']=  Str::of($request->input('product_name'))->slug('-');
        $dataProduct['product_price']=$request->input('product_price');
        $dataProduct['product_origin_price']=$request->input('product_origin_price');
        $dataProduct['product_description']=$request->input('product_description');
        $dataProduct['product_category_id']=$request->input('product_category_id');
        $dataProduct['product_brand_id']=$request->input('product_brand_id');
        $dataProduct['product_discount']=$request->input('product_discount');
        if($request->hasFile("product_thumb")){
            $product_thumb=$this->handleTraitUpdateImage($request,'product_thumb',"productImages");
            if($product_thumb){
              $dataProduct['product_thumb']=$product_thumb["file_path"];
           } 
        }
        // bản nháp  product_isDraft
         if($request->has('product_isDraft')){
          $dataProduct['product_isDraft']=true;
          $dataProduct['product_isPublished']=false;
         }
         // ------- create product ----------
        // ----- tính tổng số sản phẩm -------
          if ($request->has('product_quantities')) {
         // lấy array số lượng product theo size
            $dataProductQuantities=$request->input('product_quantities');
              // Use the sum method to calculate the total quantity 
           $dataProduct['product_stock']=collect($dataProductQuantities)->sum();
       } 
          $this->productRepository->findByIdAndUpdate($id,$dataProduct);
          //
          $foundProduct= $this->productRepository->findById($id);
//*********   insert table size  *********  
          if($request->has('product_sizes')){
                $dataSizes=$request->input('product_sizes'); //array tên kích thước 
                 $this->size->where('size_product_id',$foundProduct['id'])->delete();
                  foreach ($dataSizes as $key => $value) {
                      $this->size->create([
                          'size_name' =>$value,
                          'size_product_quantity' =>$dataProductQuantities[$key],
                          'size_product_id' =>$foundProduct['id']
                      ]);
                  }
          }
// *********   insert table images *********  
        if($request->has("product_images")){
                $fileImages=$request->file('product_images');
                $this->image->where('image_product_id',$foundProduct['id'])->delete();
                foreach ($fileImages as $key => $image) {
                        $images=$this->HandleTraitUploadMultiple($image,'productImages'); 
                    $this->image->create([
                        "image_name"=>$images['file_name'],
                        "image_url"=>$images['file_path'],
                        'image_product_id'=>$foundProduct['id'],
                    ]);
                }
            }
// *********   insert table attribute *********  
       if($request->has("product_attribute_keys") and $request->has("product_attribute_names")){
        $dataKeyAttributes=$request->input('product_attribute_keys');
        $dataNameAttributes=$request->input('product_attribute_names');
        $this->attribute->where('attribute_product_id',$foundProduct['id'])->delete();
          foreach ($dataKeyAttributes as $key => $keyValue) {
              $this->attribute->create([
                  "attribute_name"=>$keyValue,
                  "attribute_description"=> $dataNameAttributes[$key],
                  'attribute_product_id'=>$foundProduct['id'],
              ]);
          }
       }
       DB::commit();
       return back()->with('success', 'Cập nhật sản phẩm thành công!');
        } catch (\Throwable $exception) {
              DB::rollBack(); //khôi phục giao dịch (không lưu)
              return back()->with('error', 'Cập nhật sản phẩm không thành công!');
        }
    }
    public function delete($id){
           try{
            $this->productRepository->findByIdAndDelete($id);
            return response()->json(['code' => 200, 'message' => 'Xóa sản phẩm thành công!']);
            } catch (\Exception $e) {
                // Log lỗi
                Log::error($e->getMessage());
                // Gửi thông báo lỗi
                return response()->json(['code' => 500, 'message' => 'Đã xảy ra lỗi khi xóa sản phẩm!']);
            } 
    }
     function productDeleted(){
          $products = $this->productRepository->getDeletedProducts(5);
            return view('admin.product.deleted',compact('products'));
        }
        function restore($id){
            $result = $this->productRepository->restoreProductById($id);
            return response()->json(['code' => $result['code'], 'message' => $result['message']]);
          }
             // ----  danh sách product nháp ---- 
    public function draftList(){  
        // Assuming $this->product represents the Product model in Laravel
        $products =$this->productRepository->getDraftProductList(5); 
         return view("admin.product.draft",compact('products') );
     }
     public function isPublish($id)
     {
         // Find the product by its ID
         $foundProduct = $this->productRepository->findById($id);
         // Check if the product is not found
         if (!$foundProduct) {
             session()->flash('error', 'Không tìm thấy sản phẩm!');
             return back();
         }
         // Update product status
         $foundProduct->update([
             'product_isPublished' => 1,
             'product_isDraft' => 0,
         ]);
         // Flash a success message and redirect back
         session()->flash('success', 'Sản phẩm đã được đăng thành công!');
         return back();
     } 
}