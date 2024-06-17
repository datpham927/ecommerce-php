<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\brand;
use App\Models\Category;
use App\Models\product;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeControllers extends Controller
{
    
    function index(){
        $categories =  Category::orderby('id','desc')->get();
        $brands = brand::orderby('id','desc')->get();
        $sliders = Slider::orderby('id','desc')->get();
        $products=product::where("product_isPublished",true)->orderby('product_discount','desc')->limit(4)->get(); 
        $newProducts=product::where("product_isPublished",true)->orderby('created_at','desc')->limit(16)->get();
        $HotSellingProducts=product::where("product_isPublished",true)->orderby('product_sold','desc')->limit(8)->get();  
        return view('client.pages.home',compact("categories",'brands','products','sliders' ,'newProducts','HotSellingProducts'));
      }
      
    function showCategoryHome($product_slug,$id){ 
        $categories = Category::orderby('id','desc')->get();
        $products_by_categoryId =  product::where([
            ['products.product_isPublished',true],
            ['products.product_category_id', $id],
        ])->latest()->paginate(12);
        $category = Category::find($id);
        return view('client.pages.showProductByCategory',compact("products_by_categoryId",'categories'));
    }

    function showBrandHome($product_slug,$id){ 
        $brands = brand::orderby('id','desc')->get();
        $products_by_brandId =  product::where([
            ['products.product_isPublished',true],
            ['products.product_brand_id', $id],
        ])->latest()->paginate(12); 
        return view('client.pages.showProductByBrand',compact("products_by_brandId",'brands'));
    }
    
    
}
