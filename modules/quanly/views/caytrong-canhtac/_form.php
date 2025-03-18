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
<script src="<?= Yii::$app->homeUrl?>resources/core/js/leaflet.ajax.js"></script>

<div class="block block-themed">
    <div class="block-header">
        <h3 class="block-title">
            <?= $model->isNewRecord ? $const['label']['create'] . ' ' . $controller->const['title'] : $const['label']['update'] . ' ' . $controller->const['title']; ?>
        </h3>
    </div>

    <div class="block-content">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form']) ?>
        <?= Html::hiddenInput('CaytrongCanhtac[geom_text]', $model->geom_text, ['id' => 'geom_text']) ?>
        <div class="form-group">
            <div id="map" style="height: 500px"></div>

            <script>
                // center of the map
                var center = [9.60802790773281, 105.98158836364748];

                // Create the map
                var map = L.map('map').setView(center, 14);

                // Set up the OSM layer
                L.tileLayer('http://{s}.google.com/vt/lyrs=' + 'r' + '&x={x}&y={y}&z={z}', {
                    maxZoom: 24,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                }).addTo(map);

                var
                    baseMaps = {
                        'ggmap' :  L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                            maxZoom: 20,
                            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                        }),
                        "Ảnh vệ tinh": L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                            maxZoom: 24,
                            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                        }),

                    };

                var measureControl = new L.Control.Measure({
                    position: 'bottomright',
                    primaryLengthUnit: 'meters',
                    secondaryLengthUnit: undefined,
                    primaryAreaUnit: 'sqmeters',
                    decPoint: ',',
                    thousandsSep: '.'
                });
                measureControl.addTo(map);

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

                var layerControl = L.control.layers(baseMaps, overLayers).addTo(map);
                // add a marker in the given location
                //L.marker(center).addTo(map);

                // Initialise the FeatureGroup to store editable layers
                var editableLayers = new L.FeatureGroup();
                map.addLayer(editableLayers);
                
                <?php if(!$model->isNewRecord): ?>
                    var oldLayers = new L.FeatureGroup();
                    map.addLayer(oldLayers);
                <?php endif; ?>

                var drawPluginOptions = {
                    position: 'topleft',
                    draw: {
                        polygon: {
                            allowIntersection: false, // Restricts shapes to simple polygons
                            drawError: {
                                color: '#e1e100', // Color the shape will turn when intersects
                                message: '<strong>Oh không!<strong> bạn ko thể vẽ ở đó!' // Message that will show when intersect
                            },
                            shapeOptions: {
                                color: '#97009c'
                            }
                        },
                        // disable toolbar item by setting it to false
                        polyline: false,
                        circle: false, // Turns off this drawing tool
                        circlemarker: false, // Turns off this drawing tool
                        rectangle: true,
                        marker: false,
                    },
                    edit: {
                        featureGroup: editableLayers, //REQUIRED!!
                        remove: true,
                        edit: true,
                    }
                };

                // Initialise the draw control and pass it the FeatureGroup of editable layers
                var drawControl = new L.Control.Draw(drawPluginOptions);
                map.addControl(drawControl);

                <?php if($diagioihanhchinh != null): ?>
                    var statesDiagioi = [{
                    "type": "Feature",
                    "properties": {
                        "": ""
                    },
                    "geometry": <?= $diagioihanhchinh->geom_text ?>
                    }];

                    var polygonDiagioi = L.geoJSON(statesDiagioi).addTo(map);

                    polygonDiagioi.setStyle({
                        fillColor: 'yellow',
                        opacity: '1.2'
                    });

                    <?php if($model->isNewRecord):?>
                        var boundsDiagioi = polygonDiagioi.getBounds()

                        if(boundsDiagioi.isValid() === true) {
                            //Fit the map to the polygon bounds
                            map.fitBounds(boundsDiagioi)

                            // Or center on the polygon
                            var centerstates = boundsDiagioi.getCenter()
                            map.panTo(centerstates)
                        }
                    <?php endif; ?>
                <?php endif; ?>
                
                var dataMap = []; 

                <?php if($model->geom_text != null) :?>

                    var geojsonData = <?= $model->geom_text ?>;
                    jsonData = geojsonData.coordinates;
                    console.log(jsonData);

                    var states = [];

                    for(var i = 0; i < jsonData.length; i++){
                        states.push(
                            {
                                "type": "Feature",
                                "properties": {"": ""},
                                "geometry":   {
                                    "type":"Polygon",
                                    "coordinates" : [
                                        jsonData[i][0]
                                    ]
                                }   
                            }
                        );
                    }

                    L.geoJSON(states, {
                        onEachFeature: function (feature, layer) {
                            //L.polygon(layer.getLatLngs()).addTo(editableLayers);
                            editableLayers.addLayer(layer);
                            console.log(layer.toGeoJSON().geometry.coordinates);
                            data = layer.toGeoJSON().geometry.coordinates;
                            dataMap[layer._leaflet_id] = data;
                        }
                    });

                    // Get bounds object
                    var bounds = editableLayers.getBounds()
                    console.log(bounds);

                    if(bounds.isValid() === true) {
                         //Fit the map to the polygon bounds
                        map.fitBounds(bounds)

                        // Or center on the polygon
                        var centerstates = bounds.getCenter()
                        map.panTo(centerstates)
                    }
                   
                <?php endif;?>

                
                map.addLayer(editableLayers);

                map.on('draw:created', function (e) {

                    var type = e.layerType,
                        layer = e.layer;
                    
                    editableLayers.addLayer(layer);

                    data = layer.toGeoJSON().geometry.coordinates;

                    dataMap[layer._leaflet_id] = data;

                    console.log(dataMap);

                    //console.log(JSON.stringify(Object.assign({}, dataMap)));

                    $('#geom_text').val(JSON.stringify(Object.assign({}, dataMap)));
                });

                map.on('draw:deleted', function (e) {
                    var layers = e.layers;

                    layers.eachLayer(function (layer) {
                        //data = layer.toGeoJSON().geometry.coordinates;
                        //dataMap =  dataMap.filter(item => item !== data);
                        //dataMap.splice((layer._leaflet_id), 1);
                        dataMap[layer._leaflet_id] = undefined;
                        console.log(dataMap);
                    });

                    $('#geom_text').val(JSON.stringify(Object.assign({}, dataMap)));
                });

                map.on('draw:edited', function (e) {
                    var layers = e.layers;
                    
                    layers.eachLayer(function (layer) {
                        data = layer.toGeoJSON().geometry.coordinates;
                        dataMap[layer._leaflet_id] = data;
                        $('#geom_text').val(JSON.stringify(Object.assign({}, dataMap)));
                    });
                });
            </script>
        </div>
        <h2 class="content-heading text-uppercase">Thông tin</h2>
        
        <div class="row">
            <div class="col-lg-3">
                <?= $form->field($model, 'ten_vung')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'dien_tich')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'loaicaytrong_id')->widget(Select2::className(), [
                        'data' => ArrayHelper::map($categories['loaicaytrong'], 'id', 'ten'),
                        'options' => ['prompt' => 'Chọn loại cây trồng'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                ]) ?>
            </div>
        </div>
        <!--Mục đích sử dụng-->
        
        <div class="row">
            <div class="col-lg-12 pb-3">
                <?= Html::submitButton('Lưu', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

