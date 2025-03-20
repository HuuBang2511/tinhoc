<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\HocPhi */
?>
<div class="hoc-phi-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'hocvien.ho_ten',
            'lophoc.ma',
            'sotien',
            //'status',
        ],
    ]) ?>

</div>
