<?php

use app\assets\Vite;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\widgets\maps\LeafletMapAsset;
use app\widgets\maps\plugins\leafletlocate\LeafletLocateAsset;
use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use app\modules\quanly\models\LoaiCayTrong;

LeafletMapAsset::register($this);
\app\widgets\maps\plugins\leafletprint\PrintMapAsset::register($this);
\app\widgets\maps\plugins\markercluster\MarkerClusterAsset::register($this);
\app\widgets\maps\plugins\leaflet_measure\LeafletMeasureAsset::register($this);
LeafletLocateAsset::register($this);

$this->title = 'Bản đồ';

$loaicaytrong = LoaiCayTrong::find()->select('id, ten')->where(['status' => 1])->asArray()->all();

?>
<style>
#map {
    width: 100%;
    height: 90vh;
}
</style>

<div class="row mx-0">

    <div class="col-lg-12 px-0 py-0">
        <div id="map">
        </div>
    </div>
</div>

<script>
var defined = {
    layer_phuong: "Ranh Phường xã",
    layer_quan: 'Ranh Huyện',

    layer_nongho: "Nông hộ",
    layer_cuahang: "Cửa hàng thuốc bảo vệ",
    layer_diagioi: "Địa giới hành chính",
    layer_caytrong: "Vùng cây trồng canh tác",
    //layer_atm: "ATM",

    <?php foreach($loaicaytrong as $i => $item): ?>
        layer_<?=$item['id']?> : "Vùng trồng <?= $item['ten'] ?>",
    <?php endforeach; ?>
    
};
var DATA = {
    HomeUrl: "<?= Yii::$app->homeUrl ?>",
    MapConfig: {
        mapId: "map",
        defaultCenter: [9.60802790773281, 105.98158836364748],
        defaultZoom: 13,
        defaultConfig: {
            maxZoom: 25,
            zoomControl: false,
        },
        baseLayers: ["GoogleMap"],
        overLayers: ['GoogleSatellite','Huyện', 'Địa giới','Cây trồng','Nông hộ', 'Cửa hàng', ],
        activeLayers: ["GoogleMap"],
        initOthers: [],

    },
    MapLayer: {
        baselayer: {},
        overlayers: {},
    },
    MapControl: {},
    Refs: {
        Markers: [],
        LeafletLayers: {
           
            "GoogleMap": L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                    maxZoom: 24,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                }),
            "GoogleSatellite": L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                maxZoom: 24,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            }),
            'Huyện' :  L.tileLayer.wms('http://localhost:8080/geoserver/quanlynongho/wms?', {
                layers: 'quanlynongho:soc_trang_huyen',
                transparent: true,
                format: 'image/png8',
                // maxZoom: 24,
                // minZoom: 12,
            }),
            "Địa giới": L.tileLayer.wms('http://localhost:8080/geoserver/quanlynongho/wms?', {
                layers: 'quanlynongho:diagioi_hanhchinh',
                transparent: true,
                format: 'image/png8',
                // maxZoom: 24,
                // minZoom: 12,
            }),
            'Nông hộ':  L.tileLayer.wms('http://localhost:8080/geoserver/quanlynongho/wms?', {
                layers: 'quanlynongho:nong_ho',
                transparent: true,
                format: 'image/png8',
            }),
            "Cây trồng": L.tileLayer.wms('http://localhost:8080/geoserver/quanlynongho/wms?', {
                layers: 'quanlynongho:caytrong_canhtac',
                transparent: true,
                format: 'image/png8',
                // maxZoom: 24,
                // minZoom: 12,
            }),
            'Cửa hàng':  L.tileLayer.wms('http://localhost:8080/geoserver/quanlynongho/wms?', {
                layers: 'quanlynongho:cuahang_thuocbaove',
                transparent: true,
                format: 'image/png8',
            }),
        }
    }
};
$(document).ready(function() {
    initMap();
});

