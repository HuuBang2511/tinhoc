<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<div class="thong-tin-benh-form">

    <?php $form = ActiveForm::begin(); ?>

    <h4>Xóa thông tin bệnh <?= $model->ten ?></h4>

    <?php ActiveForm::end(); ?>

</div>

