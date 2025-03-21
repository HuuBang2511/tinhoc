<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<div class="phong-hoc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ten')->textInput() ?>

    <?= $form->field($model, 'ma')->textInput() ?>

	<?= $form->field($model, 'ghichu')->textarea(['rows' => 3]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
