<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import L from "leaflet";
import "leaflet-measure-ext";
import "leaflet-fullscreen";
import "leaflet.locatecontrol";
import "leaflet-routing-machine"
import "leaflet-control-geocoder"
import "~/leaflet/leaflet.snogylop.js";
import { measureOptions } from "~/leaflet/config.js";
import { replaceProperties } from "~/utils/formatUtil.js";
import "~/leaflet/L.legend.js";
import "~/leaflet/L.customWMS.js";
import "~/leaflet/L.TileLayer.BetterWMS.js";
import "~/leaflet/3dControl.js";
import ModalInfo from "./ModalInfo.vue";
import { GeoSearchControl } from 'leaflet-geosearch';
import IOTLinkProvider from '~/leaflet/IOTLinkProvider'
import markerIconRetina from 'leaflet/dist/images/marker-icon-2x.png';
import markerIcon from 'leaflet/dist/images/marker-icon.png';
import markerShadow from 'leaflet/dist/images/marker-shadow.png';

delete L.Icon.Default.prototype._getIconUrl;

L.Icon.Default.mergeOptions({
    iconRetinaUrl: markerIconRetina,
    iconUrl: markerIcon,
    shadowUrl: markerShadow,
});

const modalUrl = ref("");
let mapConfig = {};
let map2d;
let map3d;

function initMap() {
    init2DMap();
    init3DMap();
}

function init3DMap() {
    document.getElementById("map3d").classList.add('d-none')
    let options = {
        center: { lat: 10.800932, lng: 106.626434 },
        zoom: 15,
        controls: true,
        geolocate: true,
        mapType: 'map3d',
        controlOptions: map4d.ControlOptions.TOP_LEFT

    }
    map3d = new map4d.Map(document.getElementById("map3d"), options)
    const a2d = document.createElement("a");
    a2d.id = "btn-2d";
    const btn2d = document.createElement("div")
    btn2d.classList.add("mf-button");
    btn2d.appendChild(a2d)
    document.querySelector('.mf-ui .horizontal').append(btn2d)
    document.getElementById('btn-2d').addEventListener('click', open2DMap)
}

function init2DMap() {
    map2d = L.map("map2d", {
        center: [10.240095, 106.373147],
        zoom: 10,
        minZoom: 10,
        attributionControl: false,
        fullscreenControl: true,
    });
    L.control.measure(measureOptions).addTo(map2d);
    L.control.locate().addTo(map2d);

    L.control
        .legend({
            content: APP.legend,
        })
        .addTo(map2d);

    // 3D control
    L.control.btn3D({ position: 'topleft', onClick: open3DMap }).addTo(map2d)
}

function open2DMap() {
    console.log('open2DMap');
    document.getElementById("map3d").classList.add('d-none')
    document.getElementById("map2d").classList.remove('d-none')

    const center = map3d.getBounds().getCenter();
    const zoom = Math.round(map3d.getCamera().getZoom());
    map2d.setView([center.lat, center.lng], zoom)
    map2d.invalidateSize();
}

function open3DMap() {
    console.log('open3DMap');
    document.getElementById("map2d").classList.add('d-none')
    document.getElementById("map3d").classList.remove('d-none')

    if (map2d.isFullscreen()) {
        map2d.toggleFullscreen()
    }
    const center = map2d.getCenter();
    map3d.panTo({ lat: center.lat, lng: center.lng },)
}

function initSearchControl(map) {
    const search = new GeoSearchControl({
        provider: new IOTLinkProvider({
            params: {
                key: '00bce8de3dd66297983f247199e18d6b',
                location: '10.292281,106.289777',
            }
        }),
        style: 'bar',
        searchLabel: 'Nhập địa chỉ cần tìm',
        popupFormat: ({ query, result }) => result.label + '<div><a href="#">Chỉ đường</div>',
    });
    map.addControl(search);

}



