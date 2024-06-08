<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\product;
use App\Models\Size;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserOrderControllers extends Controller
{
    public function viewCheckout(){
        $user=Auth::user();
        $carts = Cart::where('cart_userId', $user->id)->get();
        $totalPrice= 0;
        foreach($carts as $cartItem){
            $totalPrice+=$cartItem->cart_quantity*$cartItem->product->product_price;
        }
        return view('pages.checkout',compact("carts",'user','totalPrice'));
    }
    
    
    public function addOrder(){
        try {
        DB::beginTransaction();
        $user=Auth::user();
        $userId=$user->id; 
        $carts = Cart::where('cart_userId', $userId)->get();
           // Tạo một đơn hàng mới
           $order = new Order([
            'od_user_id' => $userId,
            'od_shippingAddress' => $user['user_address'],
            'od_shippingPrice' => 25000,
            'od_dateShipping' => date('Y-m-d H:i:s', strtotime('+' . rand(0, 7) . ' days')),
        ]);
        Notification::create([
            "n_title"=>'Bạn có một đơn hàng mới!',
            "n_subtitle"=>"Ngày đặt hàng".\Carbon\Carbon::parse($order ->created_at)->locale('vi')->isoFormat('dddd, DD/MM/YYYY')  ,
            "n_image"=>"https://imaxmobile.vn/media/data/icon-giao-hang-toan-quoc.jpeg",
            "n_link"=>"/admin/order"
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
                        $foundProduct = product::find($cartItem->cart_productId);
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

    public function isCanceled($oid){
        try {
            DB::beginTransaction(); 
            $order = Order::find($oid);  
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
            $order->od_is_canceled = true; 
            $order->save();
            // Tạo một đối tượng Carbon cho ngày hiện tại
            $currentDate = Carbon::now();
            // Định dạng ngày tháng năm theo định dạng cụ thể và cài đặt ngôn ngữ là tiếng Việt
            $formattedDate = $currentDate->locale('vi')->isoFormat('dddd, DD/MM/YYYY');
            Notification::create([
                'n_user_id'=>$order->od_user_id,
                "n_title"=>'Đơn hàng của bạn đã bị hủy!',
                "n_subtitle"=>"Ngày hủy ".$formattedDate  ,
                "n_image"=>"https://imaxmobile.vn/media/data/icon-giao-hang-toan-quoc.jpeg",
                "n_link"=>"/"
            ]);
            DB::commit(); 
            return response()->json(['code' => 200, 'message' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();  
            // Send error response
            return response()->json(['code' => 500, 'message' => $e->getMessage()]);
        }
    }
    
    public function showOrder()
    {
        // Lấy user_id từ session
        $userId = Session::get('user_id');
        // Lấy phần cuối của URL
        $lastSegment = Str::afterLast(request()->url(), '/');
        // Xác định trạng thái đơn hàng
        $statusFilters = [
            'order' => [],
            'confirm' => ['od_is_canceled' => false, 'od_is_confirm' => false],
            'confirm-delivery' => ['od_is_canceled' => false, 'od_is_confirm' => true,
                                  'od_is_confirm_delivery' => false],
            'delivering' => ['od_is_canceled' => false, 'od_is_confirm' => true,
                             'od_is_confirm_delivery' => true, 'od_is_delivering' => false],
            'success' => ['od_is_canceled' => false, 'od_is_confirm' => true, 
                          'od_is_confirm_delivery' => true, 'od_is_delivering' => true, 
                          'od_is_success' => true],
            'canceled' => ['od_is_canceled' => true],
        ];
        // Thiết lập điều kiện tìm kiếm đơn hàng
        $query = Order::where('od_user_id', $userId)->orderBy('created_at', 'DESC');
        if (array_key_exists($lastSegment, $statusFilters)) {
            $query->where($statusFilters[$lastSegment]);
        } else {
            // Nếu phần cuối của URL không phù hợp với bất kỳ trạng thái nào, xử lý lỗi 404 hoặc chuyển hướng tùy ý
            // Đây là một ví dụ:
            abort(404);
        }
        // Lấy danh sách đơn hàng
        $orders = $query->get();
        $active = $lastSegment;
        // Trả về view 'pages.order.orderList' với dữ liệu đơn hàng và active
        return view('pages.order.orderList', compact('orders', 'active'));
    }
}