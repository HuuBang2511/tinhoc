<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\KyThi */
?>
<div class="ky-thi-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'lophoc.ma',
            'ngay_thi',
            //'status',
            'sochungnhan',
            'sophoibang',
        ],
    ]) ?>

</div>
