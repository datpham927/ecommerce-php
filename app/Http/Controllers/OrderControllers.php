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
use Illuminate\Support\Str;
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
                        $foundProduct = Product::find($cartItem->cart_productId);

                        // Cập nhật số lượng sản phẩm đã bán và số lượng tồn kho
                        $foundProduct->product_sold += $cartItem->cart_quantity;
                        $foundProduct->product_stock -= $cartItem->cart_quantity;
                        $foundProduct->save();

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
                        $foundProductCart = Cart::find($cartItem->id);
                        $foundProductCart->delete();

        }
        DB::commit(); // Hoàn thành giao dịch
        return redirect()->route("order.order_list")->with('success', 'Đặt hàng thành công!');
        } catch (\Throwable $exception) {
            DB::rollBack(); // Hoàn tác giao dịch (không lưu)
            dd("Message: " . $exception->getMessage() . ", Line: " . $exception->getLine());
        }
    
    }

    public function isCanceled(Request $request,$oid){
        try {
            DB::beginTransaction();
            $orderDetail = OrderDetail::find($oid);
            $order = Order::find($orderDetail->od_detail_orderId);  
            $order->od_is_canceled = true; 
            $order->save();
            foreach($order->OrderDetail as $orderDetailItem){  
                $foundProduct = Product::find($orderDetailItem->od_detail_productId); 
                // Cập nhật số lượng sản phẩm đã bán và số lượng tồn kho
                $foundProduct->product_sold -= $orderDetailItem->od_detail_quantity;
                $foundProduct->product_stock += $orderDetailItem->od_detail_quantity; 
                $foundProduct->save();
                // Cập nhật số lượng sản phẩm trong kích thước
                $foundProductSize = Size::where([
                    "size_product_id" => $orderDetailItem->od_detail_productId, 
                    "size_name" => $orderDetailItem->od_detail_size,  
                ])->first();
                if ($foundProductSize) {
                    $foundProductSize->size_product_quantity += $orderDetailItem->od_detail_quantity;  
                    $foundProductSize->save();
                }
            }
            DB::commit(); 
            return response()->json(['code' => 200, 'message' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack(); 
            // Log error
            Log::error($e->getMessage());
            // Send error response
            return response()->json(['code' => 500, 'message' => 'failed']);
        }
    }
    

    public function showOrder()
    {
        // Lấy user_id từ session
        // Lấy user_id từ session
        $userId = Session::get('user_id');

        // Khởi tạo biến $orders và $active
        $orders = [];
        $active = '';

        // Lấy phần cuối của URL
        $currentUrl = request()->url();
        $lastSegment = Str::afterLast($currentUrl, '/');

        // Thiết lập điều kiện để lấy danh sách đơn hàng
        if ($lastSegment == 'order') {
            $orders = Order::where('od_userId', $userId)
                        ->where('od_is_canceled', false)
                        ->get();
            $active = 'order';
        } elseif ($lastSegment == 'confirm') {
            $orders = Order::where('od_userId', $userId)
                        ->where('od_is_canceled', false)
                        ->where('od_is_confirm', false)
                        ->get();
            $active = 'confirm';
        } elseif ($lastSegment == 'confirm-delivery') {
            $orders = Order::where('od_userId', $userId)
                        ->where('od_is_canceled', false)
                        ->where('od_is_confirm', true)
                        ->where('od_is_confirm_delivery', false)
                        ->get();
            $active = 'confirm-delivery';
        } elseif ($lastSegment == 'delivering') {
            $orders = Order::where('od_userId', $userId)
                        ->where('od_is_canceled', false)
                        ->where('od_is_confirm', true)
                        ->where('od_is_confirm_delivery', true)
                        ->where('od_is_delivering', false)
                        ->get();
            $active = 'delivering';
        } elseif ($lastSegment == 'success') {
            $orders = Order::where('od_userId', $userId)
                        ->where('od_is_canceled', false)
                        ->where('od_is_confirm', true)
                        ->where('od_is_confirm_delivery', true)
                        ->where('od_is_delivering', true)
                        ->where('od_is_success', true)
                        ->get();
            $active = 'success';
        } elseif ($lastSegment == 'canceled') {
            $orders = Order::where('od_userId', $userId)
                        ->where('od_is_canceled', true)
                        ->get();
            $active = 'canceled';
        }
        // Trả về view 'pages.order.orderList' với dữ liệu đơn hàng và active
            return view('pages.order.orderList', compact('orders', 'active'));
    }
}