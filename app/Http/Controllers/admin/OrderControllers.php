<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\setting;
use App\Models\statistical;
use App\Repository\Interfaces\OrderRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use PDF;
use QrCode;
class OrderControllers extends Controller
{

    protected $orderRepository;
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

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
        $orders =$this->orderRepository
             ->findByCodeAndStatus($code,$statusFilters[$lastSegment],$date);
        return view('admin.order.index', compact('orders', 'active', 'code', 'date'));
    }
    //
    if (array_key_exists($lastSegment, $statusFilters)) {
            $active = $lastSegment;
            $orders = $this->orderRepository
            ->filterByStatusAndDate($statusFilters[$lastSegment], $date,5);
    } else {
        abort(404);
    }
    return view('admin.order.index', compact('orders', 'active'));
}

public function confirmOrderStatus(Request $request,$oid){
    try {
        $currentUrl = $request->url();
        $segmentBeforeLast = Str::beforeLast($currentUrl, '/');
        $lastSegment = Str::afterLast($segmentBeforeLast, '/');
        $order=$this->orderRepository->findById($oid);
        // Thêm định dạng ngày tháng năm
        $formattedDate = Carbon::now()->locale('vi')->isoFormat('dddd, DD/MM/YYYY');
        $updates=[
            'is-confirm' => ['od_is_confirm' => true],
            'is-confirm-delivery' => ['od_is_confirm_delivery' => true], 
            'is-delivered' => ['od_is_delivering' => true,'od_is_success' => true,'od_is_pay'=>true],
        ];
        $orderNotification= config("constants.Order-notification");
        if ($lastSegment === "is-confirm") {
            $today = Carbon::now()->toDateString();
            $profitAndQuantity=$this->orderRepository->calculateProfitAndQuantity($order);
         // thống kê
            $foundStatistical = statistical::firstOrNew(['order_date' => $today]);
            $foundStatistical->profit += $profitAndQuantity["profit"];
            $foundStatistical->sales += $order->od_price_total;
            $foundStatistical->total_order += 1;
            $foundStatistical->quantity+= $profitAndQuantity["quantity"] ;
            $foundStatistical->save();
        }
        if (array_key_exists($lastSegment, $updates)) {
            $order->update($updates[$lastSegment]);
              Notification::create([
                'n_user_id' => $order->od_user_id,
                "n_title" => $orderNotification[$lastSegment]['message'],
                "n_subtitle" =>$formattedDate,
                "n_image" => "https://imaxmobile.vn/media/data/icon-giao-hang-toan-quoc.jpeg",
                "n_link" => $orderNotification[$lastSegment]['link']
            ]);
            return Response::json(['code' => 200, 'message' => 'true']);
        }
        return Response::json(['code' => 202, 'message' => 'false']);
    } catch (\Exception $e) {
        // Ghi log lỗi
        Log::error($e->getMessage());
        // Trả về phản hồi lỗi
        return Response::json(['code' => 500, 'message' => $e->getMessage()]);
    }
}
public function getOrderItemByAdmin($oid){
        $order=$this->orderRepository->findById($oid);
        return view('admin.order.detail',compact('order'));
}

public function generatePDF($oid)
{
    try { 
        $setting = setting::first();
        $order = Order::with('OrderItem.product')->find($oid);
        if (!$order) {
            throw new \Exception("Order not found");
        }  
        $qrCode = QrCode::size(50)->generate($oid);
        return view('admin.invoicePDF', compact('order', 'setting','qrCode'));
        $pdf = PDF::loadView('admin.invoicePDF', compact('order', 'setting','qrCode'));
        return $pdf->download('MDH-'.$oid.'.pdf');
    } catch (\Throwable $th) {
        \Log::error($th);
        return response()->json(['error' => 'Failed to generate PDF. Please try again later.'], 500);
    }
}

}