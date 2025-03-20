<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\HocPhi */

?>
<div class="hoc-phi-create">
    <?= $this->render('_form', [
        'model' => $model,
        'hocvien' => $hocvien,
        'lophoc' => $lophoc,
    ]) ?>
</div>