function initLayerControl(map, bounds, setting) {
    let baseMaps = {}
    mapConfig.baseLayers.forEach(({ url, name, active }) => {
        const layer = L.tileLayer(url)
        baseMaps[name] = layer
        if (active) layer.addTo(map)
    })


    let cqlFilter = '1=1'
    if (setting.maquan) {
        cqlFilter = `maquan=${setting.maquan}`
    }

    let overlayMaps = {}
    mapConfig.overlayLayers.forEach(item => {
        const { id, name, wmsUrl, type, active, options, getFeatureInfoOptions } = item
        let layer;
        if (id) {
            if (id == 'dientich-thuhoach-layer') {
                layer = createDientichThuhoachLayer(map, setting.maquan)
            }
        } else {
            let extraOptions = {}
            if (getFeatureInfoOptions) {
                const { url, actions } = getFeatureInfoOptions
                extraOptions.onGetFeatureInfo = (latlng, featureInfo) =>
                    showPopup({
                        map,
                        url,
                        latlng,
                        featureInfo,
                        actions
                    })
            }
            layer = L.tileLayer[type](wmsUrl, { ...options, cql_filter: cqlFilter }, extraOptions)
        }
        if (active) layer.addTo(map)

        overlayMaps[name] = layer
    })
    // let overlayMaps = {
    //     "Ranh quận huyện": L.tileLayer.wms("/geogis/nongnghiep/wms", {
    //         layers: "nongnghiep:hc_quan",
    //     }),
    //     "Ranh phường xã": L.tileLayer
    //         .wms("/geogis/nongnghiep/wms", {
    //             layers: "nongnghiep:hc_phuong",
    //             zIndex: 100,
    //             cql_filter: cqlFilter
    //         })
    //         .addTo(map),
    //     "Nông hộ": L.tileLayer.betterWms(
    //         "/geogis/nongnghiep/wms",
    //         {
    //             layers: "nongnghiep:v_nongho",
    //             zIndex: 50,
    //             cql_filter: cqlFilter
    //         },
    //         {
    //             onGetFeatureInfo: (latlng, featureInfo) =>
    //                 showPopup({
    //                     map,
    //                     url: `/map/nongho/popup?id={nongho_id}`,
    //                     latlng,
    //                     featureInfo,
    //                     actions: [
    //                         {
    //                             type: "modal",
    //                             title: "Chi tiết",
    //                             url: "/map/nongho/modal?id={nongho_id}",
    //                         },
    //                         {
    //                             type: "link",
    //                             title: "Liên kết",
    //                             url: "/caytrong/nongho/view?id={nongho_id}",
    //                         },
    //                     ],
    //                 }),
    //         }
    //     ).addTo(map),
    //     'Tổng diện tích': createDientichThuhoachLayer(map, setting.maquan),
    //     "KD thuốc BVTV": L.tileLayer.betterWms(
    //         "/geogis/nongnghiep/wms",
    //         {
    //             layers: "nongnghiep:kd_thuoc_bvtv",
    //             zIndex: 60,
    //             cql_filter: cqlFilter
    //         },
    //         {
    //             onGetFeatureInfo: (latlng, featureInfo) =>
    //                 showPopup({
    //                     map,
    //                     url: "/map/kd-thuoc-bvtv/popup?id={id}",
    //                     latlng,
    //                     featureInfo,
    //                     actions: [
    //                         {
    //                             type: "link",
    //                             title: "Liên kết",
    //                             url: "/caytrong/kd-thuoc-bvtv/view?id={id}",
    //                         },
    //                     ],
    //                 }),
    //         }
    //     ),
    //     "KD nông sản": L.tileLayer.betterWms(
    //         "/geogis/nongnghiep/wms",
    //         {
    //             layers: "nongnghiep:kd_nongsan",
    //             zIndex: 70,
    //             cql_filter: cqlFilter
    //         },
    //         {
    //             onGetFeatureInfo: (latlng, featureInfo) =>
    //                 showPopup({
    //                     map,
    //                     url: "/map/kd-nongsan/popup?id={id}",
    //                     latlng,
    //                     featureInfo,
    //                     actions: [
    //                         {
    //                             type: "link",
    //                             title: "Liên kết",
    //                             url: "/caytrong/kd-nongsan/view?id={id}",
    //                         },
    //                     ],
    //                 }),
    //         }
    //     ),
    //     "Cơ sở nuôi cá lồng bè": L.tileLayer
    //         .betterWms(
    //             "/geogis/nongnghiep/wms",
    //             {
    //                 layers: "nongnghiep:v_coso_nuoicalongbe",
    //                 zIndex: 75,
    //                 cql_filter: cqlFilter
    //             },
    //             {
    //                 onGetFeatureInfo: (latlng, featureInfo) =>
    //                     showPopup({
    //                         map,
    //                         url: "/map/coso-nuoicalongbe/popup?id={coso_nuoicalongbe_id}",
    //                         latlng,
    //                         featureInfo,
    //                         actions: [
    //                             {
    //                                 type: "link",
    //                                 title: "Liên kết",
    //                                 url: "/thuysan/coso-nuoicalongbe/view?id={coso_nuoicalongbe_id}",
    //                             },
    //                         ],
    //                     }),
    //             }
    //         )
    //         .addTo(map),
    //     "Cơ sở nuôi cá tra": L.tileLayer
    //         .betterWms(
    //             "/geogis/nongnghiep/wms",
    //             {
    //                 layers: "nongnghiep:v_coso_nuoicatra",
    //                 zIndex: 75,
    //                 cql_filter: cqlFilter
    //             },
    //             {
    //                 onGetFeatureInfo: (latlng, featureInfo) =>
    //                     showPopup({
    //                         map,
    //                         url: "/map/coso-nuoicatra/popup?id={coso_nuoicatra_id}",
    //                         latlng,
    //                         featureInfo,
    //                         actions: [
    //                             {
    //                                 type: "link",
    //                                 title: "Liên kết",
    //                                 url: "/thuysan/coso-nuoicatra/view?id={coso_nuoicatra_id}",
    //                             },
    //                         ],
    //                     }),
    //             }
    //         )
    //         .addTo(map),
    //     "Trang trại chăn nuôi heo": L.tileLayer
    //         .betterWms(
    //             "/geogis/nongnghiep/wms",
    //             {
    //                 layers: "nongnghiep:v_coso_nuoiheo",
    //                 zIndex: 75,
    //                 cql_filter: cqlFilter
    //             },
    //             {
    //                 onGetFeatureInfo: (latlng, featureInfo) =>
    //                     showPopup({
    //                         map,
    //                         url: "/map/coso-nuoiheo/popup?id={coso_nuoiheo_id}",
    //                         latlng,
    //                         featureInfo,
    //                         actions: [
    //                             {
    //                                 type: "link",
    //                                 title: "Liên kết",
    //                                 url: "/channuoi/coso-nuoiheo/view?id={coso_nuoiheo_id}",
    //                             },
    //                         ],
    //                     }),
    //             }
    //         )
    //         .addTo(map),
    //     "Ranh thửa đất": L.tileLayer
    //         .wms("/geogis/nongnghiep/wms", {
    //             layers: "nongnghiep:v_ranhthua",
    //             zIndex: 40,
    //             cql_filter: cqlFilter
    //         })
    //         .addTo(map),
    //     "Thửa đất": L.tileLayer.betterWms(
    //         "/geogis/nongnghiep/wms",
    //         {
    //             layers: "nongnghiep:v_ranhthua",
    //             styles: "v_thuadat",
    //             zIndex: 30,
    //             cql_filter: cqlFilter
    //         },
    //         {
    //             onGetFeatureInfo: (latlng, featureInfo) =>
    //                 showPopup({
    //                     map,
    //                     url: "/map/thuadat/popup?id={id}",
    //                     latlng,
    //                     featureInfo,
    //                     actions: [
    //                         {
    //                             type: "link",
    //                             title: "Liên kết",
    //                             url: "/caytrong/pg-ranhthua/view?id={id}",
    //                         },
    //                     ],
    //                 }),
    //         }
    //     ),
    // };

    if (setting.maquan != null) {
        delete overlayMaps['Ranh quận huyện'];

    }

    L.control.layers(baseMaps, overlayMaps, { autoZIndex: false, position: 'topleft' }).addTo(map);
}

