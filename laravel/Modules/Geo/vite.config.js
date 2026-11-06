import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import path from 'path';
import { fileURLToPath } from 'url';
import { dirname, resolve } from 'path';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

const nodeModules = resolve(__dirname, '../../node_modules');

export default defineConfig({
    build: {
        // `outDir` DEVE coincidere con `publicDirectory` + `buildDirectory` del
        // plugin Laravel qui sotto (`../../../public_html` + `assets/geo`).
        //
        // Era `./public`: la property top-level `build.outDir` HA PREVALENZA su
        // quella calcolata dal plugin, quindi l'output finiva in
        // `Modules/Geo/public/`. Laravel cercava e non trovava
        // `public_html/assets/geo/manifest.json`, e lanciava
        // ViteManifestNotFoundException: la home in italiano (/it) rispondeva 500
        // mentre /en rispondeva 200, perche' solo /it usa gli asset Geo.
        //
        // Le due righe non possono stare in disaccordo: o allinei `outDir` qui, o
        // lo togli e lasci che sia il plugin a calcolarlo. Il rollupOptions sotto
        // tiene la nomenclatura `assets/[name].js` per i chunk.
        outDir: '../../../public_html/assets/geo',
        emptyOutDir: false,
        manifest: "manifest.json",
        rollupOptions: {
            output: {
                entryFileNames: `assets/[name].js`,
                chunkFileNames: `assets/[name].js`,
                assetFileNames: `assets/[name].[ext]`
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
    },
    plugins: [
        laravel({
            publicDirectory: '../../../public_html',
            buildDirectory: 'assets/geo',
            input: [
                resolve(__dirname, 'resources/css/app.css'),
                resolve(__dirname, 'resources/js/components/coordinate-picker-lit.js'),
            ],
            ...refreshPaths,
            refresh: true,
        }),
    ],
});