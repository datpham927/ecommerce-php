<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\brand;
use App\Models\Category;
use App\Models\product;
use App\Models\Slider;
use App\Models\visitor;
use App\Repository\Interfaces\ProductRepositoryInterface;
use App\Repository\Interfaces\UserInterestedCategoryRepositoryInterface;
use App\Repository\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeControllers extends Controller
{
    protected $userInterestedCategoryRepository ,$productRepository;
    public function __construct(
        UserInterestedCategoryRepositoryInterface $userInterestedCategoryRepository,
        ProductRepositoryInterface $productRepository
    )
    {
        $this->userInterestedCategoryRepository = $userInterestedCategoryRepository;
        $this->productRepository=$productRepository;
    }
    function index(Request $request){
         $foundVisitor=visitor::where(['visitor_id_address'=>$request->ip()])->get();
         if($foundVisitor->count()==0){ visitor::create(['visitor_id_address'=>$request->ip()]); } 
        $categories =  Category::orderby('id','desc')->get();
        $brands = brand::orderby('id','desc')->get();
        $sliders = Slider::orderby('id','desc')->get();
        $products=$this->productRepository->getPublishedProductsWithOrderBy(['product_discount'=>'desc'],4);
        $newProducts= $this->productRepository->getPublishedProductsWithOrderBy(['created_at'=>'desc'],8) ;
        $HotSellingProducts= $this->productRepository->getPublishedProductsWithOrderBy(['product_sold'=>'desc'],8) ;
        $UserInterestedProducts=  []; 
        if(auth()->check()){
            $UserInterestedCategoryId =$this->userInterestedCategoryRepository->getUserInterestedCategoryByUserId(Auth::user()->id);
            $UserInterestedProducts= $this->productRepository->getProductsByCategoryId($UserInterestedCategoryId,8);
       
        }
         return view('client.pages.home',compact("categories",'brands','products','sliders',
         'newProducts','HotSellingProducts','UserInterestedProducts'));
      }
      
    function showCategoryHome($product_slug,$id){ 
        $categories = Category::orderby('id','desc')->get();
        $products_by_categoryId =  product::where([
            ['products.product_isPublished',true],
            ['products.product_category_id', $id],
        ])->latest()->paginate(12);
        $category = Category::find($id);

        $breadcrumb = [
            
            ['label' => $category->category_name, 'link' =>null],
        ];
        return view('client.pages.showProductByCategory',compact("products_by_categoryId",'categories','breadcrumb'));
    }

    function showBrandHome($product_slug,$id){ 
        $brands = brand::orderby('id','desc')->get();
        $products_by_brandId =  product::where([
            ['products.product_isPublished',true],
            ['products.product_brand_id', $id],
        ])->latest()->paginate(12); 
        $brand = brand::find($id);
        $breadcrumb = [
            ['label' => $brand->brand_name, 'link' =>null],
        ];
        return view('client.pages.showProductByBrand',compact("products_by_brandId",'brands','breadcrumb'));
    }
    
    
}