function createDientichThuhoachLayer(map, maquan) {
    const layerGroup = L.layerGroup().addTo(map);
    const layer = L.geoJSON(null, {
        style: ({ properties }) => {
            const style = {
                color: 'white',
                weight: 1,
                fillOpacity: 1,

            }

            for (const color of mapConfig.tongdientichColors) {
                if (properties.dientich > color.dientich) return { ...style, fillColor: color.fillColor }
            }

            return { ...style, fillColor: '#C8E6C9' }
        },
        onEachFeature: function (feature, layer) {
            const center = layer.getBounds().getCenter();
            const { dientich, hanhchinh } = feature.properties
            var textMarker = L.marker(center, {
                icon: L.divIcon({
                    iconSize: [200, 10],
                    className: 'd-flex flex-column align-items-center',
                    html: `<div class="fw-bolder ">${hanhchinh}</div> 
                    <div ><span class="text-warning fw-bold ">${dientich}</span> (ha)</div>`
                })
            });
            textMarker.addTo(layerGroup)
        }
    }).addTo(layerGroup)

    let url = `/map/nongho/dientich?maquan=`
    if (maquan) {
        url += `${maquan}`
    }
    fetch(url).then(response => response.json())
        .then(geojson => layer.addData(geojson))

    return layerGroup
}

