<template>
    <div class="mapPane">
        <l-map
            :zoom="zoom"
            :center="center"
            :preferCanvas="true"
        >
            <l-control-scale
                position="bottomleft"
                :imperial="false"
                :metric="true"
            ></l-control-scale>

            <l-tile-layer
                :name="tileProvider.name"
                :visible="tileProvider.visible"
                :url="tileProvider.url"
                :attribution="tileProvider.attribution"
            ></l-tile-layer>

            <Vue2LeafletMarkerCluster :options="clusterOptions" >
                <LMarker v-for="anken in ankens" :key="anken.no" :lat-lng="makeLatLng(anken)" @click="onMarkerClick(anken.no)">
                    <LPopup :content="makeMarkerContent(anken)" ></LPopup>
                </LMarker>
            </Vue2LeafletMarkerCluster>
        </l-map>
    </div>
</template>

<script>
    import { latLng, icon, Icon } from 'leaflet'
    import {
        LMap,
        LTileLayer,
        LControlScale,
        LMarker,
        LPopup
    } from 'vue2-leaflet';
    import Vue2LeafletMarkerCluster from 'vue2-leaflet-markercluster'

    export default {
        name: 'MapPane',
        components: {
            LMap,
            LTileLayer,
            LControlScale,
            LMarker,
            LPopup,
            Vue2LeafletMarkerCluster
        },
        data() {
            return {
                center:[34.976564, 138.383789],
                zoom:10,
                tileProvider:{
                    name: 'OpenStreetMap',
                    visible: true,
                    url: 'https://tile.openstreetmap.jp/{z}/{x}/{y}.png',
                    attribution: "map data © OpenStreetMap contributors"
                },
                clusterOptions:{
                    disableClusteringAtZoom: 15
                },
                markerContent:{
                    "date":"",
                    "firm":"",
                    "links":[]
                }
            }
        },
        props: {
            ankens:Array
        },
        methods: {
            makeLatLng: function(anken) {
                return latLng(anken.lat, anken.lon)
            },
            makeMarkerContent: function(anken) {
                let date = this.markerContent.date
                let firm = this.markerContent.firm
                let anchor = "<a href='https://pointcloud.pref.shizuoka.jp/lasmap/ankendetail?ankenno=" + anken.no + "'>" + anken.name + "</a>"
                let links = ""
                for (let key in this.markerContent.links) {
                    let link = this.markerContent.links[key]
                    links = links + "<li><a href='" + link + "'>" + anken.no + "-" + String(Number(key) + 1) + ".las</a></lin>"
                }


                let content = "<h6>" + anchor + "</h6>" +
                    "<table>" +
                        "<tr><td>データ取得日</td><td>" + date + "</td></tr>" +
                        "<tr><td>請負業者</td><td>" + firm + "</td></tr>" +
                    "</table>" +
                    "<div>" +
                        "<span>データ一覧</span>" +
                        links +
                    "</div>"

                return content
            },
            onMarkerClick: function(ankenNo) {
                let vm = this
                vm.markerContent = {
                    "date":"",
                    "firm":"",
                    "links":[]
                }
                fetch("/ankenDetail/" + ankenNo)
                .then(response => {
                    return response.json()
                })
                .then(data => {
                    vm.markerContent.date = data.date
                    vm.markerContent.firm = data.firm
                    vm.markerContent.links = data.links
                })
                .catch(error => {
                    console.log(error)
                    alert("エラーが発生しました。")
                });
            }
        },
    }
</script>

<style scoped>
    @import "~leaflet.markercluster/dist/MarkerCluster.css";
    @import "~leaflet.markercluster/dist/MarkerCluster.Default.css";
    .mapPane {
        border: 1px solid #000000;
        height: 500px;
        margin: 0;
        text-align: left;
    }
</style>
