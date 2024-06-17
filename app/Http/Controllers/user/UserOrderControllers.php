<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Feeship;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
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
        $user = Auth::user();
        // Eager load products with cart items to reduce the number of queries
        $carts = Cart::with('product')->where('cart_user_id', $user->id)->get();
        // Retrieve feeship in one query using whereIn for better performance
        $foundFeeship = Feeship::where([
            'matp' => $user->user_city_id,
            'maqh' => $user->user_province_id,
            'xaid' => $user->user_ward_id
        ])->value('feeship');
        // Calculate total price within the collection
        $totalPrice = $carts->sum(function($cartItem) {
            return $cartItem->cart_quantity * $cartItem->product->product_price;
        });
        // Use the null coalescing operator to handle the feeship
        $feeship = $foundFeeship ?? 0;
        return view('client.pages.checkout', compact('carts', 'user', 'totalPrice', 'feeship'));
    }
    
    public function addOrder(Request $request)
{
    try {
        DB::beginTransaction();
        $user = Auth::user();
        $userId = $user->id;
        $carts = Cart::with('product')->where('cart_user_id', $userId)->get();
        if(!$request["user_address"] ){
            return redirect()->back()->with('error', 'Vui lòng cập nhât thông tin trước khi đặt hàng! ');
        }
        if(!$request["user_address_detail"] ||!$request["user_phone"]){
            return redirect()->back()->with('error', 'Vui lòng nhập thông tin đầy đủ! ');
        }

        // Create a new order
        $order = new Order([
            'od_user_id' => $userId,
            'od_user_name' =>$request["user_name"],
            'od_user_phone' => $request["user_phone"],
            'od_shipping_address' => $request["user_address"],
            'od_shipping_address_detail' => $request["user_address_detail"] ,
            'od_shipping_price' =>  $request["feeship"],
            'od_date_shipping' => now()->addDays(rand(0, 7)),
            // 'od_is_pay' => false,
            // 'od_paymentMethod' => 'CASH',
        ]);
        $order->save();

        // Create a new notification
        Notification::create([
            "n_title" => 'Bạn có một đơn hàng mới!',
            "n_subtitle" => "Ngày đặt hàng " . \Carbon\Carbon::parse($order->created_at)->locale('vi')->isoFormat('dddd, DD/MM/YYYY'),
            "n_image" => "https://imaxmobile.vn/media/data/icon-giao-hang-toan-quoc.jpeg",
            "n_link" => "/admin/order"
        ]);

        foreach ($carts as $cartItem) {
            // Create a new order detail
            $OrderItem = new OrderItem([
                'od_item_productId' => $cartItem->cart_product_id,
                'od_item_orderId' => $order->id,
                'od_item_quantity' => $cartItem->cart_quantity,
                'od_item_price' => $cartItem->product->product_price,
                'od_item_size' => $cartItem->cart_size,
            ]);
            $OrderItem->save();

            // Update product quantity and stock
            $product = $cartItem->product;
            $product->product_sold += $cartItem->cart_quantity;
            $product->product_stock -= $cartItem->cart_quantity;
            $product->save();
            // Update product size quantity
            $productSize = Size::where([
                'size_product_id' => $cartItem->cart_product_id,
                'size_name' => $cartItem->cart_size,
            ])->first();
            if ($productSize) {
                $productSize->size_product_quantity -= $cartItem->cart_quantity;
                $productSize->save();
            }
            // Remove cart item
            $cartItem->delete();
        }
        DB::commit();
        return redirect()->route('order.order_list')->with('success', 'Đặt hàng thành công!');
    } catch (\Throwable $exception) {
        DB::rollBack();
        dd($exception->getMessage());
        return redirect()->back()->with('error', 'Đặt hàng thất bại! ' . $exception->getMessage());
    }
}


    public function isCanceled($oid){
        try {
            DB::beginTransaction(); 
            $order = Order::find($oid);  
            foreach($order->OrderItem as $OrderItemItem){  
                $foundProduct = Product::find($OrderItemItem->od_item_productId); 
                // Cập nhật số lượng sản phẩm đã bán và số lượng tồn kho
                $foundProduct->product_sold -= $OrderItemItem->od_item_quantity;
                $foundProduct->product_stock += $OrderItemItem->od_item_quantity; 
                $foundProduct->save();
                // Cập nhật số lượng sản phẩm trong kích thước
                $foundProductSize = Size::where([
                    "size_product_id" => $OrderItemItem->od_item_productId, 
                    "size_name" => $OrderItemItem->od_item_size,  
                ])->first();
                if ($foundProductSize) {
                    $foundProductSize->size_product_quantity += $OrderItemItem->od_item_quantity;  
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
        return view('client.pages.order.orderList', compact('orders', 'active'));
    }
}