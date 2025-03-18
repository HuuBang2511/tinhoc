<?php

use yii\helpers\Html;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\select2\Select2;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\examples\models\ExampleModel;
use yii\widgets\MaskedInput;
use app\widgets\maps\LeafletMapAsset;
use kartik\depdrop\DepDrop;

LeafletMapAsset::register($this);


/* @var $this yii\web\View */
/* @var $categories app\modules\quanly\models\DonViKinhTe */
/* @var $form yii\widgets\ActiveForm */

$requestedAction = Yii::$app->requestedAction;
$controller = $requestedAction->controller;
$const['label'] = $controller->const['label'];

$this->title = Yii::t('app', $const['label'][$requestedAction->id] . ' ' . $controller->const['title']);
$this->params['breadcrumbs'][] = ['label' => $const['label']['index'] . ' ' . $controller->const['title'], 'url' => $controller->const['url']['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? $const['label']['create'] . ' ' . $controller->const['title'] : $const['label']['update'] . ' ' . $controller->const['title'];

?>

<script src="<?= Yii::$app->homeUrl?>resources/core/js/jquery.inputmask.bundle.js" type="text/javascript"></script>

<?php 
   
?>

<style>
    .select2-container .select2-selection--multiple .select2-selection__rendered {
        display: flex;
        flex-direction: column;
    }


</style>


<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'errorOptions' => ['encode' => false],
    ],
]) ?>

<div class="block block-themed">
    <div class="block-header">
        <h3 class="block-title">
            <?= ($model->isNewRecord) ? 'Thêm mới thông tin bệnh' : 'Cập nhật thông tin bệnh' ?>
        </h3>
    </div>

    <div class="block-content">

        <h2 class="content-heading text-uppercase"></h2>

        <div class="row">
            <div class="col-lg-12">
                <?= $form->field($model, 'ten')->textInput(['maxlength' => true]) ?>
            </div>
        </div>    
        
        <div class="row">
            <div class="col-lg-12">
                <?= $form->field($model, 'thongtin_benh')->textarea(['rows' => 2]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'loaicaytrong_id')->widget(Select2::className(), [
                        'data' => ArrayHelper::map($categories['loaicaytrong'], 'id', 'ten'),
                        'options' => ['id' => 'loaicaytrong-id', 'prompt' => 'Chọn loại cây trồng'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'thuoc_bao_ve')->widget(Select2::className(), [
                        'data' => ArrayHelper::map($categories['thuocbaove'], 'id', 'ten'),
                        'options' => ['id' => 'thuocbaove', 'prompt' => 'Chọn thuốc bảo vệ', 'multiple' => true],
                        'pluginOptions' => [
                            //'allowClear' => true
                        ],
                ]) ?>
            </div>
        </div>

       

        <div class="row">
            <div class="col-lg-12 pb-3">
                <?= Html::submitButton('Lưu', ['class' => 'btn btn-primary', 'id' => 'submitButton']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

