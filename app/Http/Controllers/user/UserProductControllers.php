<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\product;
use Illuminate\Http\Request;

class UserProductControllers extends Controller
{
   
    public function detailProduct($slug,$id)
    {
       $detailProduct =product::find($id);
       $title_page=$detailProduct->product_name;
       $relatedProducts =product::
       where('product_isPublished', true)
       ->where('product_category_id', $detailProduct['product_category_id'])
       ->where('id', '!=', $id)
       ->get();
       $comments=Comment::where([
        'comment_product_id'=>$id,
        'comment_parent_id'=>0,
       ])->orderBy("created_at","desc")->latest()->paginate(5);
       return view('pages.detailProduct',compact("detailProduct",'relatedProducts','title_page','comments'));
    }
   //  tìm kiếm sản phẩm
   public function searchResult(Request $request)
   {
       $query = $request->input('text');
       $products = product::where('product_name', 'like', '%' . $query . '%')
                           ->orWhere('product_description', 'like', '%' . $query . '%')
                           ->get();

       return view('pages.searchResult',  compact("products","query"));
   }
}