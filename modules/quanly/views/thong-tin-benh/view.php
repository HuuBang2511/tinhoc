<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\ThongTinBenh */
?>
<div class="thong-tin-benh-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'ten',
            [
                'label' => 'Loại cây trồng',
                'value' => function ($model){
                    return ($model->loaicaytrong_id != null) ? $model->loaicaytrong->ten : '';
                }
            ],
            'thongtin_benh:ntext',
            [
                'label' => 'Thuốc bảo vệ',
                'value' => $thuocbaove,
            ],
        ],
    ]) ?>

</div>
