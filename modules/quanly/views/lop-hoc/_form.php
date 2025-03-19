<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\date\DatePicker;

?>

<div class="lop-hoc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ma')->textInput() ?>

    <?= $form->field($model, 'tinhtranglophoc_id')->widget(Select2::className(), [
                                'data' => ArrayHelper::map($tinhtranglophoc, 'id', 'ten'),
                                'options' =>['prompt' => 'Chọn tình trạng lớp học'],
                                'pluginOptions' => [
                                    'allowClear' => true
        ],
    ])->label('Giới tính') ?>

    <?= $form->field($model, 'khoahoc_id')->widget(Select2::className(), [
                                'data' => ArrayHelper::map($khoahoc, 'id', 'ten'),
                                'options' =>['prompt' => 'Chọn khóa học'],
                                'pluginOptions' => [
                                    'allowClear' => true
        ],
    ])->label('Khóa học') ?>


    <?= $form->field($model, 'ngaybatdau')->widget(DatePicker::classname(), [
                    'options' => [
                        'placeholder' => 'Ngày bắt đầu khóa học',
                        'class' => 'date-ngaycap',
                        //'onchange' => 'dateNgaycapCheck()',
                        'format' => "dd/mm/yyyy",
                        'value' => ($model->ngaybatdau != null) ? date('d/m/Y', strtotime($model->ngaybatdau)) : '',
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd/mm/yyyy',
                        //'endDate' => "0d"
                    ]
        ])->label('Ngày bắt đầu khóa học');
    ?>

    <?= $form->field($model, 'ngayketthuc')->widget(DatePicker::classname(), [
                    'options' => [
                        'placeholder' => 'Ngày kết thúc khóa học',
                        'class' => 'date-ngaycap',
                        //'onchange' => 'dateNgaycapCheck()',
                        'format' => "dd/mm/yyyy",
                        'value' => ($model->ngayketthuc != null) ? date('d/m/Y', strtotime($model->ngayketthuc)) : '',
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd/mm/yyyy',
                        //'endDate' => "0d"
                    ]
        ])->label('Ngày kết thúc khóa học');
    ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
