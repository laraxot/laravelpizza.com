import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import { fileURLToPath } from 'url';
import { dirname, resolve } from 'path';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

// Dipendenze del modulo stesso (package.json di Geo): la build non richiede `npm install` nella root di laravel.
const nodeModules = resolve(__dirname, 'node_modules');

export default defineConfig({
    build: {
        // La build va nella cartella `public/` del modulo, servita da `public_html/assets/geo` tramite
        // symlink (`php artisan xot:module-link`): niente copie in public_html. Laravel legge
        // `public_html/assets/geo/manifest.json` attraverso il link. Senza il link la home in italiano
        // (/it, che usa gli asset Geo) rispondeva 500 con ViteManifestNotFoundException.
        // Gli asset compilati sono versionati: il server di produzione non compila.
        outDir: resolve(__dirname, 'public'),
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
            refresh: true,
        }),
    ],
});