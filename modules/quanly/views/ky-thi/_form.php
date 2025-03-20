<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\date\DatePicker;
use yii\widgets\MaskedInput;

?>

<div class="ky-thi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lophoc_id')->widget(Select2::className(), [
                                'data' => ArrayHelper::map($lophoc, 'id', 'text'),
                                'options' =>['prompt' => 'Chọn lớp học'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'), 
                                ],
    ])->label('Lớp học') ?>

    <?= $form->field($model, 'ngay_thi')->widget(DatePicker::classname(), [
                    'options' => [
                        'placeholder' => 'Ngày thi',
                        'class' => 'date-ngaycap',
                        //'onchange' => 'dateNgaycapCheck()',
                        'format' => "dd/mm/yyyy",
                        'value' => ($model->ngay_thi != null) ? $model->ngay_thi  : '',
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd/mm/yyyy',
                        'endDate' => "0d"
                    ]
        ])->label('Ngày thi');
    ?>

    <?= $form->field($model, 'sochungnhan')->textInput() ?>

    <?= $form->field($model, 'sophoibang')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
