<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<div class="nong-ho-form">

    <?php $form = ActiveForm::begin(); ?>

    <h3>Xóa nông hộ mã số: <?= $model->ma_nong_ho ?></h3>

    <?php ActiveForm::end(); ?>

</div>

