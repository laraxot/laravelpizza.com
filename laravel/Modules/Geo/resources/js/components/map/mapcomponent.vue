<template lang="html">
    <section class="charts-highcharts">
        <grid-block title="Map">
            <div class="-map" id="map" >
                <l-map :zoom="8" :center="[47.41322, -1.219482]" :options="{ gestureHandling: true }" ref="map">
                    <l-tile-layer url="http://{s}.tile.osm.org/{z}/{x}/{y}.png"></l-tile-layer>
                    <l-marker-cluster :options="clusterOptions">
                        <l-geo-json v-for="l in locations" :key="l.id" :geojson="l.location" :options="options"></l-geo-json>
                    </l-marker-cluster>
                </l-map>
            </div>
        </grid-block>
    </section>
</template>

<script lang="js">
import L from "leaflet";
import { LMap, LTileLayer, LMarker, LGeoJson, LPopup } from "vue2-leaflet";
import { GestureHandling } from "leaflet-gesture-handling";
import Vue2LeafletMarkercluster from 'vue2-leaflet-markercluster';
//import 'vue2-leaflet-markercluster/dist/leaflet.markercluster.js';
//import 'vue2-leaflet-markercluster/dist/leaflet.markercluster-src.js';


export default  {
    name: 'Maps',
    components: {
        LMap,
        LTileLayer,
        LMarker,
        LGeoJson,
        LPopup,
        "l-marker-cluster": Vue2LeafletMarkercluster,
    },
    data () {
        return {
            geojson: null,
            clusterOptions: { disableClusteringAtZoom: 11},
            locations: [],
            options: {
                onEachFeature: function onEachFeature(feature, layer) {
                    layer.bindPopup(feature.properties.name);
                },
            },
        };
    },

    created () {

         L.Map.addInitHook("addHandler","gestureHandling", GestureHandling);
    },
    mounted() {

            let geojson = response.data.features,
                id = 0,
                tmpLocations = [];

            for (let l of geojson) {
                tmpLocations.push({
                    id: id,
                    location: l,
                 });
                id++;
            }

            this.locations = tmpLocations;
        //});
    },
 };
</script>

<style scoped lang="scss">
@import "~leaflet.markercluster/dist/MarkerCluster.css";
@import "~leaflet.markercluster/dist/MarkerCluster.Default.css";
.charts-highcharts {
}
.-map {
    width: 100%;
    height: 800px;
}
</style>
