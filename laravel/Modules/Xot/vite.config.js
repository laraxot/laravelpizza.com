import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    laravel({
      input: [
      'resources/css/adorable_rating.css',
      'resources/css/mobile-touch-targets.css',
      'resources/css/record-anchor-highlight.css',
      'resources/js/adorable_rating.js',
      ],
      refresh: true,
    }),
    tailwindcss(),
  ],
});
