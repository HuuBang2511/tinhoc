<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\widgets\maps\LeafletMapAsset;
use app\widgets\maps\LeafletDrawAsset;
use app\widgets\maps\plugins\leaflet_measure\LeafletMeasureAsset;
use yii\widgets\MaskedInput;
/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\Lo */
/* @var $form yii\widgets\ActiveForm */
LeafletMapAsset::register($this);
LeafletDrawAsset::register($this);
LeafletMeasureAsset::register($this);


$requestedAction = Yii::$app->requestedAction;
$controller = $requestedAction->controller;
$const['label'] = $controller->const['label'];

$this->title = Yii::t('app', $const['label'][$requestedAction->id] . ' ' . $controller->const['title']);
$this->params['breadcrumbs'][] = ['label' => $const['label']['index'] . ' ' . $controller->const['title'], 'url' => $controller->const['url']['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? $const['label']['create'] . ' ' . $controller->const['title'] : $const['label']['update'] . ' ' . $controller->const['title'];
?>

<script src="<?= Yii::$app->homeUrl?>resources/core/js/jquery.inputmask.bundle.js" type="text/javascript"></script>
<div class="block block-themed">
    <div class="block-header">
        <h3 class="block-title">
            <?= $model->isNewRecord ? $const['label']['create'] . ' ' . $controller->const['title'] : $const['label']['update'] . ' ' . $controller->const['title']; ?>
        </h3>
    </div>

    <div class="block-content">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form']) ?>
        <div class="row">
            <div class="col-lg-3">
                <?= $form->field($model, 'dientich_nhiembenh')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-9">
                <?= $form->field($model, 'thongtinbenh_id')->widget(Select2::className(), [
                        'data' => ArrayHelper::map($categories['thongtinbenh'], 'id', 'ten'),
                        'options' => ['prompt' => 'Chọn thông tin bệnh'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                ]) ?>
            </div>
            <div class="col-lg-12">
                <?= $form->field($model, 'nongho_id')->widget(Select2::className(), [
                        'data' => ArrayHelper::map($categories['nongho'], 'id', 'ma_nong_ho'),
                        'options' => ['prompt' => 'Chọn mã nông hộ'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                ]) ?>
            </div>
            <div class="col-lg-12">
                <?= $form->field($model, 'thoi_diem')->textarea(['rows' => 2]) ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12 pb-3">
                <?= Html::submitButton('Lưu', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

