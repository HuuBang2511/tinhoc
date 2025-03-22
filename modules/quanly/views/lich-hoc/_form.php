<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\file\FileInput;
use kartik\editors\Summernote;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\TinTuc */
/* @var $form yii\widgets\ActiveForm */

$requestedAction = Yii::$app->requestedAction;
$controller = $requestedAction->controller;
$const['label'] = $controller->const['label'];

$this->title = Yii::t('app', $const['label'][$requestedAction->id] . ' ' . $controller->const['title']);
$this->params['breadcrumbs'][] = ['label' => $const['label']['index'] . ' ' . $controller->const['title'], 'url' => $controller->const['url']['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? $const['label']['create'] . ' ' . $controller->const['title'] : $const['label']['update'] . ' ' . $controller->const['title'];

?>

<div class="tin-tuc-form">
    <div class="block block-themed">
        <div class="block-header">
            <h3 class="block-title"><?= ($model->isNewRecord) ? 'Thêm mới lịch học' : 'Cập nhập lịch học' ?></h3>
        </div>
        <div class="block-content">
            <?php $form= ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model, 'giaovien_id')->widget(Select2::className(), [
                        'data' => ArrayHelper::map($giaovien, 'id', 'ho_ten'),
                        'options' =>['prompt' => 'Chọn giáo viên'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Giáo viên') ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'lophoc_id')->widget(Select2::className(), [
                        'data' => ArrayHelper::map($lophoc, 'id', 'ma'),
                        'options' =>['prompt' => 'Chọn lớp học'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Lớp học') ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'phonghoc_id')->widget(Select2::className(), [
                        'data' => ArrayHelper::map($phonghoc, 'id', 'ten'),
                        'options' =>['prompt' => 'Chọn phòng học'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label('Phòng học') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model, 'thutrongtuan')->widget(Select2::className(), [
                        'data' => $thu,
                        'options' =>['prompt' => 'Chọn thứ'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Thứ') ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'giobatdau')->widget(Select2::className(), [
                        'data' => $gio,
                        'options' =>['prompt' => 'Giờ bắt đầu', 'id' => 'giobatdau'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Giờ bắt đầu') ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'gioketthuc')->widget(Select2::className(), [
                        'data' => $gio,
                        'options' =>['prompt' => 'Giờ kết thúc', 'id' => 'gioketthuc'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Giờ kết thúc') ?>
                </div>
            </div>

            <div class="row ">
                <div class="col-lg-12">
                    <?= Html::submitButton('Lưu', ['class' => 'btn btn-primary float-end']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>