<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\GiaoVien */

?>
<div class="giao-vien-create">
    <?= $this->render('_form', [
        'model' => $model,
        'gioitinh' => $gioitinh,
    ]) ?>
</div>
