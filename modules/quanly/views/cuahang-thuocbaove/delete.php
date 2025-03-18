<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<div class="cuahang-thuocbaove-form">

    <?php $form = ActiveForm::begin(); ?>

    <h4>Xóa cửa hàng tên: <?= $model->ten_cua_hang ?></h4>

    <?php ActiveForm::end(); ?>

</div>

