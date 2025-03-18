<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

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
        'attribute'=>'ten_vung',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'dien_tich',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'diagioihanhchinh_id',
        'format' => 'raw',
        'value' => 'diagioihanhchinh.ten',
        'filter' => ArrayHelper::map($categories['diagioi_hanhchinh'], 'id', 'ten'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => 'Chọn tên địa giới hành chính'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ],
        'width' => '30%',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'loaicaytrong_id',
        'format' => 'raw',
        'value' => 'loaicaytrong.ten',
        'filter' => ArrayHelper::map($categories['loaicaytrong'], 'id', 'ten'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => 'Chọn loại cây trồng'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ],
        'width' => '30%',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'status',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'geom',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'geom_text',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'diagioihanhchinh_id',
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
                return Html::a('<span class="fa fa-info"></span>',$url,['class' => 'btn btn-info btn-sm','title'=>'Xem']);
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