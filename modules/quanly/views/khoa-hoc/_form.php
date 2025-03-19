<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>

<div class="khoa-hoc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ma')->textInput() ?>

    <?= $form->field($model, 'ten')->textInput() ?>

    

    <?= $form->field($model, 'hocphi')->widget(MaskedInput::className(), [
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

    <?= $form->field($model, 'thoigian_khoahoc')->textInput() ?>

    <?= $form->field($model, 'trinhdo_id')->widget(Select2::className(), [
                                'data' => ArrayHelper::map($trinhdo, 'id', 'ten'),
                                'options' =>['prompt' => 'Chọn tình trình độ'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                    ])->label('Trình độ') ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
