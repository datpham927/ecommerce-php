<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductControllers extends Controller
{
  
    // private $category;
    
    // public function __construct(Produ $category){ 
    //     $this->category = $category;
    // }
    
    public function index(){  
        
        return view("admin.product.add" );
    }
    // với sự khác biệt là $this->model->where sử dụng một đối tượng model
    //  đã được khởi tạo trước đó, trong khi Model::where sử dụng tên lớp model trực tiếp.
   

    public function create(){ 
 
    }
    
    public function store(Request $request)
    {
       
        
    }
    


    
    public function edit(Request $request,$id){
    
    }
    public function update(Request $request,$id){
        
    }
    public function delete($id){
         
        
    }
}
