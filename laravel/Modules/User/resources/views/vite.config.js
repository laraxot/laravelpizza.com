import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    build: {
        //outDir: '../../../public_html/build/ewall',
        outDir: __dirname + '/resources/dist',
        emptyOutDir: false,
        manifest: 'manifest.json',
        //rollupOptions: {
        //    output: {
        //        entryFileNames: 'assets/[name].js',
        //        chunkFileNames: 'assets/[name].js',
        //        assetFileNames: 'assets/[name].[ext]'
        //    }
        //}
    },
    ssr: {
        noExternal: ['chart.js/**']
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        //tailwindcss(),
    ],
    server: {
        cors: true,
    },
});
