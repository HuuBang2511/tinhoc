<?php

use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use app\modules\commons\models\DmPhuongxa;

$requestedAction = Yii::$app->requestedAction;
$action = $requestedAction->id;

?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<style>
    .ui-slider-range { background: #007bff; };
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="block block-themed">
            <div class="block-header">
                <h5 class="m-0">
                    <i class="fa fa-search light"></i> Tìm kiếm
                </h5>
            </div>
            <div class="block-content">
                <?php
                    $form = ActiveForm::begin([
                        'action' => [$action],
                        'method' => 'get',
                    ]);
                ?>
                
                <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($searchModel, 'giaovien_id')->widget(Select2::className(), [
                        'data' => ArrayHelper::map($giaovien, 'id', 'ho_ten'),
                        'options' =>['prompt' => 'Chọn giáo viên'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Giáo viên') ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($searchModel, 'lophoc_id')->widget(Select2::className(), [
                        'data' => ArrayHelper::map($lophoc, 'id', 'ma'),
                        'options' =>['prompt' => 'Chọn lớp học'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Lớp học') ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($searchModel, 'phonghoc_id')->widget(Select2::className(), [
                        'data' => ArrayHelper::map($phonghoc, 'id', 'ten'),
                        'options' =>['prompt' => 'Chọn phòng học'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Phòng học') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($searchModel, 'thutrongtuan')->widget(Select2::className(), [
                        'data' => $thu,
                        'options' =>['prompt' => 'Chọn thứ'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Thứ') ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($searchModel, 'giobatdau')->widget(Select2::className(), [
                        'data' => $gio,
                        'options' =>['prompt' => 'Giờ bắt đầu'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Giờ bắt đầu') ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($searchModel, 'gioketthuc')->widget(Select2::className(), [
                        'data' => $gio,
                        'options' =>['prompt' => 'Giờ kết thúc'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Giờ kết thúc') ?>
                </div>
            </div>



                <div class="row">
                    <div class="col-lg-12 pb-3">
                        <?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary float-end']) ?>
                    </div>
                </div>

                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>