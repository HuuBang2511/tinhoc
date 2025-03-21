<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\ThuChi */
?>
<div class="thu-chi-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sotien',
            'tinhtrangtien',
            'thongtin:ntext',
            'status',
        ],
    ]) ?>

</div>
