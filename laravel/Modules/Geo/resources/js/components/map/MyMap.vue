<template>
  <div style="height: 500px; width: 100%">
    <div style="height: 200px overflow: auto;">
      <p>First marker is placed at {{ withPopup.lat }}, {{ withPopup.lng }}</p>
      <p>Center is at {{ currentCenter }} and the zoom is: {{ currentZoom }}</p>
      <button @click="showLongText">
        Toggle long popup
      </button>
      <button @click="showMap = !showMap">
        Toggle map
      </button>
    </div>
    <l-map
      v-if="showMap"
      :zoom="zoom"
      :center="center"
      :options="mapOptions"
      style="height: 80%"
      @update:center="centerUpdate"
      @update:zoom="zoomUpdate"
    >
      <l-tile-layer
        :url="url"
        :attribution="attribution"
      />
      <l-marker :lat-lng="withPopup">
        <l-popup>
          <div @click="innerClick">
            I am a popup
            <p v-show="showParagraph">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque
              sed pretium nisl, ut sagittis sapien. Sed vel sollicitudin nisi.
              Donec finibus semper metus id malesuada.
            </p>
          </div>
        </l-popup>
      </l-marker>
      <l-marker :lat-lng="withTooltip">
        <l-tooltip :options="{ permanent: true, interactive: true }">
          <div @click="innerClick">
            I am a tooltip
            <p v-show="showParagraph">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque
              sed pretium nisl, ut sagittis sapien. Sed vel sollicitudin nisi.
              Donec finibus semper metus id malesuada.
            </p>
          </div>
        </l-tooltip>
      </l-marker>
    </l-map>
  </div>
</template>

<script>
import { latLng } from "leaflet";
//import * as L from "leaflet";
import  Vue2LeafletMarkerCluster  from "vue2-leaflet-markercluster";
//Vue.component("v-marker-cluster", Vue2LeafletMarkerCluster);
import { LMap, LTileLayer, LMarker, LPopup, LTooltip } from "vue2-leaflet"; //This will reduce the size of the bundle significantly
import * as Vue2Leaflet from 'vue2-leaflet'

export default {
  name: "MyMap",
  components: {
       // 'v-map': Vue2Leaflet.Map,  ?? L ??
      LMap, LTileLayer, LMarker, LPopup, LTooltip
  },

  data() {
    return {
      zoom: 13,
      center: latLng(47.41322, -1.219482), //[47.413220, -1.219482]
      url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
      //url: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
      attribution:
        '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
      withPopup: latLng(47.41322, -1.219482),
      withTooltip: latLng(47.41422, -1.250482),
      currentZoom: 11.5,
      currentCenter: latLng(47.41322, -1.219482),
      showParagraph: false,
      mapOptions: {
        zoomSnap: 0.5
      },
      showMap: true
    };
  },
  methods: {
    zoomUpdate(zoom) {
      this.currentZoom = zoom;
    },
    centerUpdate(center) {
      this.currentCenter = center;
    },
    showLongText() {
      this.showParagraph = !this.showParagraph;
    },
    innerClick() {
      alert("Click!");
    }
  }
};
/*
https://vue2-leaflet.netlify.com/examples/multi-map.html
https://github.com/jperelli/vue2-leaflet-markercluster/blob/master/package.json
https://github.com/webpack-contrib/css-loader/issues/253
https://tutorials.technology/solved_errors/Vue2Leaflet-vue-marker-not-displaying-on-map-and-map-not-fully-rendering.html
--con adonis --
https://pusher.com/tutorials/live-map-leaflet-vue-adonis

https://laracasts.com/discuss/channels/vue/vueleaflet-mapssparkbootstrap

-- pacchetto completo laravel da studiare ..--
https://github.com/nailfor/leaflet


https://qna.habr.com/q/697902

inludere json
let jsonData = require('./file.json')

NOTE: From NodeJS 10.x, import file from './file.json' would be possible
because of support for modules, which would allow async reading of json files
without fs

https://blog.codingblocks.com/2018/reading-json-files-in-nodejs-require-vs-fs-readfile/

*/
</script>

<style scoped>
    @import '~leaflet/dist/leaflet.css';
</style>

