<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<div class="lop-hoc-form">

    <?php $form = ActiveForm::begin(); ?>

    <h4>Xóa lớp học: <?= $model->ma ?></h4>
    <?= Html::submitButton('Xóa', ['class' => 'btn btn-danger']) ?>

    <?php ActiveForm::end(); ?>

</div>

