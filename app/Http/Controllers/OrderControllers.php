<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\product;
use App\Models\Size;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class OrderControllers extends Controller
{

    public function index()
    {
        // Lấy user_id từ session
        $userId = Session::get('user_id');
        // Lấy danh sách đơn hàng của người dùng, nhóm theo product order_id_canceled=true và sắp xếp theo thời gian tạo giảm dần
        $orders = OrderDetail::get();
        // Trả về view 'pages.orderList' với dữ liệu đơn hàng
        return view('order.index', compact('orders'));
    }


    public function viewCheckout(){
        $userId = Session::get('user_id');
        $user=User::find($userId);
        $carts = Cart::where('cart_userId', $userId)->get();
        $totalPrice= 0;
        foreach($carts as $cartItem){
            $totalPrice+=$cartItem->cart_quantity*$cartItem->product->product_price;
        }
        return view('pages.checkout',compact("carts",'user','totalPrice'));
    }
    
    
    public function addOrder(){
        try {
        DB::beginTransaction();
        $userId = Session::get('user_id');
        $user=User::find($userId);
        $carts = Cart::where('cart_userId', $userId)->get();
           // Tạo một đơn hàng mới
           $order = new Order([
            'od_userId' => $userId,
            'od_shippingAddress' => $user['user_address'],
            'od_shippingPrice' => 25000,
            'od_dateShipping' => date('Y-m-d H:i:s', strtotime('+' . rand(0, 7) . ' days')),
        ]);
        
        $order->save(); // Lưu đơn hàng mới vào cơ sở dữ liệu để lấy được ID
        foreach($carts as $cartItem){
        

            // Tạo một chi tiết đơn hàng mới
            $orderDetail = new OrderDetail([
                'od_detail_productId' => $cartItem->cart_productId,
                'od_detail_orderId' => $order->id, // Sử dụng ID của đơn hàng mới tạo
                'od_detail_quantity' => $cartItem->cart_quantity,
                'od_detail_price' => $cartItem->product->product_price,
                'od_detail_size' => $cartItem->cart_size,
            ]);
            $orderDetail->save(); // Lưu chi tiết đơn hàng mới vào cơ sở dữ liệu

                // cập nhật số lượng trong product
             // Tìm sản phẩm trong cơ sở dữ liệu dựa trên ID của sản phẩm trong giỏ hàng
                        $foundCart = Product::find($cartItem->cart_productId);

                        // Cập nhật số lượng sản phẩm đã bán và số lượng tồn kho
                        $foundCart->product_sold += $cartItem->cart_quantity;
                        $foundCart->product_stock -= $cartItem->cart_quantity;
                        $foundCart->save();

                        // Cập nhật số lượng sản phẩm trong kích thước
                        $foundProductSize = Size::where([
                            "size_product_id" => $cartItem->cart_productId,
                            "size_name" => $cartItem->cart_size,
                        ])->first();

                        if ($foundProductSize) {
                            $foundProductSize->size_product_quantity -= $cartItem->cart_quantity;
                            $foundProductSize->save();
                        }

                        // Xóa sản phẩm khỏi giỏ hàng
                        $foundCartItem = Cart::find($cartItem->id);
                        $foundCartItem->delete();

        }
        DB::commit(); // Hoàn thành giao dịch
        return redirect()->route("order.orderList")->with('success', 'Đặt hàng thành công!');
        } catch (\Throwable $exception) {
            DB::rollBack(); // Hoàn tác giao dịch (không lưu)
            dd("Message: " . $exception->getMessage() . ", Line: " . $exception->getLine());
        }
    
    }

    public function isCanceled($oid){
        try {
            $orderDetail= OrderDetail::find($oid);
            $order= Order::find($orderDetail['od_detail_orderId']);;
            $order["od_is_canceled"]=true;
            $order->save();
            return response()->json(['code' => 200, 'message' => 'success']);
        } catch (\Exception $e) {
            // Log error
            Log::error($e->getMessage());
            // Send error response
            return response()->json(['code' => 500, 'message' => 'failed']);
        }
    }


    public function viewAllOrder()
    {
        // Lấy user_id từ session
        $userId = Session::get('user_id'); 
        // Lấy danh sách order detail của người dùng, 
        // khi đơn hàng chưa canceled order_id_canceled = true 
        // và sắp xếp theo thời gian tạo giảm dần
        $orders = Order::where(['od_userId'=> $userId],
        [ 'od_is_canceled'=>false]   )->get() ; 
        // Trả về view 'pages.orderList' với dữ liệu đơn hàng
        return view('pages.order.orderList', compact('orders'));
    }
}