function  getFeatureInfoUrl(config, layer, latlng, url){
    if (typeof(config) == 'undefined') {
        config = DATA.MapConfig;
    }

    let size = DATA[config.mapId].Map.getSize();
    let bbox = DATA[config.mapId].Map.getBounds().toBBoxString();
    let point = DATA[config.mapId].Map.latLngToContainerPoint(latlng, DATA[config.mapId].Map.getZoom());

    const FeatureInfoUrl = url +
    `&bbox=${bbox}` +
    "&INFO_FORMAT=application/json" +
    "&REQUEST=GetFeatureInfo" +
    "&EXCEPTIONS=application/vnd.ogc.se_xml" +
    "&SERVICE=WMS" +
    "&VERSION=1.1.1" +
    `&WIDTH=${size.x}&HEIGHT=${size.y}&X=${parseInt(point.x)}&Y=${parseInt(point.y)}` +
    `&LAYERS=${layer}` +
    `&QUERY_LAYERS=${layer}` +
    `&TYPENAME=${layer}`;

    return FeatureInfoUrl;
}


function initMap(config) {
    if (typeof(config) == 'undefined') {
        config = DATA.MapConfig;
    }

    DATA[config.mapId] = {};
    DATA[config.mapId].Map = new L.Map(config.mapId, config.defaultConfig);
    DATA[config.mapId].Map.setView(config.defaultCenter, config.defaultZoom);
    group = L.featureGroup().addTo(DATA[config.mapId].Map);
    DATA[config.mapId].MapControl = {};
    DATA[config.mapId].MapLayer = {
        baseLayers: {},
        overLayers: {}
    };

    initMapLayer(config);
    initMapControl(config);
    initOther(config);

    //initNongHo();
    // initCuahangThuocbaove();
    // initCaytrongCanhtac();

    // <?php foreach($loaicaytrong as $i => $item): ?>
    //     initVungtrong(<?=$item['id']?>,defined.layer_<?=$item['id']?>);
    // <?php endforeach; ?>

    // setTimeout(() => {
    //     initDiagioi();
    // }, 100);

    // setTimeout(() => {
    //     initRanhQuan();
    // }, 200);


    DATA[config.mapId].Map.on('click', function(e) {
        //console.log(e);

        const layers = DATA[config.mapId].Map._layers;

        //console.log(layers);

        for (const idx in layers) {
            const layer = layers[idx];
            console.log(layer);
            if (layer.wmsParams && layer._url && layer.wmsParams.layers != "") {
                console.log(layer);
                let url =  getFeatureInfoUrl(config, layer.wmsParams.layers, e.latlng, layer._url);
                //getFeatureInfoUrl(config, layer.wmsParams.layers, e.latlng, layer._url);

                //console.log(url);

                let layerName = layer.wmsParams.layers;
                layerName = layerName.split(':');
                layerName = String(layerName[1]);

                console.log(layerName);

                fetch(url).
                then(function (res) {
                    return res.json()
                })
                .then(function (geojsonData) {     
                    console.log(geojsonData.features);
                    if (geojsonData.features && geojsonData.features.length > 0) {
                        let popupContent = "popup";

                        if(layerName == 'diagioi_hanhchinh'){
                            popupContent = "Mã địa giới hành chính:"+geojsonData.features[0].properties.ma_diagioi_hanhchinh+'<br><a href="'+DATA.HomeUrl+'quanly/diagioi-hanhchinh/view?id='+geojsonData.features[0].properties.id+'" target="blank">Chi tiết</a>' ;
                        }
                        if(layerName == 'nong_ho'){
                            popupContent = "Nông hộ"+'<br><a href="'+DATA.HomeUrl+'quanly/nong-ho/view?id='+geojsonData.features[0].properties.id+'" target="blank">Chi tiết</a>' ;
                        }
                        if(layerName == 'cuahang_thuocbaove'){
                            popupContent = "Cửa hàng thuốc bảo vệ"+'<br><a href="'+DATA.HomeUrl+'quanly/cuahang-thuocbaove/view?id='+geojsonData.features[0].properties.id+'" target="blank">Chi tiết</a>' ;
                        }
                        if(layerName == 'caytrong_canhtac'){
                            popupContent = "Vùng trồng"+'<br><a href="'+DATA.HomeUrl+'quanly/caytrong-canhtac/view?id='+geojsonData.features[0].properties.id+'" target="blank">Chi tiết</a>' ;
                        }
                        
                        var popup = L.popup()
                        .setLatLng(e.latlng)
                        .setContent(popupContent)
                        .openOn(DATA[config.mapId].Map);
                    }
                })
            }
        }
    });

}

