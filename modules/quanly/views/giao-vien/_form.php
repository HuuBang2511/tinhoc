<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\date\DatePicker;

?>

<div class="giao-vien-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ma')->textInput() ?>

    <?= $form->field($model, 'ho_ten')->textInput() ?>

    <?= $form->field($model, 'cccd')->textInput() ?>

    <?= $form->field($model, 'so_dien_thoai')->textInput() ?>

    <?= $form->field($model, 'gmail')->textInput() ?>

    <?= $form->field($model, 'gioitinh_id')->widget(Select2::className(), [
                                'data' => ArrayHelper::map($gioitinh, 'id', 'ten'),
                                'options' =>['prompt' => 'Chọn giới tính'],
                                'pluginOptions' => [
                                    'allowClear' => true
        ],
    ])->label('Giới tính') ?>

    <?= $form->field($model, 'ngay_sinh')->widget(DatePicker::classname(), [
                    'options' => [
                        'placeholder' => 'Ngày sinh',
                        'class' => 'date-ngaycap',
                        //'onchange' => 'dateNgaycapCheck()',
                        'format' => "dd/mm/yyyy",
                        'value' => ($model->ngay_sinh != null) ? date('d/m/Y', strtotime($model->ngay_sinh)) : '',
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd/mm/yyyy',
                        'endDate' => "0d"
                    ]
        ])->label('Ngày sinh');
    ?>

    <?= $form->field($model, 'trinh_do')->textInput() ?>

    <?= $form->field($model, 'bang_cap')->textInput() ?>

    <?= $form->field($model, 'sogio_tuan')->textInput() ?>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
