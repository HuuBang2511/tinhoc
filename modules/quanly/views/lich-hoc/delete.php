<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<div class="lichhoc-form">

    <?php $form = ActiveForm::begin(); ?>

    <h4>Xóa thông tin lịch phí</h4>
    <?= Html::submitButton('Xóa', ['class' => 'btn btn-danger']) ?>

    <?php ActiveForm::end(); ?>

</div>

