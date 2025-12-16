console.log("        @ @ @\n       []___\n      /    /\\____\n(~)  /_/\\_//____/\\ \n |   | || |||__|||\n     farmshops.eu \n Interesse am Code, Bug gefunden oder eine Verbesserungsidee? Schau vorbei auf GitHub! \n https://github.com/CodeforKarlsruhe/direktvermarkter");
var mappos = L.Permalink.getMapLocation();
var map = L.map('map', {
    center: mappos.center,
    zoom: mappos.zoom,
    minZoom: 2,
    maxZoom: 18,
    zoomControl: false
});
L.Permalink.setup(map);

var tiles = L.tileLayer('https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: "&copy; <a target='_blank' href='https://www.openstreetmap.org/copyright'>OpenStreetMap</a>"
});
var Esri_WorldImagery = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
    attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
});

var OpenStreetMap_Mapnik = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
});



var farmMarker = L.ExtraMarkers.icon({
    icon: 'fa-number',
    markerColor: 'green-light',
    shape: 'square',
    prefix: 'fa',
});

var machineMarker = L.ExtraMarkers.icon({
    icon: 'fa-number',
    markerColor: 'cyan',
    shape: 'square',
    prefix: 'fa'
});

var beekeeperMarker = L.ExtraMarkers.icon({
    icon: 'fa-number',
    markerColor: 'yellow',
    shape: 'square',
    prefix: 'fa'
});

var marketMarker = L.ExtraMarkers.icon({
    icon: 'fa-number',
    markerColor: 'orange',
    shape: 'square',
    prefix: 'fa'
});

var blackMarker = L.ExtraMarkers.icon({
    icon: 'fa-number',
    markerColor: 'black',
    shape: 'circle',
    number: '?',
    prefix: 'fa'
});

var restaurantMarker = L.ExtraMarkers.icon({
    icon: 'fa-utensils',
    markerColor: 'orange',
    shape: 'circle',
    number: '?',
    prefix: 'fas'
});


//Darstellung

//Marker

var geojson1 = L.geoJson(farmshopGeoJson, {
    pointToLayer: function pointToLayer(feature, latlng)
    {
        switch (feature.properties.p) {
            case 'farm':return L.marker(latlng, { icon: farmMarker }); break;
            case 'beekeeper':return L.marker(latlng, { icon: beekeeperMarker }); break;
            case 'marketplace':return L.marker(latlng, { icon: marketMarker }); break;
            case 'vending_machine':return L.marker(latlng, { icon: machineMarker }); break;
            case 'restaurant':return L.marker(latlng, { icon: restaurantMarker }); break;
            default:
                console.log(feature.properties.p);
                return L.marker(latlng, { icon: blackMarker });
            break;
        }
    },

    onEachFeature: function onEachFeature(feature, layer)
    {
        layer.once("click", function () {
            /*
            $.getJSON('data/' + feature.properties.id + '/details.json', function (data) {
                layer.bindPopup(popupcontent(data, layer)).openPopup();
            });
            */
            var $json_url=base_url+feature.properties.url+'?format=json';
            console.log($json_url);
            $.getJSON($json_url, function (data) {
                layer.bindPopup(popupcontent(data, layer)).openPopup();
            });
        });
    }
}).addLayer(tiles);

//Changing Cluster radius based on zoom level
var GetClusterRadius = function (zoom) {
    if (zoom < 12) {
        return 80;
    } else {
        return 45;
    }
}

