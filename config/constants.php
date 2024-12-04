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
    ],

'sidebars' => [
        [
            'label' => "Tổng quan",
            'router_name' => 'admin.dashboard',
            'can' => null
        ],
        [
            'label' => "Quản lý slider",
            'router_name' => 'slider.index',
            // 'can' => 'list_slider'
            'can' => null
        ],
        [
            'label' => "Danh mục sản phẩm",
            'router_name' => 'category.index',
            'can' => 'list_category'
        ],
        [
            'label' => "Thương hiệu sản phẩm",
            'router_name' => 'brand.index',
            'can' => 'list_brand'
        ],
        [
            'label' => "Phí vận chuyển",
            'router_name' => 'delivery.index',
            'can' => null,
        ],
        [
            'label' => "Quản lý sản phẩm",
            'router_name' => 'javascript:;',
            'can' => 'list_product',
            'sub_menu' => [
                [
                    'label' => "Thêm sản phẩm",
                    'router_name' => 'product.add',
                    'can' => 'add_product'
                ],
                [
                    'label' => "Danh sách sản phẩm",
                    'router_name' => 'product.index',
                    'can' => 'list_product'
                ],
                [
                    'label' => "Sản phẩm nháp",
                    'router_name' => 'product.draft',
                    'can' => 'list_product'
                ],
                [
                    'label' => "Sản phẩm đã xóa",
                    'router_name' => 'product.deleted',
                    'can' => 'list_product'
                ],
            ]
        ],
        [
            'label' => "Quản lý đơn hàng",
            'router_name' => 'admin.order.index',
            'can' => 'list_order'
        ],
        [
            'label' => "Quản lý người dùng",
            'router_name' => 'javascript:;',
            'can' => null,
            'sub_menu' => [
                [
                    'label' => "Quản lý nhân viên",
                    'router_name' => 'staff.index',
                    'can' => 'list_staff'
                ],
                [
                    'label' => "Quản lý khách hàng",
                    'router_name' => 'customer.index',
                    'can' => 'list_customer'
                ],
                [
                    'label' => "Quản lý vai trò",
                    'router_name' => 'role.index',
                    'can' => "list_staff"
                ],
                [
                    'label' => "Thêm permission",
                    'router_name' => 'permission.add',
                    'can' => "list_staff"
                ],
            ]
        ],
    ]
    ];