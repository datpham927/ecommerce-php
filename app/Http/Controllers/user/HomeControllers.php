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
        $products=product::where("product_isPublished",true)->limit(4)->get(); 
        $newProducts=product::where("product_isPublished",true)->orderby('created_at','desc')->limit(16)->get(); 
        return view('pages.home',compact("categories",'brands','products','sliders' ,'newProducts'));
      }
      
    function showCategoryHome($product_slug,$id){ 
        $categories = Category::orderby('id','desc')->get();
        $products_by_categoryId =  product::where([
            ['products.product_isPublished',true],
            ['products.product_category_id', $id],
        ])
        ->get();
        $category = Category::find($id);
        return view('pages.showProductByCategory',compact("products_by_categoryId",'categories'));
    }
    
}
