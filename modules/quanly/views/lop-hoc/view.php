<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\LopHoc */
?>
<div class="lop-hoc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ma',
            'tinhtranglophoc_id',
            'khoahoc_id',
            'status',
            'ngaybatdau',
            'ngayketthuc',
        ],
    ]) ?>

</div>
