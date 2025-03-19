<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\KhoaHoc */
?>
<div class="khoa-hoc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ma',
            'ten',
            'hocphi',
            'thoigian_khoahoc',
            //'trinhdo_id',
            [
                'label' => 'Trình độ',
                'value' => function($model){
                    return ($model->trinhdo_id != null) ? $model->trinhdo->ten : '';
                }
            ],
        ],
    ]) ?>

</div>
