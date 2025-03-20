<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\Lichhoc */
?>
<div class="lichhoc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'lophoc.ma',
            'giaovien.ho_ten',
            'giobatdau',
            'gioketthuc',
            'thutrongtuan',
            //'status',
            'phonghoc.ten',
        ],
    ]) ?>

</div>
