<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\DienbienDichbenh */
?>
<div class="dienbien-dichbenh-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'label' => 'Loại cây trồng',
                'value' => function($model){
                    return ($model->caytrongcanhtac->loaicaytrong_id != null)? $model->caytrongcanhtac->loaicaytrong->ten : '';
                }
            ],
            [
                'label' => 'Thông tin bệnh',
                'value' => function($model){
                    return ($model->thongtinbenh_id != null)? $model->thongtinbenh->ten : '';
                }
            ],
            [
                'label' => 'Mã nông hộ',
                'value' => function($model){
                    return ($model->nongho_id != null)? $model->nongho->ma_nong_ho : '';
                }
            ],
            [
                'label' => 'Diện tích nhiễm bệnh',
                'value' => function($model){
                    return ($model->dientich_nhiembenh != null)? $model->dientich_nhiembenh.' m2' : '';
                }
            ],
            [
                'label' => 'Thời điểm',
                'value' => function($model){
                    return ($model->thoi_diem != null)? $model->thoi_diem : '';
                }
            ],
        ],
    ]) ?>

</div>
