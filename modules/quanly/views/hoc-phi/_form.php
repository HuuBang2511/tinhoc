<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\date\DatePicker;
use yii\widgets\MaskedInput;

?>

<div class="hoc-phi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hocvien_id')->widget(Select2::className(), [
                                'data' => ArrayHelper::map($hocvien, 'id', 'text'),
                                'options' =>['prompt' => 'Chọn học viên'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'), 
                                ],
    ])->label('Học viên') ?>

    <?= $form->field($model, 'lophoc_id')->widget(Select2::className(), [
                                'data' => ArrayHelper::map($lophoc, 'id', 'text'),
                                'options' =>['prompt' => 'Chọn lớp học'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'), 
                                ],
    ])->label('Lớp học') ?>

    <?= $form->field($model, 'sotien')->widget(MaskedInput::className(), [
        'options' => [
            'class' => 'form-control'
        ],
        'clientOptions' => [
            'alias' => 'decimal',
            'groupSeparator' => '.',
            'radixPoint' => ',',
            'autoGroup' => true,
            'removeMaskOnSubmit' => true
        ],
    ])->label('Học phí') ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