var markers = L.markerClusterGroup({
    iconCreateFunction: function (cluster) {
        var markers = cluster.getAllChildMarkers();

        function markerTypen(markers)
        {
            var returnWert;
            var farmsInCluster = false;
            var marketsInCluster = false;
            var machinesInCluster = false;
            var beekeepersInCluster = false;
            var restaurantInCluster = false;


            for (var c = 0; c < markers.length; c++) {
                switch (markers[c].feature.properties.p) {
                    case 'farm': farmsInCluster = true; break;
                    case 'beekeeper': beekeepersInCluster = true; break;
                    case 'marketplace': marketsInCluster = true; break;
                    case 'vending_machine':machinesInCluster = true; break;
                    case "restaurant":restaurantInCluster =true;  break;
                    default: console.log('don know ['+ $p +'] ');break;
                }
                //console.log("f " +farmsInCluster +" m " +marketsInCluster +" a " +machinesInCluster)
            }

            function farmsAreInCluster(farmsInCluster)
            {
                if (farmsInCluster) {
                    return "<img src='img/hof.png' style='height: 14px;'> "
                } else {
                    return ""
                }
            }

            function marketsAreInCluster(marketsInCluster)
            {
                if (marketsInCluster) {
                    return "<img src='img/markt.png' style='height: 14px;'> "
                } else {
                    return ""
                }
            }

            function beekeepersAreInCluster(beekeepersInCluster)
            {
                if (beekeepersInCluster) {
                    return "<img src='img/imker.png' style='height: 14px;'> "
                } else {
                    return ""
                }
            }

            function machinesAreInCluster(machinesInCluster)
            {
                if (machinesInCluster) {
                    return "<img src='img/automat.png' style='height: 14px;'> "
                } else {
                    return ""
                }
            }

            function summary()
            {
                var $summary="";
                if (restaurantInCluster) {
                    $summary+='<i class="fas fa-utensils"></i>';
                }
                return $summary;
            }

            //change cluster content based on zoom level
            if (map.getZoom() >= 8) {
                //returnWert = markers.length +"<div style='padding-top:2px;'>" +farmsAreInCluster(farmsInCluster) +marketsAreInCluster(marketsInCluster) +machinesAreInCluster (machinesInCluster) +beekeepersAreInCluster(beekeepersInCluster) +"</div>";
                returnWert = markers.length +"<div style='padding-top:2px;'>" +summary() +"</div>";
            } else {
                returnWert = "<div style='padding:8px;'>" +markers.length +"</div>";
            }

            return returnWert;
        }
        // console.log("markerS: " +markers)
        var html = '<div class="circle"><strong>' +markerTypen(markers) + '</strong></div>';
        return L.divIcon({ html: html, className: 'test', iconSize: L.point(80,80) });
    },
    spiderfyOnMaxZoom: true,
    maxClusterRadius: GetClusterRadius,
    showCoverageOnHover: true,
    zoomToBoundsOnClick: true,
    removeOutsideVisibleBounds: true,
});

markers.addLayer(geojson1);
map.addLayer(markers);
console.log(lastUpdate);

var sidebar = L.control.sidebar('sidebar').addTo(map);

var tilesAuswahl = {
    "Wikipedia Kartenstil": tiles,
    "Openstreetmap": OpenStreetMap_Mapnik,
    "Satelit": Esri_WorldImagery,
};

var overlays = {
    "Marker": markers,
};
L.control.scale({position: 'topright'}).addTo(map);

L.control.layers(tilesAuswahl,overlays).addTo(map);



L.control.zoom({
    position: 'bottomright'
}).addTo(map);


L.control.locate({
    position: 'bottomright',
    drawMarker: true,
    drawCircle: true,
    flyTo: true,
    keepCurrentZoomLevel: false,
    strings: {
        title: "Karte auf meine aktuelle Position zentrieren!"
    },
    locateOptions: {
        maxZoom: 12
    },
    clickBehavior: {
        inView: 'setView',
        outOfView: 'setView'
    }
}).addTo(map);

function popupcontent(feature, layer)
{
    console.log(feature);
    /*
    var customPopup = `
            <img class="wwone__map-infobox__thumb" src="##img_src##" />
            <div class="wwone__map-infobox__badge">##distance## Km</div>
            <div class="wwone__map-infobox__inner">
                <div class="wwone__map-infobox__inner__heading">##title##</div>
                <div class="wwone__map-infobox__inner__location">##subtitle##</div>
                <div class="wwone__map-infobox__inner__info">
                    <div class="wwone__map-infobox__inner__info__type"><i class="fa fa-cutlery" aria-hidden="true"></i> ##cuisineCat_list##</div>

                </div>
                <a class="wwone__map-infobox__inner__btn btn" href="##url##" target="_blank">View &raquo;</a>
            </div>`;
    for (var prop in feature) {
        console.log('prop :'+prop);
        customPopup=customPopup.replace('##'+prop+'##',feature[prop]);
    }
    */
    var customPopup=`
    <div class="leaflet-popup-content-wrapper">
        <div class="leaflet-popup-content" style="width: 601px;">
            <div class="popup-venue">
                <div class="image d-none d-md-block" style="background-image: url(base_url+'/it/img/photo/restaurant-1430931071372-38127bd472b8.jpg')"></div>
                    <div class="text">
                        <h6>
                            <a href="detail.html">Blue Hill</a>
                        </h6>
                        <p class="">Cupidatat excepteur non dolore laborum et quis nostrud veniam dolore deserunt. Pariatur dolore ut in elit id nulla. Irure nostrud sint deserunt enim Lorem. Do eu esse consequat mollit labore commodo officia labore voluptate sit voluptate cupidatat.
                        </p>
                        <p class="text-muted mb-1">
                            <i class="fas fa-map-marker-alt fa-fw text-dark mr-2"></i>151 Karweg Place, Waumandee, Iowa, 5508
                        </p>
                        <p class="text-muted mb-1">
                            <i class="fas fa-envelope-open fa-fw text-dark mr-2"></i>
                            <a href="mailto:biancabriggs@bluehill.com" class="text-muted">biancabriggs@bluehill.com</a>
                        </p>
                        <p class="text-muted mb-1">
                            <i class="fa fa-phone fa-fw text-dark mr-2"></i>+1 (920) 407-3975
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>`;
    return customPopup;
}
