<?php

namespace App\Http\Controllers;

use App\Models\brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeControllers extends Controller
{  
   private $category,$product,$brand,$slider;
   
   public function __construct(Category $category,product $product,brand $brand,Slider $slider){ 
       $this->category = $category;
       $this->product =  $product;
       $this->brand =  $brand;
       $this->slider =  $slider;
   }
   
     function index(){
       $categories = $this->category->orderby('id','desc')->get();
       $brands = $this->brand->orderby('id','desc')->get();
       $sliders = $this->slider->orderby('id','desc')->get();
       $products=$this->product->where("product_isPublished",true)->limit(4)->get(); 
       $newProducts=$this->product->where("product_isPublished",true)->orderby('created_at','desc')->limit(16)->get(); 
       return view('pages.home',compact("categories",'brands','products','sliders' ,'newProducts'));
     }
} 