<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\KyThi */

?>
<div class="ky-thi-create">
    <?= $this->render('_form', [
        'model' => $model,
        'lophoc' => $lophoc,
    ]) ?>
</div>
