<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\product;
use App\Models\statistical;
use App\Models\visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemControllers extends Controller
{
    public function showDashboard(Request $request)
    {
        // function helper xử lý ngày
        $fromDate=handleFilterByDate($request)["fromDate"];
        $toDate=handleFilterByDate($request)["toDate"];
        $dateFilter=handleFilterByDate($request)["dateFilter"];
        // Query the orders within the date range
        $orders = Order::whereBetween('created_at', [$fromDate, $toDate])
                       ->where('od_is_canceled', false)
                       ->get(['id', 'od_price_total', 'od_user_id']);
        // Calculate necessary metrics
        $orderCount = $orders->count();
        $totalRevenue = $orders->sum('od_price_total');
        $customerCount = $orders->unique('od_user_id')->count();
        $visitorCount = Visitor::whereBetween('created_at', [$fromDate, $toDate])->count();
        // lượt xem sản phẩm
        $topViewProducts= Product::where('product_isPublished', true)
        ->orderBy('product_views', 'desc')
        ->limit(5)
        ->get();
        $topSoldProducts = OrderItem::select('od_item_product_id', DB::raw('SUM(od_item_quantity) as quantity_sold'))
        ->with('Product') // Eager load the product relationship
        ->join('orders', 'orders.id', '=', 'order_items.od_item_order_id')
        ->whereBetween('orders.created_at', [$fromDate, $toDate])
        ->where('orders.od_is_canceled',false)
        ->groupBy('od_item_product_id')
        ->orderByDesc('quantity_sold')
        ->take(5)
        ->get();
        return view('admin.dashboard.index', compact('orderCount', 'totalRevenue', 'customerCount',
                                                 'visitorCount', 'fromDate', 'toDate', 'dateFilter','topViewProducts',
                                                'topSoldProducts'));
    }
    public function chart_filter_by_date(Request $request)
    {
        // Function helper handle filter dates and parse them
        $filter = handleFilterByDate($request);
        $fromDate = Carbon::parse($filter['fromDate'])->format('Y-m-d');
        $toDate = Carbon::parse($filter['toDate'])->format('Y-m-d');
        // Get data from database
        $statistical = Statistical::whereBetween('order_date', [$fromDate, $toDate])
            ->get(['sales', 'profit', 'quantity', 'total_order', 'order_date']);
        // Convert data to the desired format
        $chart_data = $statistical->map(function ($item) {
            return [
                'order_date' => $item->order_date,
                'sales' => $item->sales,
                'profit' => $item->profit,
                'quantity' => $item->quantity,
                'total_order' => $item->total_order,
            ];
        })->toArray();
        // Return data as JSON
        return response()->json($chart_data);
    }
    }
    