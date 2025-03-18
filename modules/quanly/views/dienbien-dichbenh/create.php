<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\DienbienDichbenh */

?>
<div class="dienbien-dichbenh-create">
    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories
    ]) ?>
</div>
