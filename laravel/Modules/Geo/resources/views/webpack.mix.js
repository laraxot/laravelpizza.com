let mix = require('laravel-mix');

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
        leaflet: ['leaflet','L']
    });

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

//https://statamic.com/marketplace/addons/laravel-mix

 var dest = 'dist';
 mix
    .js('resources/js/app.js', dest+'/js')
    .sass('resources/sass/app.scss', dest+'/css',{ outputStyle: 'expanded' })
    .setResourceRoot('../')
    .setPublicPath(dest)
 ;
