<?php

namespace app\modules;


use app\widgets\maps\layers\TileLayer;

class APPConfig
{
    public static $SITENAME = 'Quản lý nông hộ';
    public static $CONFIG = [
        'adminSidebar' => [
            [
                'name' => 'Trang chủ',
                'icon' => 'fa fa-home',
                'url' => './',
                'hasChild' => false,
            ],
            [
                'name' => 'Bản đồ',
                'icon' => 'fa fa-map',
                'url' => 'map/',
                'hasChild' => false,
            ],
        ],

        'quanly' => [

            [
                'name' => 'Nông hộ',
                'icon' => 'fa fa-list',
                'hasChild' => false,
                'url' => 'quanly/nong-ho',
            ],
            [
                'name' => 'Cửa hàng thuốc BVTV',
                'icon' => 'fa fa-store',
                'hasChild' => false,
                'url' => 'quanly/cuahang-thuocbaove',
            ],
            [
                'name' => 'Địa giới hành chính',
                'icon' => 'fa fa-square',
                'hasChild' => false,
                'url' => 'quanly/diagioi-hanhchinh',
                
            ],
            [
                'name' => 'Vùng trồng cây canh tác',
                'icon' => 'fa fa-square',
                'hasChild' => false,
                'url' => 'quanly/caytrong-canhtac',
                
            ],
            [
                'name' => 'Tìm cửa hàng theo loại thuốc',
                'icon' => 'fa fa-map',
                'hasChild' => false,
                'url' => 'quanly/nong-ho/find-map',
                
            ],
        ],

        'danhmuc' => [

            [
                'name' => 'Loại cây trồng',
                'icon' => 'fa fa-list',
                'hasChild' => false,
                'url' => 'quanly/loai-cay-trong',
            ],
            [
                'name' => 'Thuốc bảo vệ',
                'icon' => 'fa fa-list',
                'hasChild' => false,
                'url' => 'danhmuc/thuoc-baove',
            ],
            [
                'name' => 'Thông tin bệnh',
                'icon' => 'fa fa-list',
                'hasChild' => false,
                'url' => 'quanly/thong-tin-benh',
                
            ],
        ],
    ];

    public static function getUrl($url)
    {
        return \Yii::$app->homeUrl . self::$ROOT_URL . $url;
    }
}