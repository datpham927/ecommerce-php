<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\product;
use Illuminate\Http\Request;

class HomeControllers extends Controller
{  
   private $category,$product;
   
   public function __construct(Category $category,product $product){ 
       $this->category = $category;
       $this->product =  $product;
   }
   
     function index(){
      $categories = $this->category->get();
      $products=$this->product->where("product_isPublished",true)->latest()->paginate(20); 
        return view('pages.home',compact("categories",'products'));
     }
}