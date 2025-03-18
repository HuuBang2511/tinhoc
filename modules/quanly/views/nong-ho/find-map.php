<?php

use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

$requestedAction = Yii::$app->requestedAction;
$controller = $requestedAction->controller;
$label = $controller->label;

$this->title = $controller->title;
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => Yii::$app->urlManager->createUrl(['quanly/nong-ho/index'])];
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

<style>
    #map {
    width: 100%;
        height: 90vh;
        border: 1px solid #0665d0
    }

    .leaflet-top.leaflet-right {
        max-height: 500px;
        overflow-y: scroll;
    }
</style>

<script src="<?= Yii::$app->homeUrl?>resources/core/js/leaflet.ajax.js"></script>

<div class="row">
    <div class="col-lg-12">
        <div class="block block-themed">
            <div class="block-header">
                <h3 class="block-title"><?= $this->title ?></h3>
            </div>
            <div class="block-content">
                <?php $form = ActiveForm::begin() ?>
                <h2 class="content-heading">Tìm cửa hàng thuốc</h2>
                <div class="row">
                    <div class="col-lg-3">
                        <?= $form->field($model, 'nongho_id')->widget(Select2::class, [
                            'data' => ArrayHelper::map($categories['nongho'], 'id', 'ma_nong_ho'),
                            'options' => ['prompt' => 'Chọn nông hộ'],
                            'pluginOptions' => ['allowClear' => true]
                        ]) ?>
                    </div>
                    <div class="col-lg-9">
                        <?= $form->field($model, 'loaibenh_id')->widget(Select2::class, [
                            'data' => ArrayHelper::map($categories['loaibenh'], 'id', 'ten'),
                            'options' => ['prompt' => 'Chọn loại bệnh'],
                            'pluginOptions' => ['allowClear' => true]
                        ]) ?>
                    </div>
                </div>
                

                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <?= Html::submitButton('Tìm kiếm',['class' => 'btn btn-primary'])?>
                    </div>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="block block-themed">
            <div class="block-header">
                <h3 class="block-title">Bản đồ</h3>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    
    <?php if(isset($nongho) && $nongho != null && $nongho->geo_y != null && $nongho->geo_x != null): ?>
    var map = L.map('map').setView([<?= ($nongho->geo_y != null) ? $nongho->geo_y : '9.60802790773281' ?>, <?= ($nongho->geo_x != null) ? $nongho->geo_x : '105.98158836364748' ?>],10);
    <?php else: ?>
    var map = L.map('map').setView(['9.60802790773281', '105.98158836364748'],10);
    <?php endif; ?>



    var layerGMapSatellite = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });

    var layerGmapStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
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
        "GMap": layerGmapStreets,
        "Satellite": layerGMapSatellite,
    };

    var overLayers = {
        'Ranh xã': phuongxa,
    };

    L.control.layers(baseLayers, overLayers).addTo(map);
    map.addLayer(layerGmapStreets, true);

    var iconNongho = L.icon({
        iconUrl: '<?= Yii::$app->homeUrl ?>images/home-address-blue.png',
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -48],
    });

    var iconCuahang = L.icon({
        iconUrl: '<?= Yii::$app->homeUrl ?>images/shop-64.png',
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -48],
    });

    <?php if(isset($nongho) && isset($cuahangTim) && $nongho != null && $cuahangTim != null): ?>
    L.Routing.control({
        waypoints: [
            L.latLng(<?= $nongho->geo_y ?>, <?= $nongho->geo_x ?>),
            L.latLng(<?= $cuahangTim->geo_y ?>, <?= $cuahangTim->geo_x ?>),
        ]
    }).addTo(map);

    var markerCuahang = L.marker([<?= $cuahangTim->geo_y ?>, <?= $cuahangTim->geo_x ?>], {
            'icon': iconCuahang,
    }).addTo(map);
    markerCuahang.bindPopup(
        "Tên cửa hàng: <?= $cuahangTim->ten_cua_hang ?>"
    ).openPopup();

    var markerNongho = L.marker([<?= $nongho->geo_y ?>, <?= $nongho->geo_x ?>], {
            'icon': iconNongho,
    }).addTo(map);
    markerNongho.bindPopup(
        "Chủ nông hộ: <?= $nongho->chunongho_ten ?><br> Mã nông hộ: <?= $nongho->ma_nong_ho ?>"
    ).openPopup();

    
    <?php endif; ?>

    
    
</script>
