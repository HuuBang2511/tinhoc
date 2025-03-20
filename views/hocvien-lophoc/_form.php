<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<div class="hocvien-lophoc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hocvien_id')->textInput() ?>

    <?= $form->field($model, 'lophoc_id')->textInput() ?>

    <?= $form->field($model, 'tinhtranghocphi_id')->textInput() ?>

    <?= $form->field($model, 'tinhtranghoanthanh_id')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
