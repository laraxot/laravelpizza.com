try {
    window.$ = window.jQuery = require('jquery');
    window.L = window.leaflet = leaflet = require('leaflet');
    require('leaflet-extra-markers');
    require('leaflet.markercluster');
    require('leaflet.locatecontrol');
    //require('leaflet-sidebar-v2');
    require('sidebar-v2/js/leaflet-sidebar.js');
    require('opening_hours');
    require('bootstrap')
} catch (e) {
    console.log(e);
}
