<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentControllers extends Controller
{
     public function create(Request $request, $pid) {
         try {  
             $comment = Comment::create([
                 "comment_product_id" => $pid,
                 "comment_user_id" => Auth::user()->id,
                 "comment_content" => $request->comment_text,
                 "comment_parent_id" => 0 
             ]); 
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
            return response()->json([
                'code' => 500,
                'message' => $th->getMessage(), 
            ]);
         }
     }
     

     public function createCommentChildren(Request $request, $pid,$cid) {
        try {  
            $comment = Comment::create([
                "comment_product_id" => $pid,
                "comment_user_id" => Auth::user()->id,
                "comment_content" => $request->comment_text,
                "comment_parent_id" => $cid
            ]); 
            return response()->json([
                'code' => 200,
                'message' => "Bình luận thành công!",
                'data' => [
                   "user" => Auth::user(),
                   "comment"=>[
                      "id"=> $comment->id,
                       "comment_content" => $comment->comment_content,
                       "create_at" =>Carbon::parse($comment->created_at)->locale('vi')->diffForHumans()
                   ]
                ] // Trả về dữ liệu của bình luận mới được tạo
            ]);
    
        } catch (\Throwable $th) {
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