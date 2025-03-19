<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\Lichhoc */
?>
<div class="lichhoc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'lophoc_id',
            'giaovien_id',
            'giobatdau',
            'gioketthuc',
            'thutrongtuan',
            'status',
            'phonghoc_id',
        ],
    ]) ?>

</div>