function initMapLayer(config) {
    config.baseLayers.map(function(layer) {
        DATA[config.mapId].MapLayer.baseLayers[layer] = DATA.Refs.LeafletLayers[layer];
    });
    config.overLayers.map(function(layer) {
        DATA[config.mapId].MapLayer.overLayers[layer] = DATA.Refs.LeafletLayers[layer];
    });
    config.activeLayers.map(function(layer) {
        DATA.Refs.LeafletLayers[layer].addTo(DATA[config.mapId].Map);
    });
}

function initMapControl(config) {
    initControlMapLayer(config);
    initControlZoom(config);
    initControlLocate(config);
    initControlMeasure(config);
    initControlScale(config);
}

function initOther(config) {
    config = DATA.MapConfig;
    config.initOthers.map(function(func) {
        func(config)
    });
}


function initControlZoom(config) {
    L.control.zoom({
        position: 'topright'
    }).addTo(DATA[config.mapId].Map);
}

function initControlLocate(config) {
    L.control.locate({
        position: 'topright',
        icon: 'fa fa-location',
        strings: {
            title: "Vị trí hiện tại"
        }
    }).addTo(DATA[config.mapId].Map);
}

function initControlMapLayer(config) {
    DATA[config.mapId].MapControl.layercontrol = L.control.layers(DATA[config.mapId].MapLayer.baseLayers, DATA[config
        .mapId].MapLayer.overLayers, {
        position: 'topright'
    });
    DATA[config.mapId].MapControl.layercontrol.addTo(DATA[config.mapId].Map);
}


function mapZoomAndPanTo(x, y, zoom) {
    DATA[DATA.MapConfig.mapId].Map.flyTo([x, y], zoom, {
        animate: true,
        easeLinearity: 4
    });
}

function initControlMeasure(config) {
    var measureControl = new L.Control.Measure({
        position: 'topright',
        primaryLengthUnit: 'meters',
        secondaryLengthUnit: undefined,
        primaryAreaUnit: 'sqmeters',
        decPoint: ',',
        thousandsSep: '.'
    });
    measureControl.addTo(DATA[config.mapId].Map);
}

function initControlScale(config) {
    L.control.scale().addTo(DATA[config.mapId].Map);
}

function resizeMap() {
    setTimeout(function() {
        DATA[DATA.MapConfig.mapId].Map.invalidateSize();
    }, 400);

}

function initVungtrong(id,layer_vungtrong) {
var currentMap = DATA[DATA.MapConfig.mapId].Map;
var currentMapControl = DATA[DATA.MapConfig.mapId].MapControl;
$.ajax({
    url: DATA.HomeUrl + 'map/default/vungtrong?id='+id,
    // data: 
    //     'street': street
    // },
    dataType: 'json',
    error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log("Status: " + textStatus);
        console.log("Error: " + errorThrown);
    },
    success: function(data) {
        var polygon = L.geoJSON(data, {
            
        });

        if (typeof DATA.Refs.LeafletLayers[layer_vungtrong] != 'undefined' && currentMap.hasLayer(
                DATA.Refs.LeafletLayers[layer_vungtrong])) {
            currentMap.removeLayer(DATA.Refs.LeafletLayers[layer_vungtrong]);
        }

        DATA.Refs.LeafletLayers[layer_vungtrong] = polygon;

        var polygon = L.geoJSON(data, {
        onEachFeature: function (feature, layer) {
            layer.bindPopup(
                '<p>Tên vùng: '+feature.properties.ten_vung+'<br>Mã địa giới hành chính vùng thuộc: '+feature.properties.ma_diagioi_hanhchinh+'<br>Loại cây trồng: '+feature.properties.loaicaytrong+'</p><a href="'+DATA.HomeUrl+'/quanly/caytrong-canhtac/view?id='+feature.properties.id+'" target="blank">Chi tiết</a>'
            );
            layer.setStyle({fillColor :'green'}); ;
            layer.setStyle({fillOpacity :'0.4'}) ;
        }
        });
       
        DATA[DATA.MapConfig.mapId].MapControl.layercontrol.addOverlay(polygon, layer_vungtrong);

    }
});
}

