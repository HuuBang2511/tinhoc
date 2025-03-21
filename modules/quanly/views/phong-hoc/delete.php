<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<div class="phong-hoc-form">

    <?php $form = ActiveForm::begin(); ?>

    <h4>Xóa thông tin phòng học</h4>
    <?= Html::submitButton('Xóa', ['class' => 'btn btn-danger']) ?>

    <?php ActiveForm::end(); ?>

</div>

