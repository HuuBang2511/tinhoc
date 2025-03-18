<?php

use yii\helpers\Url;
use app\widgets\maps\LeafletMapAsset;
use yii\widgets\DetailView;

LeafletMapAsset::register($this);
$requestedAction = Yii::$app->requestedAction;
$controller = $requestedAction->controller;
$const['label'] = $controller->const['label'];

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\Khoanh */
$this->title = Yii::t('app', $const['label'][$requestedAction->id] . ' ' . $controller->const['title']);
$this->params['breadcrumbs'][] = ['label' => $const['label']['index'] . ' ' . $controller->const['title'], 'url' => $controller->const['url']['index']];
$this->params['breadcrumbs'][] = $const['label']['view'] . ' ' . $controller->const['title'];

?>

<script src="<?= Yii::$app->homeUrl?>resources/core/js/leaflet.ajax.js"></script>

<div class="block block-themed">

    <div class="block-header">
        <h3 class="block-title"><?= $model->ten != null ? 'Địa giới hành chính ' . $model->ten : '' ?></h3>
    </div>
    <div class="block-content">
        <div class="row">
            <div class="col-lg-12">
                <div id="map" style="height: 600px"></div>
                <script>
                    var center = [9.60802790773281, 105.98158836364748];
                    var map = L.map('map').setView(center, 14);

                    // var layerHCMMap = L.tileLayer('https://thuduc-maps.hcmgis.vn/thuducserver/gwc/service/wmts?layer=thuduc:thuduc_maps&style=&tilematrixset=EPSG:900913&Service=WMTS&Request=GetTile&Version=1.0.0&Format=image/png&TileMatrix=EPSG:900913:{z}&TileCol={x}&TileRow={y}', {
                    //     layers: 'hcm_map:hcm_map',
                    //     maxZoom: 20,
                    // });

                    var layerGMapSatellite = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                        maxZoom: 20,
                        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                    });

                    var layerGmapStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                        maxZoom: 20,
                        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                    });


                    var baseLayers = {
                        //"HCMGIS": layerHCMMap,
                        "GMap": layerGmapStreets,
                        "Satellite": layerGMapSatellite,
                    };

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

                    console.log(phuongxa);

                    <?php if($dataMapCaytrong != null): ?>

                        var caytrong = L.geoJSON(<?=$dataMapCaytrong?>,{
                                onEachFeature: function(feature, layer) {
                                    layer.bindPopup(
                                        '<p>Tên vùng: '+feature.properties.ten_vung+'</p>'
                                    );
                                }
                            }
                        );

                        console.log(caytrong);

                        var overLayers = {
                            'Ranh xã' : phuongxa,
                            'Cây trồng' : caytrong,
                        };
                    <?php else: ?>
                        var overLayers = {
                            'Ranh xã' : phuongxa,
                        };
                    <?php endif; ?>


                    L.control.layers(baseLayers,overLayers).addTo(map);
                    map.addLayer(layerGmapStreets, true);

                    <?php if($model->geom_text != null) :?>
                    var states = [{
                        "type": "Feature",
                        "properties": {"": ""},
                        "geometry": <?= $model->geom_text ?>
                    }];

                    var polygon = L.geoJSON(states).addTo(map);

                    polygon.setStyle({
                        fillColor: 'yellow',
                        opacity: '1.2'
                    });

                    map.fitBounds(polygon.getBounds());
                    map.panTo(polygon.getBounds().getCenter());

                    <?php endif;?>

                </script>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'ten',
                        'ma_diagioi_hanhchinh',
                    ],
                ]) ?>
            </div>
        </div>

        <div class="row mt-3 mb-3">
            <div class="col-lg-12">
                    <a class="block block-rounded block-fx-pop text-center h-100 mb-0">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="text-uppercase mt-1">Tổng số diện tích vùng trồng</div>
                                    <div class="display-6 fw-bold"><?= isset($dientichVungtrong) ? $dientichVungtrong.' m&sup2' : 0 ?></div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-uppercase mt-1">Tổng số diện tích nhiễm bệnh</div>
                                    <div class="display-6 fw-bold"><?= isset($dientichNhiembenh) ? $dientichNhiembenh.' m&sup2' : 0 ?></div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-uppercase mt-1">Tỉ lệ nhiểm bệnh</div>
                                    <div class="display-6 fw-bold"><?= isset($tileNhiembenh) ? $tileNhiembenh.' %' : 0 ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
            </div>
        </div>

        <div class="row">
            <h3>Vùng cây trồng thuộc địa giới hành chính</h3>
            <?php if(isset($caytrongcanhtac)) : ?>
            <div class="row">
                <div class="col-md-12">
                    <a href="<?= Yii::$app->homeUrl ?>quanly/caytrong-canhtac/create?id=<?= $_GET['id'] ?>"
                    class="btn btn-block btn-success mb-3 float-end">Thêm mới vùng cây trồng canh tác</a>
                    <table class="table table-bordered">
                        <tr>
                            <th>STT</th>
                            <th>Tên vùng</th>
                            <th>Loại cây trồng</th>
                            <th>Diện tích</th>
                            <th></th>
                        </tr>
                        <?php if($caytrongcanhtac != null): ?>
                        <?php foreach($caytrongcanhtac as $i=>$item ): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $item->ten_vung ?></td>
                            <td><?= ($item->loaicaytrong_id != null) ? $item->loaicaytrong->ten : '' ?></td>
                            <td><?= $item->dien_tich.' m&sup2' ?></td>
                            <td class="text-center">
                                <a
                                    href="<?= Yii::$app->homeUrl ?>quanly/caytrong-canhtac/view?id=<?= $item->id ?>">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-lg-12 form-group">
                <a class="btn btn-outline-secondary float-end" href="javascript:history.back()"><i
                            class="fa fa-angle-left"></i> Quay lại</a>
            </div>
        </div>
    </div>
</div>