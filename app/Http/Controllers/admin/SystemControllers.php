<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\statistical;
use App\Models\visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SystemControllers extends Controller
{
    public function showDashboard(Request $request)
    {
        // Get today's date
       
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
        // Return the view with the necessary data
        return view('admin.dashboard', compact('orderCount', 'totalRevenue', 'customerCount',
                                                 'visitorCount', 'fromDate', 'toDate', 'dateFilter'));
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
    