<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<div class="caytrong-canhtac-form">

    <?php $form = ActiveForm::begin(); ?>

    <h3>Xóa vùng canh tác cây trồng: <?= $model->ten_vung ?></h3>

    <?php ActiveForm::end(); ?>

</div>

