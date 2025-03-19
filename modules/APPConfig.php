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
        ],

        'quanly' => [

            [
                'name' => 'Giáo viên',
                'icon' => 'fa fa-list',
                'hasChild' => false,
                'url' => 'quanly/giao-vien',
            ],
            [
                'name' => 'Học viên',
                'icon' => 'fa fa-list',
                'hasChild' => false,
                'url' => 'quanly/hoc-vien',
            ],
            [
                'name' => 'Khóa học',
                'icon' => 'fa fa-list',
                'hasChild' => false,
                'url' => 'quanly/khoa-hoc',
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