const mix = require('laravel-mix');

mix.options({
    purifyCss: false,
});

mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery'],
    tether: ['window.Tether', 'Tether'],
    'tether-shepherd': ['Shepherd'],
    'popper.js/dist/popper.js': ['Popper'],
    sweetalert2: ['Swal'],
    'magnific-popup': ['magnificPopup'],
    moment: 'moment',
    axios: 'axios',
    leaflet: ['leaflet', 'L'],
});

var src = __dirname + '/resources';
var dest = 'resources/dist';

mix.disableNotifications();

mix.js(src + '/js/app.js', dest + '/js/geo.js')
    .setResourceRoot('../')
    .setPublicPath(dest);

mix.vue({ version: 3 });

mix.override((webpackConfig) => {
    webpackConfig.plugins = (webpackConfig.plugins || []).filter((plugin) => {
        const constructorName = plugin?.constructor?.name ?? '';
        return constructorName !== 'WebpackBarPlugin' && constructorName !== 'WebpackBar';
    });

    const path = require('path');
    webpackConfig.resolve = webpackConfig.resolve || {};
    webpackConfig.resolve.alias = {
        ...webpackConfig.resolve.alias,
        '@theme-lit': path.resolve(__dirname, 'node_modules/lit'),
        '@theme-leaflet': path.resolve(__dirname, 'node_modules/leaflet'),
        '@theme-leaflet-css': path.resolve(__dirname, 'node_modules/leaflet/dist/leaflet.css'),
    };
});

if (mix.inProduction()) {
    mix.version();
}
