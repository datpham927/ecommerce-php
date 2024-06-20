<?php
namespace App\Classes;
class SettingConfig {
    public function config() {
        $data['homepage'] = [
            'label' => 'Thông tin chung',
            'description' => 'Cài đặt đầy đủ thông tin chung của website. Tên thương hiệu website, Logo, Favicon, v.v...',
            'value' => [
                'company' => ['type' => 'text', 'label' => 'Tên công ty','key'=>'setting_company_name'],
                'slogan' => ['type' => 'text', 'label' => 'Slogan','key'=>'setting_slogan'],
                'logo' => ['type' => 'image', 'label' => 'Logo Website', 'title' => 'Click vào phía dưới để tải logo','key'=>'setting_logo'],
            ]
        ];

        $data['contact'] = [
            'label' => 'Thông tin liên hệ',
            'description' => 'Cài đặt thông tin liên hệ của website ví dụ: Địa chỉ công ty, Hotline, Bản đồ, v.v...',
            'value' => [
                'office' => ['type' => 'text', 'label' => 'Địa chỉ công ty','key'=>'setting_address'],
                'hotline' => ['type' => 'text', 'label' => 'Hotline','key'=>'setting_phone'],
                'email' => ['type' => 'text', 'label' => 'Email','key'=>'setting_email'],
                'map' => [
                    'type' => 'text',
                    'label' => 'Bản đồ',
                     'key'=>'setting_map',
                    'link' => [
                        'text' => 'Hướng dẫn thiết lập bản đồ',
                        'href' => 'https://google.com/',
                        'target' => '_blank'
                    ],
                ],
            ]
        ];

        return $data;
    }
}