function initRanhXa() {

var currentMap = DATA[DATA.MapConfig.mapId].Map;
var currentMapControl = DATA[DATA.MapConfig.mapId].MapControl;
$.ajax({
    url: DATA.HomeUrl + 'map/default/ranh-xa',
    // data: {
    //     'street': street
    // },
    dataType: 'json',
    error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log("Status: " + textStatus);
        console.log("Error: " + errorThrown);
    },
    success: function(data) {
        var polygon = L.geoJSON(data, {
            
        });

        if (typeof DATA.Refs.LeafletLayers[defined.layer_phuong] != 'undefined' && currentMap.hasLayer(
                DATA.Refs.LeafletLayers[defined.layer_phuong])) {
            currentMap.removeLayer(DATA.Refs.LeafletLayers[defined.layer_phuong]);
        }

        DATA.Refs.LeafletLayers[defined.layer_phuong] = polygon;

        var polygon = L.geoJSON(data, {
        onEachFeature: function (feature, layer) {
            layer.bindPopup(
                '<p>Tên phường xã: '+feature.properties.ten+'<br>Tên Quận huyện: '+feature.properties.ten_quan+'</p>'
            );
        }
        });
       
        DATA[DATA.MapConfig.mapId].MapControl.layercontrol.addOverlay(polygon, defined.layer_phuong);

    }
});
}

function initRanhQuan() {

var currentMap = DATA[DATA.MapConfig.mapId].Map;
var currentMapControl = DATA[DATA.MapConfig.mapId].MapControl;
$.ajax({
    url: DATA.HomeUrl + 'map/default/ranh-quan',
    // data: {
    //     'street': street
    // },
    dataType: 'json',
    error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log("Status: " + textStatus);
        console.log("Error: " + errorThrown);
    },
    success: function(data) {
        var polygon = L.geoJSON(data, {
            
        });

        if (typeof DATA.Refs.LeafletLayers[defined.layer_quan] != 'undefined' && currentMap.hasLayer(
                DATA.Refs.LeafletLayers[defined.layer_quan])) {
            currentMap.removeLayer(DATA.Refs.LeafletLayers[defined.layer_quan]);
        }

        DATA.Refs.LeafletLayers[defined.layer_quan] = polygon;

        var polygon = L.geoJSON(data, {
        onEachFeature: function (feature, layer) {
            layer.bindPopup(
                '<p>Tên quận: '+feature.properties.ten+'</p>'
            );
            layer.setStyle({fillColor :'#FA0829'}); 
            layer.setStyle({fillOpacity :'0.4'}) ;
            layer.setStyle({color :'black'}) ;
        }
        });
       
        DATA[DATA.MapConfig.mapId].MapControl.layercontrol.addOverlay(polygon, defined.layer_quan);

    }
});
}

function initDiagioi() {

    var currentMap = DATA[DATA.MapConfig.mapId].Map;
    var currentMapControl = DATA[DATA.MapConfig.mapId].MapControl;
    $.ajax({
        url: DATA.HomeUrl + 'map/default/diagioi-hanhchinh',
        // data: {
        //     'street': street
        // },
        dataType: 'json',
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        },
        success: function(data) {
            var polygon = L.geoJSON(data, {
                
            });

            if (typeof DATA.Refs.LeafletLayers[defined.layer_diagioi] != 'undefined' && currentMap.hasLayer(
                    DATA.Refs.LeafletLayers[defined.layer_diagioi])) {
                currentMap.removeLayer(DATA.Refs.LeafletLayers[defined.layer_diagioi]);
            }

            DATA.Refs.LeafletLayers[defined.layer_diagioi] = polygon;

            var polygon = L.geoJSON(data, {
            onEachFeature: function (feature, layer) {
                layer.bindPopup(
                    '<p>Tên: '+feature.properties.ten+'<br>Mã địa giới hành chính: '+feature.properties.ma_diagioi_hanhchinh+'</p><a href="'+DATA.HomeUrl+'/quanly/diagioi-hanhchinh/view?id='+feature.properties.id+'" target="blank">Chi tiết</a>'
                );
                layer.setStyle({fillColor :'yellow'}); ;
                layer.setStyle({fillOpacity :'0.4'}) ;
            }
            });
           
            DATA[DATA.MapConfig.mapId].MapControl.layercontrol.addOverlay(polygon, defined.layer_diagioi);

        }
    });
}

