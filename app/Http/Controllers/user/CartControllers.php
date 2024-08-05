<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartControllers extends Controller
{
    public function addToCart(Request $request)
    {
        
        if(!Auth::check())   return back()->with('error', 'Vui lòng đăng nhập!');
        if(!$request->has("size_hidden")){ 
            return back()->with('error', 'Vui lòng chọn kích thước!');
        }
        if($request->input("quantity") == 0){ 
            return back()->with('error', 'Vui lòng chọn số lượng!');
        }
        $userId =Auth::user()->id;
        $data = [ 
            "cart_user_id" => $userId,
            "cart_product_id" => $request->input("productId_hidden"),
            "cart_quantity" =>$request->input("quantity"),
            "cart_size" => $request->input("size_hidden"),
        ];
        // Check if the product is already in the cart for the user
        $foundCart = Cart::where('cart_product_id', $data["cart_product_id"])
                         ->where('cart_user_id', $userId)
                         ->where('cart_size', $data['cart_size'])
                         ->first();
        
        if($foundCart){
            // Update existing cart item
            $foundCart["cart_quantity"] = $data["cart_quantity"];
            $foundCart->save();
        } else {
            // Create new cart item
            $cart = new Cart($data);
            $cart->save();
        }
        
        return back()->with('success', 'Đã thêm vào giỏ hàng!');
    }
    public function viewListCart()
    {
        if(!Auth::check())   return back()->with('error', 'Vui lòng đăng nhập!');
        $userId =Auth::user()->id;
        $carts = Cart::where('cart_user_id', $userId)->get();
        $breadcrumb = [
            ['label' => 'Giỏ hàng', 'link' => null],
        ];
        
        return view('client.pages.cart',compact("carts",'breadcrumb'));
    }
    
    public function increase($cid)
    {
        try {
            // Tìm giỏ hàng dựa trên ID của nó
            $foundCart = Cart::find($cid);
    
            // Tìm kích thước sản phẩm trong cơ sở dữ liệu
            $foundProductSize = Size::where([
                "size_product_id" => $foundCart->cart_product_id,
                "size_name" => $foundCart->cart_size,
            ])->first();  
            // Kiểm tra xem số lượng sản phẩm trong giỏ hàng đã vượt quá số lượng tồn kho hay không
            if ($foundCart->cart_quantity >= $foundProductSize->size_product_quantity) {
                return response()->json(['code' => 201, 'message' => 'Hết hàng trong kho!']);
            }
            // Tăng số lượng của sản phẩm trong giỏ hàng lên 1 và lưu lại
            $foundCart["cart_quantity"] += 1;
            $foundCart->save();
    
            // Trả về thông báo thành công
            return response()->json(['code' => 200, 'message' => $foundCart->cart_quantity ]);
        } catch (\Exception $e) {
            // Ghi log lỗi
            Log::error($e->getMessage());
            // Trả về thông báo lỗi
            return response()->json(['code' => 500, 'message' => 'Thất bại']);
        }
    }
    
    public function decrease($cid)
    {
        try {
            $foundCart = Cart::find($cid);
          
            if ($foundCart['cart_quantity'] <= 1) {
                $foundCart->delete(); // Delete the cart item if the quantity is 1
            } else {
                $foundCart['cart_quantity'] -= 1;
                $foundCart->save();
            }
            return response()->json(['code' => 200, 'message' => 'success']);
        } catch (\Exception $e) {
            // Log error
            Log::error($e->getMessage());
            // Send error response
            return response()->json(['code' => 500, 'message' => 'failed']);
        }
    }
    public function delete($cid)
    {
        try {
            $foundCart = Cart::find($cid);
            $foundCart->delete();
            return response()->json(['code' => 200, 'message' => 'success']);
        } catch (\Exception $e) {
            // Log error
            Log::error($e->getMessage());
            // Send error response
            return response()->json(['code' => 500, 'message' => 'failed']);
        }
    }
}
