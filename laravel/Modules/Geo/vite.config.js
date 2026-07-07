import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
<<<<<<< HEAD
import tailwindcss from '@tailwindcss/vite'
=======
import path from 'path';
>>>>>>> 40b96bcd6 (.)
import { fileURLToPath } from 'url';
import { dirname, resolve } from 'path';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

<<<<<<< HEAD
export default defineConfig({
    build: {
        emptyOutDir: false,
        manifest: "manifest.json",
        rollupOptions: {
            // Evitiamo di bundlare chart.js perché Filament lo fornisce già lato admin.
            //external: ['chart.js', 'chart.js/helpers'],
            output: {
                globals: {
                //    'chart.js': 'Chart',
                //    'chart.js/helpers': 'Chart.helpers',
                },
            },
        },
        // Opzioni rollup commentate per riferimento futuro
        /*
        rollupOptions: {
=======
const nodeModules = resolve(__dirname, '../../node_modules');

export default defineConfig({
    build: {
        outDir: './public',
        emptyOutDir: false,
        manifest: "manifest.json",
        rollupOptions: {
>>>>>>> 40b96bcd6 (.)
            output: {
                entryFileNames: `assets/[name].js`,
                chunkFileNames: `assets/[name].js`,
                assetFileNames: `assets/[name].[ext]`
<<<<<<< HEAD
            }
        }
        */
    },
    optimizeDeps: {
        // Lasciamo che chart.js venga risolto dall'istanza globale caricata da Filament.
        exclude: ['chart.js', 'chart.js/helpers'],
=======
            },
        }
    },
    resolve: {
        alias: {
            'lit': path.resolve(nodeModules, 'lit'),
            'leaflet': path.resolve(nodeModules, 'leaflet'),
            'leaflet/dist/leaflet.css': path.resolve(nodeModules, 'leaflet/dist/leaflet.css'),
            'leaflet.markercluster': path.resolve(nodeModules, 'leaflet.markercluster'),
            'leaflet.markercluster/dist/MarkerCluster.css': path.resolve(nodeModules, 'leaflet.markercluster/dist/MarkerCluster.css'),
            'leaflet.markercluster/dist/MarkerCluster.Default.css': path.resolve(nodeModules, 'leaflet.markercluster/dist/MarkerCluster.Default.css'),
            'leaflet.heat': path.resolve(nodeModules, 'leaflet.heat'),
        }
>>>>>>> 40b96bcd6 (.)
    },
    plugins: [
        laravel({
            publicDirectory: '../../../public_html',
            buildDirectory: 'assets/geo',
            input: [
<<<<<<< HEAD
                // resolve(__dirname, 'Resources/assets/sass/app.scss'), // Percorso storico, lasciato commentato per riferimento
                resolve(__dirname, 'resources/css/app.css'),
                resolve(__dirname, 'resources/js/components/coordinate-picker-lit.js'),
                resolve(__dirname, 'resources/js/components/map-picker-lit.js'),
                resolve(__dirname, 'resources/js/components/geopoint-picker-lit.js'),
                resolve(__dirname, 'resources/js/components/geo-map-lit.js'),
                resolve(__dirname, 'resources/js/components/map-lit.js')
=======
                resolve(__dirname, 'resources/css/app.css'),
                resolve(__dirname, 'resources/js/components/coordinate-picker-lit.js'),
>>>>>>> 40b96bcd6 (.)
            ],
            ...refreshPaths,
            refresh: true,
        }),
<<<<<<< HEAD
        tailwindcss(),
    ],
});

// Add geo-map-lit.js to the list of library entry points so it's bundled
import.meta.imports = {
  ...import.meta.imports,
  '/resources/js/components/geo-map-lit.js': true,
};
=======
    ],
});
>>>>>>> 40b96bcd6 (.)