function initNongHo() {
    var currentMap = DATA[DATA.MapConfig.mapId].Map;
    var currentMapControl = DATA[DATA.MapConfig.mapId].MapControl;
    var layerNongho = DATA.Refs.LeafletLayers[defined.layer_nongho];

    if ((typeof layerNongho !== 'undefined') && currentMap.hasLayer(layerNongho)) {
        currentMap.removeLayer(layerNongho);
        currentMapControl.layercontrol.removeLayer(layerNongho);
    }

    var ajax = $.ajax({
        url: DATA.HomeUrl + 'map/default/nong-ho',
        dataType: 'json',
        jsonpCallback: 'getJson',
        success: function(response) {
            var markers = L.layerGroup();

            response.map(function(item) {
                console.log(item);

                var url = '<?= Yii::$app->homeUrl ?>images/home-address-blue.png';

                var icon = L.icon({
                    iconUrl: url,
                    iconSize: [35, 35],
                    iconAnchor: [20, 30],
                    popupAnchor: [0, -48],
                });
                var marker = new L.marker([item.geo_y, item.geo_x], {
                    'icon': icon
                });

                var html = '';
                html += '<strong>Mã nông hộ:</strong> ' + item.ma_nong_ho + '<br>';
                html += '<strong>Chủ nông hộ:</strong> ' + item.chunongho_ten + '<br>';
                html += '<a href="'+DATA.HomeUrl+'/quanly/nong-ho/view?id='+item.id+'" target="blank">Chi tiết</a>'

                marker.bindPopup(html);
                markers.addLayer(marker);
            });

            DATA.Refs.LeafletLayers[defined.layer_nongho] = markers;
            //DATA[DATA.MapConfig.mapId].Map.addLayer(markers);
            DATA[DATA.MapConfig.mapId].MapControl.layercontrol.addOverlay(markers, defined.layer_nongho);
        }
    });
}

function initCuahangThuocbaove() {
    var currentMap = DATA[DATA.MapConfig.mapId].Map;
    var currentMapControl = DATA[DATA.MapConfig.mapId].MapControl;
    var layerCuahang = DATA.Refs.LeafletLayers[defined.layer_cuahang];

    if ((typeof layerCuahang !== 'undefined') && currentMap.hasLayer(layerCuahang)) {
        currentMap.removeLayer(layerCuahang);
        currentMapControl.layercontrol.removeLayer(layerCuahang);
    }

    var ajax = $.ajax({
        url: DATA.HomeUrl + 'map/default/cuahang-thuocbaove',
        dataType: 'json',
        jsonpCallback: 'getJson',
        success: function(response) {
            var markers = L.layerGroup();

            response.map(function(item) {
                console.log(item);

                var url = '<?= Yii::$app->homeUrl ?>images/shop-64.png';

                var icon = L.icon({
                    iconUrl: url,
                    iconSize: [35, 35],
                    iconAnchor: [20, 30],
                    popupAnchor: [0, -48],
                });
                var marker = new L.marker([item.geo_y, item.geo_x], {
                    'icon': icon
                });

                var html = '';
                html += '<strong>Tên cửa hàng:</strong> ' + item.ten_cua_hang + '<br>';
                html += '<strong>Địa chỉ:</strong> ' + item.dia_chi + '<br>';
                html += '<a href="'+DATA.HomeUrl+'/quanly/cuahang-thuocbaove/view?id='+item.id+'" target="blank">Chi tiết</a>';

                marker.bindPopup(html);
                markers.addLayer(marker);
            });

            DATA.Refs.LeafletLayers[defined.layer_cuahang] = markers;
            //DATA[DATA.MapConfig.mapId].Map.addLayer(markers);
            DATA[DATA.MapConfig.mapId].MapControl.layercontrol.addOverlay(markers, defined.layer_cuahang);
        }
    });
}

