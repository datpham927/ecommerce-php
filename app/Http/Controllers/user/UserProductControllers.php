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
       //update lượt xem
       $detailProduct->product_views+=1;
       $detailProduct->save();
       // cập nhật rating product
       $comments= Comment::where("comment_parent_id",0)->get();
       $countComment=$comments->count();
       if($countComment>0){
          $totalRating=0;
          foreach ($comments as $cmt) { 
            $totalRating+=$cmt->comment_rating;
          }
          $detailProduct->update([
              "product_ratings"=>$totalRating/$countComment
          ]);
       }
     
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
       return view('client.pages.detailProduct.index',compact("detailProduct",'relatedProducts','title_page','comments'));
    }
   //  tìm kiếm sản phẩm
   public function searchResult(Request $request)
   {
       $query = $request->input('text');
       $products = product::where('product_name', 'like', '%' . $query . '%')
                           ->orWhere('product_description', 'like', '%' . $query . '%')
                           ->latest()->paginate(18);

       return view('client.pages.searchResult',  compact("products","query"));
   }
}