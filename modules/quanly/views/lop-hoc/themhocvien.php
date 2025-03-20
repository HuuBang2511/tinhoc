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

    <?= $form->field($model, 'hocvien_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map($hocvien, 'id', 'text'),
        'options' =>['prompt' => 'Chọn học viên'],
        'pluginOptions' => [
            'allowClear' => true,
            'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'), 
        ],
    ])->label('Học viên') ?>

    <?= $form->field($model, 'tinhtranghocphi_id')->widget(Select2::className(), [
                                'data' => ArrayHelper::map($tinhtranghocphi, 'id', 'ten'),
                                'options' =>['prompt' => 'Chọn tình trạng'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'), 
        ],
    ])->label('Tình trạng học phí') ?>

    <?= $form->field($model, 'tinhtranghoanthanh_id')->widget(Select2::className(), [
                                'data' => ArrayHelper::map($tinhtranghoanthanh, 'id', 'ten'),
                                'options' =>['prompt' => 'Chọn tình trạng'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'), 
        ],
    ])->label('Tình trạng hoàn thành') ?>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
