<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<div class="khoa-hoc-form">

    <?php $form = ActiveForm::begin(); ?>

    <h4>Xóa khóa học <?= $model->ten ?></h4>
    <?= Html::submitButton('Xóa', ['class' => 'btn btn-danger']) ?>

    <?php ActiveForm::end(); ?>

</div>

