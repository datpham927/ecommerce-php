<?php

namespace App\Repository\Repositories;
use App\Models\Order;
use App\Repository\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\Config;

class OrderRepository implements OrderRepositoryInterface
{
    protected $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    public function getAllWithPaginate($limit)
    {
        return $this->order->latest()->paginate($limit);
    }
    public function getAll()
    {
        return $this->order->all();
    }
    public function create( $data)
    {
        return $this->order->create($data);
    }
    public function findByIdAndUpdate($id,  $data, $options = [])
    {
        $Order = $this->order->findOrFail($id);
        $Order->update($data);
        return $Order;
    }
    public function findById($id, $options = null)
    {
        return  $this->order->findOrFail($id);

    }
    public function findByIdAndDelete($id)
    {
        $Order = $this->order->findOrFail($id);
        $Order->delete();
        return $Order;
    }
    public function findByCodeAndStatus($code, $status ,$date)
    {
        $query = Order::where('id', $code) ->where($status);
        if (!empty($date)) {
            $formattedDate = date('Y-m-d', strtotime($date));
            $query->whereDate('created_at', $formattedDate);
        }
        return $query->get(); 
    }
    public function filterByStatusAndDate($status, $date = null,$limit)
    {
        $query = Order::orderBy('created_at', 'DESC')
                      ->where($status);
        if ($date) {
            $formattedDate = date('Y-m-d', strtotime($date));
            $query->whereDate('created_at', $formattedDate);
        }
        return $query->paginate($limit);
    }

    public function findOrdersByUserIdAndStatus($userId, $statusKey)
    {
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

        if (!array_key_exists($statusKey, $statusFilters)) {
            abort(404, 'Status not found');
        }

        return Order::where('od_user_id', $userId)
                    ->where($statusFilters[$statusKey])
                    ->orderBy('created_at', 'DESC')
                    ->get();
    }

    public function calculateProfitAndQuantity($order)
    {
        $profit = $order->OrderItem->sum(function($orderItem) {
            return $orderItem->Product->product_origin_price * $orderItem->od_item_quantity;
        });
        $quantity = $order->OrderItem->sum(function($orderItem) {
            return $orderItem->od_item_quantity;
        });
        return ['profit' => $profit, 'quantity' => $quantity];
    }
}
