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
            [
                'name' => 'Lịch học',
                'icon' => 'fa fa-list',
                'hasChild' => false,
                'url' => 'quanly/lich-hoc',
            ],
            [
                'name' => 'Lớp học',
                'icon' => 'fa fa-list',
                'hasChild' => false,
                'url' => 'quanly/lop-hoc',
            ],
            [
                'name' => 'Học phí',
                'icon' => 'fa fa-list',
                'hasChild' => false,
                'url' => 'quanly/hoc-phi',
            ],
            [
                'name' => 'Kỳ thi',
                'icon' => 'fa fa-list',
                'hasChild' => false,
                'url' => 'quanly/ky-thi',
            ],
            [
                'name' => 'Phòng học',
                'icon' => 'fa fa-list',
                'hasChild' => false,
                'url' => 'quanly/phong-hoc',
            ],
            [
                'name' => 'Thu chi',
                'icon' => 'fa fa-list',
                'hasChild' => false,
                'url' => 'quanly/thu-chi',
            ],
        ],
        'danhmuc' => [],
        
    ];

    public static function getUrl($url)
    {
        return \Yii::$app->homeUrl . self::$ROOT_URL . $url;
    }
}