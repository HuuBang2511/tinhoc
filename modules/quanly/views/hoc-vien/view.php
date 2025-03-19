<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\HocVien */
?>
<div class="hoc-vien-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ma',
            'ho_ten',
            'so_dien_thoai',
            'gmail',
            'gioitinh_id',
            'ngay_sinh',
            'cccd',            
            'baoluuketqua:boolean',
        ],
    ]) ?>

</div>
