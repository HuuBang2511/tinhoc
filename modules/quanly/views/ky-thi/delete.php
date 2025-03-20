<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<div class="ky-thi-form">

    <?php $form = ActiveForm::begin(); ?>

    <h4>Xóa thông tin kỳ thi</h4>
    <?= Html::submitButton('Xóa', ['class' => 'btn btn-danger']) ?>

    <?php ActiveForm::end(); ?>

</div>

