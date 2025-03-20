<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\date\DatePicker;

?>

<div class="diem-danh-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hocvien_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map($hocvien, 'id', 'text'),
        'options' =>['prompt' => 'Chọn học viên'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'), 
        ],
    ])->label('Học viên') ?>

    <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                    'options' => [
                        'placeholder' => 'Ngày nghỉ',
                        'format' => "dd/mm/yyyy",
                        'value' => ($model->date != null) ? $model->date : '',
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd/mm/yyyy',
                        //'endDate' => "0d"
                    ]
        ])->label('Ngày nghỉ');
    ?>

    <?= $form->field($model, 'lydonghi')->textInput() ?>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
