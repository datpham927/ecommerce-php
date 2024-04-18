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
use PhpParser\Node\Stmt\TryCatch;
class OrderControllers extends Controller
{

//     public function index(Request $request)
// {
//     // Lấy user_id từ session
//     $userId = Session::get('user_id');
//     // Lấy danh sách đơn hàng của người dùng, nhóm theo product order_id_canceled=true và sắp xếp theo thời gian tạo giảm dần
//     // Khởi tạo biến $orders và $active
//     $orders = [];
//     $active = '';

//     // Lấy phần cuối của URL
//     $currentUrl = request()->url();
//     $lastSegment = Str::afterLast($currentUrl, '/');
    
//     if ($lastSegment == 'order') {
//         $orders = Order::orderBy('created_at', 'DESC')
//                     ->paginate(5);
//         $active = 'order';
//     } elseif ($lastSegment == 'confirm') {
//         $orders = Order::where('od_is_canceled', false)
//                     ->where('od_is_confirm', false)
//                     ->orderBy('created_at', 'DESC')
//                     ->paginate(5);
//         $active = 'confirm';
//     } elseif ($lastSegment == 'confirm-delivery') {
//         $orders = Order::where('od_is_canceled', false)
//                     ->where('od_is_confirm', true)
//                     ->where('od_is_confirm_delivery', false)
//                     ->orderBy('created_at', 'DESC')
//                     ->paginate(5);
//         $active = 'confirm-delivery';
//     } elseif ($lastSegment == 'delivered') {
//         $orders = Order::where('od_is_canceled', false)
//                     ->where('od_is_confirm', true)
//                     ->where('od_is_confirm_delivery', true)
//                     ->where('od_is_delivering', false)
//                     ->orderBy('created_at', 'DESC')
//                     ->paginate(5);
//         $active = 'delivered';
//     } elseif ($lastSegment == 'success') {
//         $orders = Order::where('od_is_canceled', false)
//                     ->where('od_is_confirm', true)
//                     ->where('od_is_confirm_delivery', true)
//                     ->where('od_is_delivering', true)
//                     ->where('od_is_success', true)
//                     ->orderBy('created_at', 'DESC')
//                     ->paginate(5);
//         $active = 'success';
//     } elseif ($lastSegment == 'canceled') {
//         $orders = Order::where('od_is_canceled', true)
//                     ->orderBy('created_at', 'DESC')
//                     ->paginate(5);
//         $active = 'canceled';
//     }
//     $code = $request->input('code');
//     if($code) {
//         $orders= $orders->find($orders);
//     }  
    

    
//     return view('admin.order.index', compact('orders','active'));
// }

public function index(Request $request)
{
    // Lấy user_id từ session
    $userId = Session::get('user_id');
    // Lấy phần cuối của URL
    $lastSegment = Str::afterLast(request()->url(), '/');
    // Kiểm tra và lấy các tham số từ request
    $code = $request->input('code');
    if (isset($code)) {
        $active = $lastSegment;
        // Lấy đơn hàng dựa trên mã
        $orders = Order::where('id', $code)->get();
        return view('admin.order.index', compact('orders', 'active', 'code'));
    }
    // Xác định trạng thái đơn hàng và lấy danh sách đơn hàng tương ứng
    $statusFilters = [
        'order' => null,
        'confirm' => ['od_is_canceled' => false, 'od_is_confirm' => false],
        'confirm-delivery' => ['od_is_canceled' => false, 'od_is_confirm' => true, 'od_is_confirm_delivery' => false],
        'delivered' => ['od_is_canceled' => false, 'od_is_confirm' => true, 'od_is_confirm_delivery' => true, 'od_is_delivering' => false],
        'success' => ['od_is_canceled' => false, 'od_is_confirm' => true, 'od_is_confirm_delivery' => true, 'od_is_delivering' => true, 'od_is_success' => true],
        'canceled' => ['od_is_canceled' => true],
    ];
       $query = Order::orderBy('created_at', 'DESC');
       // Kiểm tra xem phần cuối của URL có phải là một trạng thái hợp lệ hay không
       if (array_key_exists($lastSegment, $statusFilters)) {
        $query = Order::orderBy('created_at', 'DESC');
        // Lọc theo trạng thái
        if ($statusFilters[$lastSegment] !== null) {
            $query->where($statusFilters[$lastSegment]);
        }
        // Kiểm tra xem có tham số 'date' được truyền không và lọc theo ngày
        $date = $request->input('date');
        if (isset($date)) {
            $formattedDate = date('Y-m-d', strtotime($date));
            $query->whereDate('created_at', $formattedDate);
        };
        // Phân trang kết quả
        $orders = $query->paginate(5);
        $active = $lastSegment;
    } else {
        // Nếu phần cuối của URL không phù hợp với bất kỳ trạng thái nào, chuyển hướng hoặc xử lý lỗi 404 tại đây
        // Đây là một ví dụ:
        abort(404);
    }

    return view('admin.order.index', compact('orders', 'active'));
}



// public function confirmOrderStatus($oid){
//     try {
//         $currentUrl = request()->url();
//         $segmentBeforeLast = Str::beforeLast($currentUrl, '/');
//         $lastSegment = Str::afterLast($segmentBeforeLast, '/');
//         $order = Order::find($oid);
//         return   response()->json(['code' => 200, 'message' => $lastSegment]);
//         switch ($lastSegment) {
//             case 'confirm':
//                 $order->od_is_confirm = true;
           
//                 break;
//             case 'confirm-delivery':
//                 $order->od_is_confirm_delivery = true;
//                 break;
//             case 'delivering':
//                 $order->od_is_delivering = true;
//                 break;
//             case 'success':
//                 $order->od_is_success = true;
//                 break;
//         }
        
//         $order->save();
//         return response()->json(['code' => 200, 'message' => 'true']);
        
//     } catch (\Exception $e) {
//         // Log error
//         Log::error($e->getMessage());
//         // Send error response
//         return response()->json(['code' => 500, 'message' => 'failed']);
//     }
// }


public function isConfirm($oid){
    try {
        $order = Order::find($oid);
        $order->od_is_confirm = true;
        $order->save();
        return response()->json(['code' => 200, 'message' => 'true']);
    } catch (\Exception $e) {
        // Log error
        Log::error($e->getMessage());
        // Send error response
        return response()->json(['code' => 500, 'message' => 'failed']);
    }
}
public function isConfirmDelivery($oid){
    try {
        $order = Order::find($oid);
        $order->od_is_confirm_delivery = true;
        $order->save();
        return response()->json(['code' => 200, 'message' => 'true']);
    } catch (\Exception $e) {
        // Log error
        Log::error($e->getMessage());
        // Send error response
        return response()->json(['code' => 500, 'message' => 'failed']);
    }
}
public function isDelivered($oid){
    try {
        $order = Order::find($oid);
        $order->od_is_delivering = true;
        $order->od_is_success = true;
        $order->save();
        return response()->json(['code' => 200, 'message' => 'true']);
    } catch (\Exception $e) {
        // Log error
        Log::error($e->getMessage());
        // Send error response
        return response()->json(['code' => 500, 'message' => 'failed']);
    }
}
    // ------------ user -------------
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
        $query = Order::where('od_userId', $userId)->orderBy('created_at', 'DESC');
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