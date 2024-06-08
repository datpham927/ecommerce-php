<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class OrderControllers extends Controller
{
    public function index(Request $request)
{
    
    // Xác định trạng thái đơn hàng và lấy danh sách đơn hàng tương ứng
    // Lấy phần cuối của URL
    $lastSegment = Str::afterLast(request()->url(), '/');
    // trạng thái đơn hàng
    $statusFilters=config('constants.statusFilters');
    // Kiểm tra và lấy các tham số từ request
    $code = $request->input('code');
    $date = $request->input('date');
    // tìm kiếm
    if (isset($code)) {
        $active = $lastSegment;
        $query = Order::where('id', $code)
                ->where($statusFilters[$lastSegment]);
       if (isset($date)) {
            $formattedDate = date('Y-m-d', strtotime($date));
            $query->whereDate('created_at', $formattedDate);
        }
        $orders = $query->get();
        return view('admin.order.index', compact('orders', 'active', 'code', 'date'));
    }
    //
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
//         $currentUrl = Request::url();
//         $segmentBeforeLast = Str::beforeLast($currentUrl, '/');
//         $lastSegment = Str::afterLast($segmentBeforeLast, '/');
//         $order = Order::find($oid);
//         // Thêm định dạng ngày tháng năm
//         $formattedDate = Carbon::now()->locale('vi')->isoFormat('dddd, DD/MM/YYYY');
//         $updates=[
//             'confirm' => ['od_is_confirm' => true],
//             'confirm-delivery' => ['od_is_confirm_delivery' => true],
//             'delivering' => ['od_is_delivering' => true],
//             'success' => ['od_is_success' => true],
//         ];
//         $orderNotification= config("constants.Order-notification-title");
//         $order = Order::find($oid);
//         if (array_key_exists($lastSegment, $updates)) {
//             $order->update($updates[$lastSegment]);
//             Notification::create([
//                 'n_user_id' => $order->od_user_id,
//                 "n_title" => $orderNotification[$lastSegment],
//                 "n_subtitle" =>$formattedDate,
//                 "n_image" => "https://imaxmobile.vn/media/data/icon-giao-hang-toan-quoc.jpeg",
//                 "n_link" => "/"
//             ]);
//         }
//         return Response::json(['code' => 200, 'message' => 'true']);
        
//     } catch (\Exception $e) {
//         // Ghi log lỗi
//         Log::error($e->getMessage());
//         // Trả về phản hồi lỗi
//         return Response::json(['code' => 500, 'message' => 'failed']);
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