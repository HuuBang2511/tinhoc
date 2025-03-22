<?php
use yii\helpers\Url;
use yii\helpers\Html;

// $thu = [
//     1 => 'Chủ nhật',
//     2 => 'Thứ 2',
//     3 => 'Thứ 3',
//     4 => 'Thứ 4',
//     5 => 'Thứ 5',
//     6 => 'Thứ 6',
//     7 => 'Thứ 7',
// ];

// $gio = [
//     1 => '1:00',
//     2 => '2:00',
//     3 => '3:00',
//     4 => '4:00',
//     5 => '5:00',
//     6 => '6:00',
//     7 => '7:00',
//     8 => '8:00',
//     9 => '9:00',
//     10 => '10:00',
//     11 => '11:00',
//     12 => '12:00',
//     13 => '13:00',
//     14 => '14:00',
//     15 => '15:00',
//     16 => '16:00',
//     17 => '17:00',
//     18 => '18:00',
//     19 => '19:00',
//     20 => '20:00',
//     21 => '21:00',
//     22 => '22:00',
//     23 => '23:00',
//     24 => '24:00',
// ];

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'lophoc_id',
        'value' => 'lophoc.ma'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'giaovien_id',
        'value' => 'giaovien.ho_ten'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        //'attribute'=>'giaovien_id',
        'label' => 'Tình trạng lớp học',
        'value' => 'lophoc.tinhtranglophoc.ten'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'phonghoc_id',
        'value' => 'phonghoc.ten'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'giobatdau',
        'value' => function($model){
            return ($model->giobatdau != null) ? $model->giobatdau.':00' : '';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'gioketthuc',
        'value' => function($model){
            return ($model->gioketthuc != null) ? $model->gioketthuc.':00' : '';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'thutrongtuan',
        'value' => function($model){
            return ($model->thutrongtuan != null) ? (($model->thutrongtuan == 1) ? 'Chủ nhật' : 'Thứ '.$model->thutrongtuan) : '';
        }
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'status',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'phonghoc_id',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width' => '180px',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons' => [
            'view' => function ($url, $model, $key) {
                return Html::a('<span class="fa fa-info"></span>',$url,['class' => 'btn btn-info btn-sm','role' => 'modal-remote','title'=>'Xem']);
            },
            'update' => function ($url, $model, $key) {
                return Html::a('<span class="fa fa-pen"></span>',$url,['class' => 'btn btn-warning btn-sm','title'=>'Cập nhật']);
            },
            'delete' => function ($url, $model, $key) {
                return Html::a('<span class="fa fa-trash"></span>',$url,['class' => 'btn btn-danger btn-sm','role' => 'modal-remote','title'=>'Xóa']);
            },
        ],
    ],

];   