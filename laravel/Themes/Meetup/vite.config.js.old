import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import { resolve } from 'path';

export default defineConfig({
    root: resolve(__dirname, 'resources/html'),
    plugins: [
        tailwindcss(),
    ],
    build: {
        outDir: resolve(__dirname, 'resources/html/dist'),
        emptyOutDir: true,
        manifest: false,
        rollupOptions: {
            input: {
                main: resolve(__dirname, 'resources/html/index.html'),
            },
            output: {
                entryFileNames: 'js/[name].js',
                chunkFileNames: 'js/[name].js',
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name && assetInfo.name.endsWith('.css')) {
                        return 'css/[name].[ext]';
                    }
                    return 'assets/[name].[ext]';
                }
            }
        }
    },
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources'),
        },
    },
    server: {
        cors: true,
        port: 5173,
        open: true,
    },
    publicDir: 'public',
});
