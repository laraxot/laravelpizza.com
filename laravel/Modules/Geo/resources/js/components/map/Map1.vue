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


    export default {
        data() {
            return {
                map: null
            };
        },
        mounted() {
            this.map = L.map('mapid').fitWorld();
            this.map.addControl(new window.L.Control.Fullscreen());
            //this.map.setView([51.505, -0.09], 13);
            /*
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(this.map);
            //*/

            L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(this.map);

            //*

            delete L.Icon.Default.prototype._getIconUrl;
            L.Icon.Default.mergeOptions({
                iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png').default,
                iconUrl: require('leaflet/dist/images/marker-icon.png').default,
                shadowUrl: require('leaflet/dist/images/marker-shadow.png').default,
            });
            //*/
            /*
            L.marker([51.5, -0.09]).addTo(this.map)
                .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
                .openPopup();
            */

            this.map.on('locationfound', (e)=>{
                console.log('onLocationFound');
                var radius = e.accuracy / 2;
                console.log(this.map);
                var locationMarker = L.marker(e.latlng).addTo(this.map)
                    .bindPopup('You are within ' + radius + ' meters from this point').openPopup();

                var locationCircle = L.circle(e.latlng, radius).addTo(this.map);
            });
            this.map.on('locationerror', (e)=>{
                alert(e.message);
            });

            this.map.locate({setView: true, maxZoom: 16});

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

    .leaflet-container {
			height: 400px;
			width: 600px;
			max-width: 100%;
			max-height: 100%;
		}
</style>
