<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\LopHoc */

?>
<div class="lop-hoc-create">
    <?= $this->render('_form', [
        'model' => $model,
        'tinhtranglophoc' => $tinhtranglophoc,
        'khoahoc' => $khoahoc,
    ]) ?>
</div>
