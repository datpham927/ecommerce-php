<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Repository\Interfaces\ProductRepositoryInterface;
use App\Repository\Interfaces\UserInterestedCategoryRepositoryInterface;
use App\Repository\Interfaces\ViewsRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProductControllers extends Controller
{
    protected $productRepository,$userInterestedCategory;
    public function __construct(ProductRepositoryInterface $productRepository,UserInterestedCategoryRepositoryInterface $userInterestedCategory)
    {
        $this->productRepository = $productRepository;
        $this->userInterestedCategory = $userInterestedCategory;
    }
    public function detailProduct($slug,$id)
    {
       $detailProduct = $this->productRepository->findById($id);
       //update lượt xem
       $detailProduct->product_views+=1; 
       $detailProduct->save();
       $categoryId=$detailProduct['product_category_id'];
       if(Auth::check()){
        $userId=Auth::user()->id;
        $this->userInterestedCategory->createOrUpdateViews($categoryId,$userId);
       }
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
       $relatedProducts =  $this->productRepository
                  ->getProductsByCategoryId($detailProduct['product_category_id'],$id);
       $comments=Comment::where([
        'comment_product_id'=>$id,
        'comment_parent_id'=>0,
       ])->orderBy("created_at","desc")->latest()->paginate(5);

       $category=$detailProduct->Category;
       $breadcrumb = [
        ['label' =>$category->category_name, 'link' =>route('category.show_product_home', ['cid' => $category->id, 'slug' => $category->category_slug])],
        ['label' => $detailProduct->product_name, 'link' => null],
    ];
       return view('client.pages.detailProduct.index',compact("detailProduct",'relatedProducts',
       'title_page','comments','breadcrumb'));
    }
   //  tìm kiếm sản phẩm
   public function searchResult(Request $request)
   {
       $name = $request->input('text');
       $products = $this->productRepository->searchProductByName( $name ,18);
            $breadcrumb = [
            ['label' => 'Tìm kiếm', 'link' => null],
        ];
       return view('client.pages.searchResult',  compact("products","query",'breadcrumb'));
   }
}