<?php

use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\crud\CrudAsset;
use app\modules\services\UtilityService;
use kartik\detail\DetailView;
use app\widgets\maps\LeafletMapAsset;
use app\widgets\maps\plugins\leafletlocate\LeafletLocateAsset;
LeafletLocateAsset::register($this);

LeafletMapAsset::register($this);
CrudAsset::register($this);

$requestedAction = Yii::$app->requestedAction;
$controller = $requestedAction->controller;
$label = $controller->label;

$this->title = implode(' ', [$label[$requestedAction->id],$controller->title]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $label['index'] . ' ' . $controller->title), 'url' => Url::to(['index'])];
$this->params['breadcrumbs'][] = $this->title;
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
                <h3 class="block-title">Thông tin cửa hàng</h3>
                <div class="block-options">
                    <?= Html::a('Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
                </div>
            </div>
            <div class="d-lg-none py-2 px-2">
                <div class="row">
                    <div class="col-lg-12">
                        <button type="button"
                            class="btn w-100 btn-primary d-flex justify-content-between align-items-center"
                            data-toggle="class-toggle" data-target="#tabs-navigation" data-class="d-none">
                            Menu
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>


            <div class="block-content tab-content">
                <div class="tab-pane active" id="thongtinnocgia-view">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width:35%"><?= $model->getAttributeLabel('ten_cua_hang')?></th>
                                    <td><?= $model->ten_cua_hang?></td>
                                </tr>
                                <tr>
                                    <th style="width:35%"><?= $model->getAttributeLabel('thuoc_bao_ve')?></th>
                                    <td><?= $thuocbaove?></td>
                                </tr>
                                <tr>
                                    <th style="width:35%"><?= $model->getAttributeLabel('dia_chi')?></th>
                                    <td>
                                        <?= 
                                        $model->so_nha.', '.$model->ten_duong.', '.(($model->phuongxa_id != null)? $model->phuongxa->ten.', '.$model->phuongxa->quanhuyen->ten.', '.$model->phuongxa->quanhuyen->tinhthanh->ten : ''); 
                                        ?>
                                    </td>
                                </tr>
                                <?php if($model->url_hinhanh != null): ?>
                                <tr>
                                    <th style="width:35%">Hình ảnh</th>
                                    <td><img src="<?= Yii::$app->homeUrl ?><?= $model->url_hinhanh ?>" width="100%"
                                            height="550px" /></td>
                                </tr>
                                <?php endif; ?>
                                <?php if($model->geo_x != null && $model->geo_y != null): ?>
                                <tr>
                                    <th style="width:35%">GGMap</th>
                                    <td><a href="https://www.google.com/maps/dir//<?= $model->geo_y ?>,<?= $model->geo_x ?>/@<?= $model->geo_y ?>,<?= $model->geo_x ?>,16z?entry=ttu"
                                            target="blank">GGMap</a></td>
                                </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                        <div class="col-lg-12">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="block-content">
                <div class="row px-3">
                    <div class="col-lg-12 form-group">
                        <a href="javascript:history.back()" class="btn btn-light float-end"><i
                                class="fa fa-arrow-left"></i>
                            Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "size" => Modal::SIZE_EXTRA_LARGE,
    "footer" => "", // always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>

<script type="module">
    $(document).ready(function() {
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            localStorage.setItem('lastTab', $(this).attr('href'));
            localStorage.setItem('nocgia_id', '<?= $_GET['id'] ?>')
        });
        var lastTab = localStorage.getItem('lastTab');


        if (localStorage.getItem('nocgia_id') == <?= $_GET['id'] ?>) {
            if (lastTab) {
                $('[href="' + lastTab + '"]').tab('show');
            }
        }
    });

    var map = L.map('map').setView([<?= ($model->geo_y != null) ? $model->geo_y : '9.60802790773281' ?>,
        <?= ($model->geo_x != null) ? $model->geo_x : '105.98158836364748' ?>
    ], 20);


    var layerGMapSatellite = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });

    var layerGmapStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });


    var phuongxa = new L.geoJson.ajax(
        '<?= Yii::$app->homeUrl ?>' + 'map/default/ranh-xa', {
            onEachFeature: function(feature, layer) {
                layer.bindPopup(
                    '<p>Tên phường xã: ' + feature.properties.ten + '<br>Tên Quận huyện: ' + feature.properties
                    .ten_quan + '</p>'
                );
            }
        }
    );


    var baseLayers = {
        "GGMap": layerGmapStreets,
        "Vệ tinh": layerGMapSatellite,
    };

    var overLayers = {
        'Ranh phường': phuongxa,
    };

    L.control.layers(baseLayers, overLayers).addTo(map);
    map.addLayer(layerGmapStreets, true);

    var icon = L.icon({
        iconUrl: 'https://auth.hcmgis.vn/uploads/icon/home-address-blue.png',
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -48],
    });

    // L.control.locate({
    //     position: 'topright',
    //     icon: 'fa fa-location',
    //     strings: {
    //         title: "Vị trí hiện tại"
    //     }
    // }).addTo(map);

    <?php if ($model->geo_x != null && $model->geo_y != null) : ?>
    var marker = L.marker([<?= $model->geo_y ?>, <?= $model->geo_x ?>], {
        'icon': icon,
    }).addTo(map);

    map.on('click', function(e) {
        //console.log(e)
        //var newMarker = new L.marker([e.latlng.lat, e.latlng.lng]).addTo(map).on('click', e => e.target.remove());
        var newMarker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);

        console.log(newMarker);

        L.Routing.control({
            waypoints: [
                L.latLng(newMarker._latlng.lat, newMarker._latlng.lng),
                L.latLng(<?= $model->geo_y ?>, <?= $model->geo_x ?>),
            ]
        }).addTo(map);

    });

    <?php endif; ?>
    
</script>