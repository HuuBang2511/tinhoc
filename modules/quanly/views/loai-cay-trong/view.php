<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\LoaiCayTrong */
?>
<div class="loai-cay-trong-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'ten',
            'ghi_chu:ntext',
            //'status',
        ],
    ]) ?>

</div>
