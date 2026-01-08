# Creazione di un Tema con Vue

## Introduzione

Questa guida descrive come creare un nuovo tema per il CMS utilizzando Vue.js come framework frontend. Il tema utilizza una combinazione di tecnologie moderne tra cui Flowbite, Tailwind CSS, Vue.js e Laravel.

## Prerequisiti

1. Node.js e npm installati
2. Accesso alla directory dei temi
3. Conoscenza base di Vite e Tailwind CSS
4. PHP 8.1+
5. Laravel v10.0+
6. Vue 3.0+
7. Flowbite v2.0+

## Passo 1: Installazione e Configurazione Base

```bash
# Installare il pacchetto Flowbite Laravel
composer require flowbite/flowbite-laravel

# Installare Vue e dipendenze
npm install vue@next @vitejs/plugin-vue

# Pubblicare le migrazioni
php artisan vendor:publish --tag="flowbite-laravel-migrations"
php artisan migrate

# Pubblicare il file di configurazione
php artisan vendor:publish --tag="flowbite-laravel-config"

# Pubblicare le viste
php artisan vendor:publish --tag="flowbite-laravel-views"
```

## Passo 2: Configurazione di Vite e Vue

```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
        },
    },
});
```

## Passo 3: Configurazione di Flowbite e Tailwind

```javascript
// tailwind.config.js
import preset from './vendor/filament/support/tailwind.config.preset'

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    content: [
        "./index.html",
        "./src/**/*.{vue,js,ts,jsx,tsx}",
        "./node_modules/flowbite/**/*.js",
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/flowbite/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('flowbite/plugin'),
    ],
}
```

## Passo 4: Componenti Vue con Flowbite

```vue
<!-- resources/js/Components/Button.vue -->
<template>
    <button
        :class="[
            'px-4 py-2 rounded-lg transition-colors',
            variant === 'primary' ? 'bg-primary-600 text-white hover:bg-primary-700' : '',
            variant === 'secondary' ? 'bg-secondary-600 text-white hover:bg-secondary-700' : '',
            size === 'sm' ? 'text-sm' : size === 'lg' ? 'text-lg' : '',
        ]"
        @click="$emit('click')"
    >
        <slot />
    </button>
</template>

<script setup lang="ts">
defineProps<{
    variant?: 'primary' | 'secondary'
    size?: 'sm' | 'md' | 'lg'
}>()

defineEmits<{
    (e: 'click'): void
}>()
</script>
```

## Passo 5: Layout Base con Vue

```vue
<!-- resources/js/Layouts/AppLayout.vue -->
<template>
    <div class="min-h-screen bg-gray-100">
        <Navbar />
        
        <div class="flex">
            <Sidebar />
            
            <main class="flex-1 p-6">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup lang="ts">
import Navbar from '@/Components/Navbar.vue'
import Sidebar from '@/Components/Sidebar.vue'
</script>
```

## Passo 6: Struttura Directory

```
resources/
├── js/
│   ├── Components/
│   │   ├── Button.vue
│   │   ├── Card.vue
│   │   └── Navbar.vue
│   ├── Layouts/
│   │   └── AppLayout.vue
│   ├── Pages/
│   │   ├── Dashboard/
│   │   ├── Blog/
│   │   └── Portfolio/
│   └── app.js
└── views/
    └── pages/
        ├── auth/
        ├── dashboard/
        ├── genesis/
        ├── learn/
        ├── profile/
        └── index.blade.php
```

## Passo 7: Deployment e Manutenzione

1. **Build del Tema**
```bash
npm run build
```

2. **Verifica della Build**
```bash
npm run preview
```

3. **Copiatura degli Asset**
```bash
npm run copy
```

## Troubleshooting

### Problemi Comuni

1. **Errori di Build**
   - Verificare le versioni delle dipendenze
   - Controllare la configurazione di Vite
   - Assicurarsi che tutti i file necessari siano presenti

2. **Problemi di Stile**
   - Verificare la configurazione di Tailwind
   - Controllare l'ordine degli import CSS
   - Assicurarsi che i plugin siano configurati correttamente

3. **Errori di TypeScript**
   - Verificare la configurazione di TypeScript
   - Aggiornare le definizioni dei tipi
   - Controllare la compatibilità delle versioni

## Risorse Utili

- [Documentazione Vue 3](https://vuejs.org/guide/introduction.html)
- [Documentazione Vite](https://vitejs.dev/guide/)
- [Documentazione Flowbite](https://flowbite.com/docs/getting-started/introduction/)
- [Documentazione Flowbite Laravel](https://github.com/themesberg/flowbite-laravel)

## Alternative

Se preferisci utilizzare un altro approccio, puoi consultare le guide per:
- [Creazione di un tema con Volt, Folio e Filament](create_theme_volt_folio_filament.md)
- [Creazione di un tema con React](create_theme_react.md)
- [Creazione di un tema con Laravel](create_theme.md)
