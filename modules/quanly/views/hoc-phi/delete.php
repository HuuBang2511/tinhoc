<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<div class="hoc-phi-form">

    <?php $form = ActiveForm::begin(); ?>

    <h4>Xóa thông tin học phí</h4>
    <?= Html::submitButton('Xóa', ['class' => 'btn btn-danger']) ?>

    <?php ActiveForm::end(); ?>

</div>

