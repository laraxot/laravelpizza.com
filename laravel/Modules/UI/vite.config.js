import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    laravel({
      input: [
      'resources/assets/sass/app.scss',
      'resources/assets/js/app.js',
      ],
      refresh: true,
    }),
    tailwindcss(),
  ],
});
