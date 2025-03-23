<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\date\DatePicker;
use yii\widgets\MaskedInput;

?>

<div class="thu-chi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tinhtrangtien')->widget(Select2::className(), [
                                'data' => [1 => 'Thu', 2 => 'Chi'],
                                'options' =>['prompt' => 'Chọn lớp học'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'), 
                                ],
    ])->label('Tình trạng tiền') ?>

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
    ])->label('Số tiền') ?>

    <?= $form->field($model, 'ngay')->widget(DatePicker::classname(), [
                    'options' => [
                        'placeholder' => 'Ngày thu chi',
                        'class' => 'date-ngaycap',
                        //'onchange' => 'dateNgaycapCheck()',
                        'format' => "dd/mm/yyyy",
                        'value' => ($model->ngay != null) ? $model->ngay : '',
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd/mm/yyyy',
                        //'endDate' => "0d"
                    ]
        ])->label('Ngày thu chi');
    ?>

    <?= $form->field($model, 'thongtin')->textarea(['rows' => 6]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
