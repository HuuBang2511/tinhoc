<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\Lichhoc */
?>
<div class="lichhoc-update">

    <?= $this->render('_form', [
        'model' => $model,
        'phonghoc' => $phonghoc,
            'giaovien' => $giaovien,
            'lophoc' => $lophoc,
            'thu' => $thu,
            'gio' => $gio,
    ]) ?>

</div>
