<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class OrderControllers extends Controller
{
    public function index(Request $request)
{
    
    // Xác định trạng thái đơn hàng và lấy danh sách đơn hàng tương ứng
    $statusFilters = [
        'order' => null,
        'confirm' => ['od_is_canceled' => false, 'od_is_confirm' => false],
        'confirm-delivery' => ['od_is_canceled' => false, 'od_is_confirm' => true, 'od_is_confirm_delivery' => false],
        'delivered' => ['od_is_canceled' => false, 'od_is_confirm' => true, 'od_is_confirm_delivery' => true, 'od_is_delivering' => false],
        'success' => ['od_is_canceled' => false, 'od_is_confirm' => true, 'od_is_confirm_delivery' => true, 'od_is_delivering' => true, 'od_is_success' => true],
        'canceled' => ['od_is_canceled' => true],
    ];
    // Lấy phần cuối của URL
    $lastSegment = Str::afterLast(request()->url(), '/');
    // Kiểm tra và lấy các tham số từ request
    $code = $request->input('code');
    $date = $request->input('date');
    if (isset($code)) {
        $active = $lastSegment;
        $query = Order::where('id', $code)->where($statusFilters[$lastSegment]);
        if (isset($date)) {
            $formattedDate = date('Y-m-d', strtotime($date));
            $query->whereDate('created_at', $formattedDate);
        }
        $orders = $query->get();
        return view('admin.order.index', compact('orders', 'active', 'code', 'date'));
    }
    if (array_key_exists($lastSegment, $statusFilters)) {
        $query = Order::orderBy('created_at', 'DESC')->where($statusFilters[$lastSegment]);
        if (isset($date)) {
            $formattedDate = date('Y-m-d', strtotime($date));
            $query->whereDate('created_at', $formattedDate);
        }
        $orders = $query->paginate(5);
        $active = $lastSegment;
    } else {
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

public function getOrderDetailByAdmin($oid){
        $orderDetail=Order::find($oid);
        return view('admin.order.detail',compact('orderDetail'));
}

}
