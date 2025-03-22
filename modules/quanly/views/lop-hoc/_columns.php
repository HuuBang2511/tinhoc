<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use kartik\grid\GridView;

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
        'attribute'=>'ma',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'tinhtranglophoc_id',
    //     'value' => 'tinhtranglophoc.ten',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'tinhtranglophoc_id',
        'format' => 'raw',
        'value' => 'tinhtranglophoc.ten',
        'filter' => ArrayHelper::map($tinhtranglophoc, 'id', 'ten'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => 'Chọn tình trạng'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ],
        //'width' => '30%',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'khoahoc_id',
        'value' => 'khoahoc.ten'
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'status',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngaybatdau',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngayketthuc',
    ],
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
                return Html::a('<span class="fa fa-info"></span>',$url,['class' => 'btn btn-info btn-sm','title'=>'Xem']);
            },
            'update' => function ($url, $model, $key) {
                return Html::a('<span class="fa fa-pen"></span>',$url,['class' => 'btn btn-warning btn-sm','role' => 'modal-remote','title'=>'Cập nhật']);
            },
            'delete' => function ($url, $model, $key) {
                return Html::a('<span class="fa fa-trash"></span>',$url,['class' => 'btn btn-danger btn-sm','role' => 'modal-remote','title'=>'Xóa']);
            },
        ],
    ],

];   