function initOverlapLayer(map) {
    L.geoJSON(JSON.parse(APP.bounds), {
        invert: true,
        renderer: L.svg({ padding: 1 }),
        style: {
            color: "white",
            fillOpacity: 1,
        },
    }).addTo(map);
}

function initRoutingControl(map) {
    window.Routing = L.Routing.control({
        waypoints: [
            L.latLng(10.240095, 106.373147),
            L.latLng(10.340095, 106.373147)
        ],
        routeWhileDragging: true,
        geocoder: L.Control.Geocoder.nominatim(),
    }).addTo(map);

}

async function showPopup({ map, url, latlng, featureInfo, actions = [] }) {
    if (featureInfo?.features?.length == 0) return;
    const properties = featureInfo.features[0].properties;
    url = replaceProperties(url, properties);

    try {
        const { data } = await axios.get(url);
        let content = data.toString();
        actions.forEach(({ type, title, url }) => {
            url = replaceProperties(url, properties);
            if (type == "modal") {
                modalUrl.value = url;
                content += `<a href="#" data-bs-target="#modalInfo" data-bs-toggle="modal" class="me-2">${title}</a>`;
            } else if (type == "link") {
                content += `<a href="${url}" target="_blank">${title}</a>`;
            } else {
                console.log(`${type} is not supported`);
            }
        });
        L.popup({ maxWidth: 500, minWidth: 300 })
            .setLatLng(latlng)
            .setContent(content)
            .openOn(map);
    } catch (error) {
        console.error(error.message);
    }
}

async function loadMapConfig() {
    const headers = {
        'Cache-Control': 'no-cache'
    }
    const response = await fetch('/map/default/config', { headers })
    mapConfig = await response.json()
}

onMounted(async () => {
    await loadMapConfig()
    const bounds = L.geoJSON(JSON.parse(APP.bounds)).getBounds();
    const setting = JSON.parse(APP.settingPhamvi);
    initMap();
    initLayerControl(map2d, bounds, setting);
    // initOverlapLayer(map);
    map2d.fitBounds(bounds);
    initSearchControl(map2d)
    // initRoutingControl(map2d)
});
</script>

<template>
    <div id="map2d" class="block block-rounded mb-0"></div>
    <div id="map3d" class="block block-rounded mb-0 d-none"></div>
    <ModalInfo :url="modalUrl"> </ModalInfo>
</template>

<style lang="scss">
@import "leaflet/dist/leaflet.css";
@import "leaflet-measure-ext/dist/leaflet-measure.css";
@import "leaflet-fullscreen/dist/leaflet.fullscreen.css";
@import "leaflet.locatecontrol/dist/L.Control.Locate.min.css";
@import 'leaflet-geosearch/dist/geosearch.css';
@import 'leaflet-routing-machine/dist/leaflet-routing-machine.css';

// Core
#map2d,
#map3d {
    height: calc(100vh - 4.25rem - 2rem - 2rem);
    width: 100%;
}

