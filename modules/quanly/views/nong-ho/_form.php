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

<script src="<?= Yii::$app->homeUrl?>resources/core/js/jquery.inputmask.bundle.js" type="text/javascript"></script>
<script src="<?= Yii::$app->homeUrl?>resources/core/js/leaflet.ajax.js"></script>



<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'errorOptions' => ['encode' => false],
    ],
]) ?>

<div class="block block-themed">
    <div class="block-header">
        <h3 class="block-title">
            <?= ($model->isNewRecord) ? 'Thêm mới nông hộ' : 'Cập nhật nông hộ' ?>
        </h3>
    </div>

    <div class="block-content">

        <h2 class="content-heading text-uppercase">Nông hộ</h2>

        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'ma_nong_ho')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'chunongho_ten')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'so_nha')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'ten_duong')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3">
                <?= $form->field($model, 'phuongxa_id')->widget(DepDrop::classname(), [
                        'data' => $model->phuongxa_id != null ? ArrayHelper::map($categories['phuongxa'], 'id', 'ten') : [],
                        'pluginOptions' => [
                            'depends' => ['quanhuyen-id'],
                            'placeholder' => 'Chọn phường xã...',
                            'url' => Url::to(['/quanly/nong-ho/phuongxa'])
                        ]
                    ]); ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'quanhuyen_id')->widget(DepDrop::classname(), [
                        'data' => $model->quanhuyen_id != null ? ArrayHelper::map($categories['quanhuyen'], 'id', 'ten') : [],
                        'options' => ['id' => 'quanhuyen-id'],
                        'pluginOptions' => [
                            'depends' => ['tinhthanh-id'],
                            'placeholder' => 'Chọn quận huyện...',
                            'url' => Url::to(['/quanly/nong-ho/quanhuyen'])
                        ]
                    ]); ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'tinhthanh_id')->widget(Select2::className(), [
                        'data' => ArrayHelper::map($categories['tinhthanh'], 'id', 'ten'),
                        'options' => ['id' => 'tinhthanh-id', 'prompt' => 'Chọn tỉnh thành'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'geo_x')->input('text', ['id' => 'geox-input']) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'geo_y')->input('text', ['id' => 'geoy-input']) ?>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-12">
                <div id="map" style="height: 500px"></div>
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

<script>
    var map = L.map('map').setView([<?= ($model->geo_y != null) ? $model->geo_y : 9.60802790773281  ?>,
        <?= ($model->geo_x != null) ? $model->geo_x : 105.98158836364748 ?>
    ], 18);
    var icon = L.icon({
        iconUrl: 'https://auth.hcmgis.vn/uploads/icon/home-address-blue.png',
        iconSize: [40, 40],
        iconAnchor: [20, 20],
        popupAnchor: [0, -48],
    });
    var marker = new L.marker([<?= ($model->geo_y != null) ? $model->geo_y : 9.60802790773281  ?>,
        <?= ($model->geo_x != null) ? $model->geo_x : 105.98158836364748 ?>
    ], {
        'draggable': 'true',
        'icon': icon,
    });

    var googleMap =  L.tileLayer('http://{s}.google.com/vt/lyrs=' + 'r' + '&x={x}&y={y}&z={z}', {
        maxZoom: 24,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });

    var vetinh = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
        maxZoom: 24,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
    });

    var phuongxa = new L.geoJson.ajax(
    '<?= Yii::$app->homeUrl ?>' + 'map/default/ranh-xa',
        {
        onEachFeature: function(feature, layer) {
            layer.bindPopup(
                '<p>Tên phường xã: '+feature.properties.ten+'<br>Tên Quận huyện: '+feature.properties.ten_quan+'</p>'
            );
        }
        }
    );

    var baseLayers = {
        "ggMap": googleMap,
        'Vệ tinh': vetinh,
    };

    var overLayers = {
        'Ranh xã' : phuongxa,
    };


    

    L.control.layers(baseLayers, overLayers).addTo(map);
    map.addLayer(googleMap, true);
    var x = 10.7840441;
    var y = 106.6939804;

    marker.on('dragend', function (event) {
        var marker = event.target;
        var position = marker.getLatLng();
        marker.setLatLng(new L.LatLng(position.lat, position.lng), {
            draggable: 'true'
        });
        map.panTo(new L.LatLng(position.lat, position.lng))
        $('#geoy-input').val(position.lat);
        $('#geox-input').val(position.lng);
    });
    map.addLayer(marker);
</script>