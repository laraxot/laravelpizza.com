import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            // Il modulo non ha attualmente asset sorgente (resources/css, resources/js, resources/assets).
            input: [],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
