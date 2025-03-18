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
use kartik\file\FileInput;

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

<script src="<?= Yii::$app->homeUrl?>resources/core/js/leaflet.ajax.js"></script>

<?php 
   
?>


<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'errorOptions' => ['encode' => false],
    ],
]) ?>

<div class="block block-themed">
    <div class="block-header">
        <h3 class="block-title">
            <?= ($model->isNewRecord) ? 'Thêm mới thuốc bảo vệ' : 'Cập nhật thuốc bảo vệ' ?>
        </h3>
    </div>

    <div class="block-content">

        <h2 class="content-heading text-uppercase">Thuốc bảo vệ</h2>

        <div class="row">
            <div class="col-lg-12">
                <?= $form->field($model, 'ten')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

		<div class="row">
            <div class="col-lg-12">
                <?= $form->field($model, 'dang_thuoc')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

		<div class="row">
            <div class="col-lg-12">
                <?= $form->field($model, 'quytac_donggoi')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

		<div class="row">
            <div class="col-lg-12">
                <?= $form->field($model, 'thanh_phan')->textarea(['rows' => 3]) ?>
            </div>
        </div>

		<div class="row">
            <div class="col-lg-12">
                <?= $form->field($model, 'dac_tri')->textarea(['rows' => 3]) ?>
            </div>
        </div>


        <div class="row">
            <?php if($model->isNewRecord): ?>
            <div class="col-lg-12">
                <?= $form->field($upload, 'imageupload')->widget(FileInput::className(), [
                        'pluginOptions' => [
                            'initialPreviewAsData' => true,
                            'allowedFileExtensions' => ['png', 'jpeg', 'jpg'],
                            'showPreview' => true,
                            'showCaption' => true,
                            'showRemove' => true,
                            'showUpload' => false,
                        ]
                    ])->label('Hình ảnh');
                ?>
            </div>
            <?php else: ?>
            <?php if($model->url_hinhanh != null): ?>
            <div class="col-lg-12">
                <?= $form->field($upload, 'imageupload')->widget(FileInput::className(), [
                        'pluginOptions' => [
                            'overwriteInitial' => true,
                            'initialPreview' => [
                                Yii::$app->homeUrl.$model->url_hinhanh
                            ],
                            'initialPreviewAsData' => true,
                            'initialPreviewFileType' => 'pdf',
                            'allowedFileExtensions' => ['png', 'jpeg', 'jpg'],
                            'showPreview' => true,
                            'showCaption' => true,
                            'showRemove' => true,
                            'showUpload' => false,
                        ]
                    ])->label('Hình ảnh');
                ?>
            </div>
            <?php else: ?>
            <div class="col-lg-12">
                <?= $form->field($upload, 'imageupload')->widget(FileInput::className(), [
                        'pluginOptions' => [
                            'initialPreviewAsData' => true,
                            'allowedFileExtensions' => ['png', 'jpeg', 'jpg'],
                            'showPreview' => true,
                            'showCaption' => true,
                            'showRemove' => true,
                            'showUpload' => false,
                        ]
                    ])->label('Hình ảnh');
                ?>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>


        <div class="row">
            <div class="col-lg-12 pb-3">
                <?= Html::submitButton('Lưu', ['class' => 'btn btn-primary', 'id' => 'submitButton']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