#btn-3d {
    background-size: contain;
    background-image: url(data:image/png;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAYEBQYFBAYGBQYHBwYIChAKCgkJChQODwwQFxQYGBcUFhYaHSUfGhsjHBYWICwgIyYnKSopGR8tMC0oMCUoKSgBBwcHCggKEwoKEygaFhooKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKP/AABEIAB0AHQMBEQACEQEDEQH/xAGiAAABBQEBAQEBAQAAAAAAAAAAAQIDBAUGBwgJCgsQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29/j5+gEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoLEQACAQIEBAMEBwUEBAABAncAAQIDEQQFITEGEkFRB2FxEyIygQgUQpGhscEJIzNS8BVictEKFiQ04SXxFxgZGiYnKCkqNTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqCg4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2dri4+Tl5ufo6ery8/T19vf4+fr/2gAMAwEAAhEDEQA/APqmgAoAKAPAP21f+SWaV/2Gov8A0RPQB75ceb5En2cIZtp2CQkLuxxnHOKAPPpNX1/TJdVtr3U4bmaGwNwGMCxGKT0QEDzF/wBrBH0rSyZN2T2l94g08aDe3uqx6haajLFDJC1ssRjMgGCCvXH+R6Kydw1PPf21f+SWaV/2Gov/AERPUFHvd1D9otpYS8kfmKV3xttZcjqD2NAHHnwVc3PmtqmtzXsotmtbd3hC+UGGCTg/Ofcmr5uyFYlsPCN4txpx1XXJL2009leC3W2WIBlxtJIJzjHehy7ILHl/7av/ACSzSv8AsNRf+iJ6gYf8NV+B/wDoFeJP/AeD/wCPUAH/AA1X4H/6BXiT/wAB4P8A49QAf8NV+B/+gV4k/wDAeD/49QB5f+0L8a/DnxH8F2WkaHZavBcw6gl2zXkUaoUWORSAVkY5y47etAH/2Q==);
}

#btn-2d {
    background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADoAAAA6CAYAAADhu0ooAAAACXBIWXMAABYlAAAWJQFJUiTwAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAALcSURBVHgB7ZpBaxNBFIBfREg82C7S2IaKpl6kPVTjwVoPDYa2oJiCW3qwqAfFk7/Fm1cjFOmhYA5FLxZaUGiJHmI9GLwolpYktNBtekhyaudNSNlNJrvJm00P0/lgSbLsTObbmffebEjgiAFngHNwRtCiqqFFVUOLqoYWVQ0tqhpaVDW0qGpoUdU4D5JUqlXIF/bAOijxz6FQECL9YTB6L7q2W8/85G1FXGB9GEYPDF0bhFAwCH5AFsVBbrDBrn9nA640Dzg2OgyJ+N2Wwhs/smBZh+DF8I3r8HA67nnjvAhQfjPC2Vtc+gT54p7rdUZvD7x8Pisc5Ju379sSrZOYGIP77KBCitHFpc+ekgjekPTyF/CD1a8ZWGMHFdLSfZychNSHNF+yOGvmzCSPy32rBGvfMpD78/fk2n//d9ixzeLtimufuNTNmSneZ764C9lfOchu5hzXoGyUxa1XXyJIMxoZCMOLpyb/wtevnvBXnoTY+fm5R/y9HZRtF2yL/ZnJKeFSpc4qubxw2WdmkxSCCcSOZZWAAsYlZl47GDKtsrUbXamj5bJzIFgqqMRujjg+86Vd2IVO6YpooegcSOOsdMLQ1ea2+wftZ+s6votiDFm2gWCyoiSPOqLQoISCr6JYTlYbkkUiTq99iEiUgm+iKPlu4aPjXJTNJJYNqX4Fs0eR90UUsyDulBqX7CwrEbKI4vESIblJi6Jkis1k404J66lhyO1Pkezm76ZzA5fD0ClSoq0kH0xPsDrbB7JgOOAOyU6kv490A6WeXkSSuJu5d+cWyIK7KdE+eXwsBhRIoq0kMS4xeaSXV06eT+tg4XdLTDWxldr7rW3hkw3OJjW5kURTC2nh00ttqYlrXNSjlrq1RfAmzs8lgQpJtFytwGkyzkIB970yNVX6p5RugHvj2o5qEG6PjviSvQP6XymKoUVVQ4uqhhZVDS2qGlpUNbSoamhR1dCiqqFFVeMYfD4SpVZLd6IAAAAASUVORK5CYII=);
}

.content {
    padding: 1rem !important;
}

.pop-body {
    max-height: 400px;
    overflow: auto;
}

// Messure
.leaflet-control-measure {
    h3 {
        font-size: 1.17rem !important;
    }
}

// Custom leaflet
.leaflet-popup-content {
    font-family: var(--bs-body-font-family);
    font-size: var(--bs-body-font-size);
    line-height: var(--bs-body-line-height);
}
</style>
