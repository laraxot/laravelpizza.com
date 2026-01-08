# Creazione di un Tema con React

## Introduzione

Questa guida descrive come creare un nuovo tema per il CMS utilizzando React come framework frontend. Il tema utilizza una combinazione di tecnologie moderne tra cui Flowbite, Tailwind CSS, React, Inertia.js e Laravel.

## Prerequisiti

1. Node.js e npm installati
2. Accesso alla directory dei temi
3. Conoscenza base di Vite e Tailwind CSS
4. PHP 8.1+
5. Laravel v10.0+
6. React 18.0+
7. Inertia.js
8. Flowbite v2.0+

## Passo 1: Installazione e Configurazione Base

```bash
# Installare il pacchetto Flowbite Laravel
composer require flowbite/flowbite-laravel

# Installare Inertia.js
composer require inertiajs/inertia-laravel

# Installare React e dipendenze
npm install @inertiajs/react react react-dom @vitejs/plugin-react

# Pubblicare le migrazioni
php artisan vendor:publish --tag="flowbite-laravel-migrations"
php artisan migrate

# Pubblicare il file di configurazione
php artisan vendor:publish --tag="flowbite-laravel-config"

# Pubblicare le viste
php artisan vendor:publish --tag="flowbite-laravel-views"
```

## Passo 2: Configurazione di Vite e React

```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.tsx',
            ],
            refresh: true,
        }),
        react(),
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
        './resources/js/**/*.jsx',
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

## Passo 4: Componenti React con Flowbite

```jsx
// resources/js/Components/Button.jsx
import React from 'react';
import { Link } from '@inertiajs/react';

export default function Button({ 
    type = 'button', 
    className = '', 
    processing, 
    children,
    href,
    ...props 
}) {
    const baseClasses = 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150';
    
    const variantClasses = {
        primary: 'bg-primary-600 hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900',
        secondary: 'bg-secondary-600 hover:bg-secondary-700 focus:bg-secondary-700 active:bg-secondary-900',
    };

    const classes = `${baseClasses} ${variantClasses[props.variant || 'primary']} ${className}`;

    if (href) {
        return (
            <Link href={href} className={classes} {...props}>
                {children}
            </Link>
        );
    }

    return (
        <button type={type} className={classes} disabled={processing} {...props}>
            {children}
        </button>
    );
}
```

## Passo 5: Layout Base con Inertia

```jsx
// resources/js/Layouts/AppLayout.jsx
import React from 'react';
import { Link } from '@inertiajs/react';
import { Head } from '@inertiajs/react';
import Navbar from '@/Components/Navbar';
import Sidebar from '@/Components/Sidebar';

export default function AppLayout({ children, title }) {
    return (
        <div className="min-h-screen bg-gray-100">
            <Head title={title} />
            
            <Navbar />
            
            <div className="flex">
                <Sidebar />
                
                <main className="flex-1 p-6">
                    {children}
                </main>
            </div>
        </div>
    );
}
```

## Passo 6: Struttura Directory

```
resources/
├── js/
│   ├── Components/
│   │   ├── Button.jsx
│   │   ├── Card.jsx
│   │   └── Navbar.jsx
│   ├── Layouts/
│   │   └── AppLayout.jsx
│   ├── Pages/
│   │   ├── Dashboard/
│   │   ├── Blog/
│   │   └── Portfolio/
│   └── app.tsx
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

4. **Problemi di Inertia**
   - Verificare la configurazione del server
   - Controllare i middleware
   - Assicurarsi che le rotte siano configurate correttamente

## Risorse Utili

- [Documentazione React](https://reactjs.org/docs/getting-started.html)
- [Documentazione Inertia.js](https://inertiajs.com/)
- [Documentazione Vite](https://vitejs.dev/guide/)
- [Documentazione Flowbite](https://flowbite.com/docs/getting-started/introduction/)
- [Documentazione Flowbite Laravel](https://github.com/themesberg/flowbite-laravel)

## Alternative

Se preferisci utilizzare un altro approccio, puoi consultare le guide per:
- [Creazione di un tema con Volt, Folio e Filament](create_theme_volt_folio_filament.md)
- [Creazione di un tema con Vue.js](create_theme_vue.md)
- [Creazione di un tema con Laravel](create_theme.md)
