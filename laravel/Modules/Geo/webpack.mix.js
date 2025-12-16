const mix = require('laravel-mix');

mix.options({
    purifyCss: false,
 });

 mix.autoload({
        jquery: ['$', 'window.jQuery', 'jQuery'], // more than one
        tether: ['window.Tether', 'Tether'],
        'tether-shepherd': ['Shepherd'],
        'popper.js/dist/popper.js': ['Popper'],
        sweetalert2:['Swal'],
        'magnific-popup':['magnificPopup'],
        moment: 'moment', // only one
        axios: 'axios',
        leaflet: ['leaflet','L']
    });


// require('laravel-mix-merge-manifest');
//mix.setPublicPath('../../public').mergeManifest();

 var src=__dirname + '/Resources';
 var dest= 'resources/dist'

 mix.js(src+'/js/app.js', dest+'/js/geo.js')
    .sass(src + '/sass/app.scss', dest+'/css/geo.css')
    .setResourceRoot('../')
    .setPublicPath(dest);

 mix.vue({ version: 3 });

 mix.autoload({
        jquery: ['$', 'window.jQuery', 'jQuery'], // more than one
        moment: 'moment' // only one
        //tether: ['Tether', 'windows.Tether'],
    });

 mix.extract([
    'axios',
    'vue',
    'tether',
    'lodash',
    'popper.js',
    'jquery',
    'sweetalert2',
    'moment',
    'nouislider',
    'bootstrap',
    'video.js',
    'videojs',
 ]);


 if (mix.inProduction()) {
     mix.version();
 }
