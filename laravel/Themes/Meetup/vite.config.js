import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

import path from 'path';

export default defineConfig({
    // URL pubblico dei file compilati (npm run copy li mette in public_html/themes/Meetup):
    // senza, font e immagini importati dal CSS puntavano a /build/assets/ (404).
    base: '/themes/Meetup/',
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,

        }),
        tailwindcss(),
    ],
    build: {
        outDir: './public',
        emptyOutDir: false,
        manifest: 'manifest.json',
        /*
        rollupOptions: {
            input: [
                path.resolve(__dirname, 'resources/css/app.css'),
                path.resolve(__dirname, 'resources/js/app.js'),
            ],
        },
        */
    },
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
});
