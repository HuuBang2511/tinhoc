<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\HocvienLophoc */
?>
<div class="hocvien-lophoc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'hocvien_id',
            'lophoc_id',
            'status',
            'tinhtranghocphi_id',
            'tinhtranghoanthanh_id',
        ],
    ]) ?>

</div>
