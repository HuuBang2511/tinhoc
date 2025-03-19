<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\HocVien */
?>
<div class="hoc-vien-update">

    <?= $this->render('_form', [
        'model' => $model,
        'gioitinh' => $gioitinh,
        'trinhdo' => $trinhdo,
    ]) ?>

</div>
