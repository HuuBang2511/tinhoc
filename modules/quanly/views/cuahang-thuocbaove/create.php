<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\CuahangThuocbaove */

?>
<div class="cuahang-thuocbaove-create">
    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
        'upload' => $upload,
    ]) ?>
</div>
