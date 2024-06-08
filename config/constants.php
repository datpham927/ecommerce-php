<?php

return [
    'statusFilters' => [
        'order' => null,
        'confirm' => ['od_is_canceled' => false, 'od_is_confirm' => false],
        'confirm-delivery' => ['od_is_canceled' => false, 'od_is_confirm' => true, 'od_is_confirm_delivery' => false],
        'delivered' => ['od_is_canceled' => false, 'od_is_confirm' => true, 'od_is_confirm_delivery' => true, 'od_is_delivering' => false],
        'success' => ['od_is_canceled' => false, 'od_is_confirm' => true, 'od_is_confirm_delivery' => true, 'od_is_delivering' => true, 'od_is_success' => true],
        'canceled' => ['od_is_canceled' => true],
    ],
    'Order-notification-title'=>[
        'confirm' => "Đơn hàng của bạn đã được xác nhận!",
        'confirm-delivery' => "Đơn hàng của bạn đã được xác nhận để vận chuyển!",
        'delivering' => "Đơn hàng của bạn đang được vận chuyển",
        'success' => ['od_is_success' => true],
    ]
];