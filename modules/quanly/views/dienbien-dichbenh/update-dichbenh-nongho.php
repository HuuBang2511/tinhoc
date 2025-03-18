<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\DienbienDichbenh */
?>
<div class="dienbien-dichbenh-update">

    <?= $this->render('_form-dichbenh-nongho', [
        'model' => $model,
        'categories' => $categories
    ]) ?>

</div>
