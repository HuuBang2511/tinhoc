<?php

use yii\helpers\Url;
use app\widgets\maps\LeafletMapAsset;
use yii\widgets\DetailView;
use yii\bootstrap5\Modal;
use app\widgets\crud\CrudAsset;
use app\widgets\maps\plugins\leaflet_measure\LeafletMeasureAsset;

CrudAsset::register($this);

LeafletMapAsset::register($this);
LeafletMeasureAsset::register($this);
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
        <h3 class="block-title">Thông tin chi tiết vùng canh tác</h3>
        <div class="block-options">
            <a class="btn btn-warning float-left"
                href="<?= Url::to(['update', 'id' => $model->id]) ?>"><?= $const['label']['update'] ?></a>
        </div>
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

                var measureControl = new L.Control.Measure({
                    position: 'bottomright',
                    primaryLengthUnit: 'meters',
                    secondaryLengthUnit: undefined,
                    primaryAreaUnit: 'sqmeters',
                    decPoint: ',',
                    thousandsSep: '.'
                });
                measureControl.addTo(map);

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

                var overLayers = {
                    'Ranh xã' : phuongxa,
                };


                var baseLayers = {
                    //"HCMGIS": layerHCMMap,
                    "GMap": layerGmapStreets,
                    "Satellite": layerGMapSatellite,
                };


                L.control.layers(baseLayers, overLayers).addTo(map);
                map.addLayer(layerGmapStreets, true);

                <?php if($diagioihanhchinh->geom_text != null) :?>
                var state1s = [{
                    "type": "Feature",
                    "properties": {
                        "": ""
                    },
                    "geometry": <?= $diagioihanhchinh->geom_text ?>
                }];

                var polygon1 = L.geoJSON(state1s).addTo(map);
                polygon1.setStyle({
                    fillColor: 'yellow',
                    opacity: '1.2'
                });
                polygon1.bindPopup(
                    "Mã địa giới hành chính: <?= $diagioihanhchinh->ma_diagioi_hanhchinh?><br> Tên: <?= $diagioihanhchinh->ten?>"
                    ).openPopup();
                map.fitBounds(polygon1.getBounds());
                map.panTo(polygon1.getBounds().getCenter());

                <?php endif;?>

                <?php if($model->geom_text != null) :?>
                var states = [{
                    "type": "Feature",
                    "properties": {
                        "": ""
                    },
                    "geometry": <?= $model->geom_text ?>
                }];

                var polygon = L.geoJSON(states).addTo(map);
                polygon.bindPopup(
                    "Loại cây trồng: <?= ($model->loaicaytrong_id != null)? $model->loaicaytrong->ten : '' ?><br> Diện tích: <?= $model->dien_tich?> m2"
                    ).openPopup();
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
                        'ten_vung',
                        [
                            'label' => 'Diện tích',
                            'value' => function($model){
                                return ($model->dien_tich!= null) ? $model->dien_tich.' m²' : '';
                            }
                        ],
                        [
                            'label' => 'Loại cây trồng',
                            'value' => function($model){
                                return ($model->loaicaytrong_id != null) ? $model->loaicaytrong->ten : '';
                            }
                        ]
                    ],
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php if($dienbien == null): ?>
                <a href="<?= Yii::$app->homeUrl ?>quanly/dienbien-dichbenh/create?id=<?= $_GET['id'] ?>"
                    class="btn btn-block btn-success mb-3 float-end">Thêm thông tin diễn biến dịch bệnh</a>
                <?php else: ?>
                <h3> Diễn biến dịch bệnh</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>Mã Nông hộ</th>
                        <th>Diện tích nhiễm bệnh</th>
                        <th>Thời điểm</th>
                        <th></th>
                    </tr>
                    <?php if ($dienbien != null) : ?>
                    <tr>
                        <td><?= ($dienbien->nongho_id != null) ? $dienbien->nongho->ma_nong_ho : '' ?></td>
                        <td><?= ($dienbien->dientich_nhiembenh!= null) ? $dienbien->dientich_nhiembenh.' m&sup2' : '' ?></td>
                        <td><?= ($dienbien->thoi_diem != null) ? $dienbien->thoi_diem : '' ?></td>
                        <td class="text-center">
                            <a
                                href="<?= Yii::$app->homeUrl ?>quanly/dienbien-dichbenh/view?id=<?= $dienbien->id ?>" role = 'modal-remote'>
                                <i class="fa fa-eye"></i>
                            </a>
                            <a
                                href="<?= Yii::$app->homeUrl ?>quanly/dienbien-dichbenh/update?id=<?= $dienbien->id ?>">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a
                                href="<?= Yii::$app->homeUrl ?>quanly/dienbien-dichbenh/delete?id=<?= $dienbien->id ?>"  data-toggel = 'tooltip', data-confirm="Xóa thông tin diễn biến dịch bênh">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </table>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 form-group">
                <a class="btn btn-outline-secondary float-end" href="javascript:history.back()"><i
                        class="fa fa-angle-left"></i> Quay lại</a>
            </div>
        </div>
    </div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>