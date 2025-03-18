<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\CaytrongCanhtac */

?>
<div class="caytrong-canhtac-create">
    <?= $this->render('_form', [
        'model' => $model,
        'diagioihanhchinh' => $diagioihanhchinh,
        'categories' => $categories,
    ]) ?>
</div>
