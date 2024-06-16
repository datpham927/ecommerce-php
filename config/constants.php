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
    'Order-notification'=>[
        'is-confirm' =>[
            'message'=> "Đơn hàng của bạn đã được xác nhận!",
            'link'=>"/order/confirm-delivery"
        ],
        'is-confirm-delivery' => [
            'message'=> "Đơn hàng của bạn đã được xác nhận để vận chuyển!",
             'link'=>"/order/delivering"
        ],
        'is-delivering' =>[
            'message'=>  "Đơn hàng của bạn đang được vận chuyển",
             'link'=>"/order/delivering"
        ],
        'is-delivered' => [
            'message'=> "Đơn hàng của bạn đã được giao",
            'link'=>"/order/success"
        ],
    ]
];