function initCaytrongCanhtac() {

var currentMap = DATA[DATA.MapConfig.mapId].Map;
var currentMapControl = DATA[DATA.MapConfig.mapId].MapControl;
$.ajax({
    url: DATA.HomeUrl + 'map/default/caytrong-canhtac',
    // data: {
    //     'street': street
    // },
    dataType: 'json',
    error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log("Status: " + textStatus);
        console.log("Error: " + errorThrown);
    },
    success: function(data) {
        
        var polygon = L.geoJSON(data, {
           
        });

        if (typeof DATA.Refs.LeafletLayers[defined.layer_caytrong] != 'undefined' && currentMap.hasLayer(
                DATA.Refs.LeafletLayers[defined.layer_caytrong])) {
            currentMap.removeLayer(DATA.Refs.LeafletLayers[defined.layer_caytrong]);
        }

        DATA.Refs.LeafletLayers[defined.layer_caytrong] = polygon;

        var polygon = L.geoJSON(data, {
        onEachFeature: function (feature, layer) {
            layer.bindPopup(
                '<p>Tên vùng: '+feature.properties.ten_vung+'<br>Mã địa giới hành chính vùng thuộc: '+feature.properties.ma_diagioi_hanhchinh+'<br>Loại cây trồng: '+feature.properties.loaicaytrong+'</p><a href="'+DATA.HomeUrl+'/quanly/caytrong-canhtac/view?id='+feature.properties.id+'" target="blank">Chi tiết</a>'
            );
            layer.setStyle({fillColor :'green'}) ;
            layer.setStyle({fillOpacity :'0.5'}) ;
        }
        });
       
        DATA[DATA.MapConfig.mapId].MapControl.layercontrol.addOverlay(polygon, defined.layer_caytrong);

    }
});
}


// function initWmsPointLayer(layer_wms, layer_map, icon_url, ows_url) {

//     var currentMap = DATA[DATA.MapConfig.mapId].Map;
//     var currentMapControl = DATA[DATA.MapConfig.mapId].MapControl;
//     var layerMap = DATA.Refs.LeafletLayers[layer_map];

//     if ((typeof layerMap !== 'undefined') && currentMap.hasLayer(layerMap)) {
//         currentMap.removeLayer(layerMap);
//         currentMapControl.layercontrol.removeLayer(layerMap);
//     }

//     var owsrootUrl = ows_url;

//     var defaultParameters = {
//         service: 'WFS',
//         version: '1.0.0',
//         request: 'GetFeature',
//         typeName: layer_wms,
//         outputFormat: 'application/json',

//     };
//     var parameters = L.Util.extend(defaultParameters);
//     var URL = owsrootUrl + L.Util.getParamString(parameters);
//     var markerPTN = L.markerClusterGroup({
//         showCoverageOnHover: false
//     });

//     console.log(URL);

//     var ajax = $.ajax({
//         url: URL,
//         dataType: 'json',
//         jsonpCallback: 'getJson',
//         success: function(response) {
//             var markers = L.layerGroup();
//             console.log(response.features);
//             response.features.map(function(item) {
//                 console.log(item);

//                 // var url = icon_url;

//                 // var icon = L.icon({
//                 //     iconUrl: url,
//                 //     iconSize: [35, 35],
//                 //     iconAnchor: [15, 15],
//                 //     popupAnchor: [15, 15],
//                 // });

//                 // var marker = new L.marker([item.geometry.coordinates[1], item.geometry.coordinates[
//                 //     0]], {
//                 //     'icon': icon
//                 // });

//                 // var html = ''

//                 // if (item.properties.hasOwnProperty('Ten')) {
//                 //     html += '<strong>Tên:</strong> ' + item.properties.Ten + '<br>';
//                 // } else {
//                 //     if (item.properties.hasOwnProperty('TenDoiTuong')) {
//                 //         html += '<strong>Tên:</strong> ' + item.properties.TenDoiTuong + '<br>';
//                 //     }
//                 // }

//                 // if (layer_wms == 'govap:CT_ATM' || layer_wms == 'govap:CT_PGD') {
//                 //     html += '<strong>Ngân hàng:</strong> ' + item.properties.NganHang + '<br>';
//                 // }

//                 // if (layer_wms == 'govap:DL_KhachSan') {
//                 //     html += '<strong>Tên:</strong> ' + item.properties.TenKS + '<br>';
//                 // }

//                 // if (item.properties.hasOwnProperty('PhuongXa')) {
//                 //     html += '<strong>Phường:</strong> ' + item.properties.PhuongXa + '<br>';
//                 // }

//                 // marker.bindPopup(html);
//                 // markers.addLayer(marker);
//             });

//             DATA.Refs.LeafletLayers[layer_map] = markers;
//             //DATA[DATA.MapConfig.mapId].Map.addLayer(markers);
//             DATA[DATA.MapConfig.mapId].MapControl.layercontrol.addOverlay(markers, layer_map);
//         }
//     });
// }
</script>