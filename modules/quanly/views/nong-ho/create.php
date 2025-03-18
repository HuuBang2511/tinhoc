<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\NongHo */

?>
<div class="nong-ho-create">
    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
        'upload' => $upload,
    ]) ?>
</div>
