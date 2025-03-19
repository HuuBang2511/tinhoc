<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<div class="hoc-vien-form">

    <?php $form = ActiveForm::begin(); ?>

    <h4>Xóa học viên: <?= $model->ho_ten ?></h4>
    <?= Html::submitButton('Xóa', ['class' => 'btn btn-danger']) ?>

    <?php ActiveForm::end(); ?>

</div>

