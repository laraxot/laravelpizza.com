import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/ark.css',
                'resources/css/minty.css',
                'resources/css/sunny.css'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
