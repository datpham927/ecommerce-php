<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentControllers extends Controller
{
     public function create(Request $request, $pid) {
         try {  
            DB::beginTransaction();
             $comment = Comment::create([
                 "comment_product_id" => $pid,
                 "comment_user_id" => Auth::user()->id,
                 "comment_content" => $request->comment_text,
                 "comment_rating" => $request->comment_rating,
                 "comment_parent_id" => 0 
             ]); 
             Notification::create([
                "n_title"=>'Bạn có một bình luận mới!',
                "n_subtitle"=>$comment->product->product_name,
                "n_image"=>$comment->product->product_thumb,
                "n_link"=>$request->pathName
            ]);
         
            DB::commit();
             return response()->json([
                 'code' => 200,
                 'message' => "Bình luận thành công!",
                 'data' => [
                    "user" => Auth::user(),
                    "comment"=>[
                        "comment_content" => $comment->comment_content,
                        "create_at" =>Carbon::parse($comment->created_at)->locale('vi')->diffForHumans()
                    ]
                 ] // Trả về dữ liệu của bình luận mới được tạo
             ]);
     
         } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'message' => $th->getMessage(), 
            ]);
         }
     }
     

     public function createCommentChildren(Request $request, $pid, $cid) {
        try {
            DB::beginTransaction();
    
            $comment = Comment::create([
                "comment_product_id" => $pid,
                "comment_user_id" => Auth::user()->id,
                "comment_content" => $request->comment_text,
                "comment_parent_id" => $cid
            ]);
    
            $userParentCmt = Comment::find($cid);
            Notification::create([
                'n_user_id' => $userParentCmt->comment_user_id,
                "n_title" => (Auth::user()->user_name ?? Auth::user()->user_email) . ' đã phản hồi bình luận của bạn!',
                "n_subtitle" => $comment->product->product_name,
                "n_image" => Auth::user()->user_image_url,
                "n_link" => $request->pathName
            ]);
    
            DB::commit();
    
            return response()->json([
                'code' => 200,
                'message' => "Bình luận thành công!",
                'data' => [
                    "user" => Auth::user(),
                    "comment" => [
                        "id" => $comment->id,
                        "comment_content" => $comment->comment_content,
                        "created_at" => Carbon::parse($comment->created_at)->locale('vi')->diffForHumans()
                    ]
                ] // Trả về dữ liệu của bình luận mới được tạo
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'message' => $th->getMessage(),
            ]);
        }
    }
    
    public function delete($cid) {
     try {
        $comment = Comment::find($cid);
        // Kiểm tra nếu bình luận là bình luận cha
        if ($comment->comment_parent_id == 0) {
            // Xóa tất cả các bình luận con (phản hồi) của bình luận cha trước
            Comment::where('comment_parent_id', $cid)->delete();
        }
        // Sau đó, xóa bình luận
        $comment->delete();
        return response()->json(['code'=>200,"message"=>"Bạn đã xóa bình luận!"]);
     } catch (\Throwable $th) {
        return response()->json(['code'=>500,
                     'error'=>$th->getMessage(),           
                     "message"=>"Không thành công!"]);
     }
    }
    
}