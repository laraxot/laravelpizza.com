<template>

    <div class="container">

        <div id="mapid" class="center-block" style="width: 100%; height: 400px;"></div>
    </div>
</template>

<script>
/**
 * @link http://www.learnlaravel.net/1258/adding-interactive-maps-to-laravel-with-leaflet-js-step-3-adding-markers-to-the-map-based-on-json/
 */
//import {L,Icon} from 'leaflet';
//var L = require('leaflet');
//import "leaflet/dist/leaflet.css";
import * as L from 'leaflet';
import 'leaflet-fullscreen/dist/Leaflet.fullscreen';
import 'leaflet-extra-markers';
import 'leaflet.markercluster';

export default {
    data() {
        return {
            map: null
        };
    },
    mounted() {
        //var mappos = L.Permalink.getMapLocation();
        var map = L.map('mapid').fitWorld();
        this.map = map;
        this.map.addControl(new window.L.Control.Fullscreen());
        //this.map.setView([51.505, -0.09], 13);
        /*
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(this.map);
        //*/

        var tiles = L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(this.map);

        //*

        delete L.Icon.Default.prototype._getIconUrl;
        L.Icon.Default.mergeOptions({
            iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png').default,
            iconUrl: require('leaflet/dist/images/marker-icon.png').default,
            shadowUrl: require('leaflet/dist/images/marker-shadow.png').default,
        });

        var farmMarker = L.ExtraMarkers.icon({
            icon: 'fa-number',
            markerColor: 'green-light',
            shape: 'square',
        });

        var machineMarker = L.ExtraMarkers.icon({
            icon: 'fa-number',
            markerColor: 'cyan',
            shape: 'square'
        });

        var beekeeperMarker = L.ExtraMarkers.icon({
            icon: 'fa-number',
            markerColor: 'yellow',
            shape: 'square'
        });

        var marketMarker = L.ExtraMarkers.icon({
            icon: 'fa-number',
            markerColor: 'orange',
            shape: 'square'
        });

        var blackMarker = L.ExtraMarkers.icon({
            icon: 'fa-number',
            markerColor: 'black',
            shape: 'circle',
            number: '?'
        });

        //Marker

        var geojson1 = L.geoJson(farmshopGeoJson, {
            pointToLayer: function pointToLayer(feature, latlng) {
                if (feature.properties.p === 'beekeeper') {
                    return L.marker(latlng, { icon: beekeeperMarker });
                }
                else if (feature.properties.p === 'farm') {
                    return L.marker(latlng, { icon: farmMarker });
                }
                else if (feature.properties.p === 'marketplace') {
                    return L.marker(latlng, { icon: marketMarker });
                } else if (feature.properties.p === 'vending_machine') {
                    return L.marker(latlng, { icon: machineMarker });
                } else {
                    console.log("nicht bekannte Daten verwendet");
                    return L.marker(latlng, { icon: blackMarker });
                }
            },

            onEachFeature: function onEachFeature(feature, layer) {
                layer.once("click", function () {
                    $.getJSON('data/' + feature.properties.id + '/details.json', function (data) {
                        layer.bindPopup(popupcontent(data, layer)).openPopup();
                    });
                });
            }
        }).addLayer(tiles);

        //Changing Cluster radius based on zoom level
        var GetClusterRadius = function (zoom) {
            if (zoom < 12) {
                return 80;
            }
            else {
                return 45;
            }
        }

        var markers = L.markerClusterGroup({
            iconCreateFunction: function (cluster) {
                var markers = cluster.getAllChildMarkers();

                function markerTypen(markers) {
                    var returnWert;
                    var farmsInCluster = false;
                    var marketsInCluster = false;
                    var machinesInCluster = false;
                    var beekeepersInCluster = false;


                    for (var c = 0; c < markers.length; c++) {


                        if (markers[c].feature.properties.p === "farm") {

                            farmsInCluster = true;
                        }
                        else if (markers[c].feature.properties.p === "beekeeper") {

                            beekeepersInCluster = true;
                        }
                        else if (markers[c].feature.properties.p === "marketplace") {

                            marketsInCluster = true;
                        }
                        else if (markers[c].feature.properties.p === "vending_machine") {

                            machinesInCluster = true;
                        }
                        else {
                            console.log("else schleife")

                        }

                        //console.log("f " +farmsInCluster +" m " +marketsInCluster +" a " +machinesInCluster)

                    }

                    function farmsAreInCluster(farmsInCluster) {
                        if (farmsInCluster) {
                            return "<img src='img/hof.png' style='height: 14px;'> "
                        }
                        else {
                            return ""
                        }
                    }

                    function marketsAreInCluster(marketsInCluster) {
                        if (marketsInCluster) {
                            return "<img src='img/markt.png' style='height: 14px;'> "
                        }
                        else {
                            return ""
                        }
                    }

                    function beekeepersAreInCluster(beekeepersInCluster) {
                        if (beekeepersInCluster) {
                            return "<img src='img/imker.png' style='height: 14px;'> "
                        }
                        else {
                            return ""
                        }
                    }

                    function machinesAreInCluster(machinesInCluster) {
                        if (machinesInCluster) {
                            return "<img src='img/automat.png' style='height: 14px;'> "
                        }
                        else {
                            return ""
                        }
                    }

                    //change cluster content based on zoom level
                    if (map.getZoom() >= 8) {
                        returnWert = markers.length + "<div style='padding-top:2px;'>" + farmsAreInCluster(farmsInCluster) + marketsAreInCluster(marketsInCluster) + machinesAreInCluster(machinesInCluster) + beekeepersAreInCluster(beekeepersInCluster) + "</div>";
                    }
                    else {
                        returnWert = "<div style='padding:8px;'>" + markers.length + "</div>";
                    }

                    return returnWert;
                }
                // console.log("markerS: " +markers)
                var html = '<div class="circle"><strong>' + markerTypen(markers) + '</strong></div>';
                return L.divIcon({ html: html, className: 'test', iconSize: L.point(80, 80) });
            },
            spiderfyOnMaxZoom: true,
            maxClusterRadius: GetClusterRadius,
            showCoverageOnHover: true,
            zoomToBoundsOnClick: true,
            removeOutsideVisibleBounds: true,
        });

        markers.addLayer(geojson1);
        this.map.addLayer(markers);
        console.log(lastUpdate);


        this.map.on('locationfound', (e) => {
            console.log('onLocationFound');
            var radius = e.accuracy / 2;
            console.log(this.map);
            var locationMarker = L.marker(e.latlng).addTo(this.map)
                .bindPopup('You are within ' + radius + ' meters from this point').openPopup();

            var locationCircle = L.circle(e.latlng, radius).addTo(this.map);
        });
        this.map.on('locationerror', (e) => {
            alert(e.message);
        });

        this.map.locate({ setView: true, maxZoom: 16 });

    },
    beforeDestroy() {
        if (this.map) {
            this.map.remove();
        }
    }
}
</script>

<style>
@import "~leaflet/dist/leaflet.css";
@import '~leaflet-fullscreen/dist/leaflet.fullscreen.css';
/*
    @import '~leaflet-extra-markers/src/assets/less/Leaflet.extra-markers.less';
    */
@import '~leaflet-extra-markers/src/assets/css/leaflet.extra-markers.css';

@import '~leaflet.markercluster/dist/MarkerCluster.css';
@import '~leaflet.markercluster/dist/MarkerCluster.Default.css';

.leaflet-container {
    height: 400px;
    width: 600px;
    max-width: 100%;
    max-height: 100%;
}
</style>
