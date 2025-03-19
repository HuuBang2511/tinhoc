<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\GiaoVien */
?>
<div class="giao-vien-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ma',
            'ho_ten',
            'cccd',
            'so_dien_thoai',
            'gmail',
            'ngay_sinh',
            'trinh_do',
            'bang_cap',
            'sogio_tuan',
            'status',
            'gioitinh_id',
        ],
    ]) ?>

</div>
