<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\KhoaHoc */

?>
<div class="khoa-hoc-create">
    <?= $this->render('_form', [
        'model' => $model,
        'trinhdo' => $trinhdo,
    ]) ?>
</div>
