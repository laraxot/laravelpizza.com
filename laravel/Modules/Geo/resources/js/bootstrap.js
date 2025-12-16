window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    //window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    //window.L = window.leaflet = leaflet = require('leaflet');
    //require('leaflet-extra-markers');
    //require('leaflet.markercluster');
    //require('leaflet.locatecontrol');
    //require('leaflet.locatecontrol/src/L.Control.Locate.js');
    //require('leaflet.locatecontrol/dist/L.Control.Locate.min.js');
    //require('leaflet-sidebar/src/L.Control.Sidebar.js');
    //require('leaflet-sidebar-v2');
    //require('leaflet.Permalink/leaflet.permalink.js');

    //require('opening_hours');

    require('bootstrap');
} catch (e) {
}


var pub_res = '.';
//require(pub_res + '/leaflet.permalink.min.js');
//require(pub_res+'/leaflet.extra-markers.min.js');
//require(pub_res+'/leaflet.markercluster.js');
//require(pub_res+'/leaflet-sidebar.js');
//require(pub_res+'/L.Control.Locate.min.js');
//require(pub_res+'/opening_hours+deps.min.js');
//var json=$.getJSON(base_url_lang + '/restaurant?responseType=geoJson').done(function(response){
//console.log('da bootstrap');
//console.log(response);
//    var json=response;
//    require(pub_res+'/xot-markers.js')(json);
//    return json;
//});
//require(pub_res+'/popupcontent.js'); //Uncaught ReferenceError: popupcontent is not defined
//require(pub_res + '/xot-markers.js');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
