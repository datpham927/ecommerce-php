<?php

namespace App\Http\Controllers;

use App\Models\brand;
use App\Models\Category;
use App\Models\product;
use Illuminate\Http\Request;

class HomeControllers extends Controller
{  
   private $category,$product,$brand;
   
   public function __construct(Category $category,product $product,brand $brand){ 
       $this->category = $category;
       $this->product =  $product;
       $this->brand =  $brand;
   }
   
     function index(){
      $categories = $this->category->orderby('id','desc')->get();
      $brands = $this->brand->orderby('id','desc')->get();
      $products=$this->product->where("product_isPublished",true)->limit(4)->get(); 
        return view('pages.home',compact("categories",'brands','products'));
     }
} 