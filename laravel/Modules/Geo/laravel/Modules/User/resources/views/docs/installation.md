# Installazione del Tema One

## Requisiti

- PHP 8.1+
- Laravel 10+
- Filament 3.3+
- Node.js 16+
- NPM 8+

## Passi di Installazione

### 1. Aggiungi il Tema al Composer

Aggiungi il tema al tuo `composer.json`:

```json
{
    "require": {
        "<nome progetto>/theme-one": "^1.0"
        "<nome progetto>/theme-one": "^1.0"
    }
}
```

### 2. Installa il Tema

Esegui il comando seguente per installare il tema:

```bash
composer update
```

### 3. Pubblica gli Assets del Tema

Pubblica gli assets del tema con il comando seguente:

```bash
php artisan vendor:publish --tag=theme-one-assets
```

### 4. Pubblica le Viste del Tema

Pubblica le viste del tema con il comando seguente:

```bash
php artisan vendor:publish --tag=theme-one-views
```

### 5. Pubblica la Configurazione del Tema

Pubblica la configurazione del tema con il comando seguente:

```bash
php artisan vendor:publish --tag=theme-one-config
```

### 6. Installa le Dipendenze NPM

Installa le dipendenze NPM con il comando seguente:

```bash
npm install
```

### 7. Compila gli Assets

Compila gli assets con il comando seguente:

```bash
npm run build
```

### 8. Copia gli Assets Compilati

Copia gli assets compilati nella directory pubblica:

```bash
npm run copy
```

## Configurazione

### Configurazione in config/app.php

Aggiungi il service provider del tema in `config/app.php`:

```php
'providers' => [
    // ...
    Themes\One\Providers\ThemeServiceProvider::class,
],
```

### Configurazione in config/theme.php

Personalizza la configurazione del tema in `config/theme.php`:

```php
return [
    'name' => 'One',
    'description' => 'Tema predefinito per ',
    'description' => 'Tema predefinito per <nome progetto>',
    'version' => '1.0.0',
    // ...
];
```

### Configurazione in vite.config.js

Aggiungi il tema al file `vite.config.js`:

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
```

### Configurazione in postcss.config.js

Assicurati che il file `postcss.config.js` contenga la configurazione corretta:

```javascript
export default {
    plugins: {
        'tailwindcss/nesting': 'postcss-nesting',
        tailwindcss: {},
        autoprefixer: {},
    },
};
```

### Configurazione in tailwind.config.js

Assicurati che il file `tailwind.config.js` contenga la configurazione corretta:

```javascript
/** @type {import('tailwindcss').Config} */
import preset from './vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./assets/**/*.js",
        "./assets/**/*.css",
        "../../app/Filament/**/*.php",
        "../../resources/views/**/*.blade.php",
        "../../vendor/filament/**/*.blade.php",
        "../../Modules/**/Filament/**/*.php",
        "../../Modules/**/resources/views/**/*.blade.php",
        "../../storage/framework/views/*.php",
        "../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./node_modules/flowbite/**/*.js",
        "../../../public_html/vendor/**/*.blade.php",
    ],
    darkMode: 'class',
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
                    950: '#082f49',
                },
                secondary: {
                    50: '#f8fafc',
                    100: '#f1f5f9',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                    400: '#94a3b8',
                    500: '#64748b',
                    600: '#475569',
                    700: '#334155',
                    800: '#1e293b',
                    900: '#0f172a',
                },
            },
            fontFamily: {
                sans: ['Figtree', 'sans-serif'],
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('flowbite/plugin'),
    ],
};
```

## Verifica dell'Installazione

### Verifica delle Rotte

Verifica che le rotte del tema siano registrate correttamente:

```bash
php artisan route:list | grep one
```

### Verifica degli Assets

Verifica che gli assets del tema siano pubblicati correttamente:

```bash
ls -la public/themes/one
```

### Verifica delle Viste

Verifica che le viste del tema siano pubblicate correttamente:

```bash
ls -la resources/views/vendor/theme-one
```

## Risoluzione dei Problemi Comuni

### Assets Mancanti

Se gli assets del tema sono mancanti, prova a pubblicarli nuovamente:

```bash
php artisan vendor:publish --tag=theme-one-assets --force
```

### Viste Mancanti

Se le viste del tema sono mancanti, prova a pubblicarle nuovamente:

```bash
php artisan vendor:publish --tag=theme-one-views --force
```

### Configurazione Mancante

Se la configurazione del tema è mancante, prova a pubblicarla nuovamente:

```bash
php artisan vendor:publish --tag=theme-one-config --force
```

### Problemi di Compilazione

Se riscontri problemi durante la compilazione degli assets, prova a:

1. Rimuovere la directory `node_modules` e il file `package-lock.json`
2. Eseguire `npm install` per reinstallare le dipendenze
3. Eseguire `npm run build` per ricompilare gli assets

### Problemi di Compatibilità

Se riscontri problemi di compatibilità con i blocchi, assicurati che:

1. I nomi dei parametri nei file JSON corrispondano a quelli attesi dai componenti
2. Per il blocco `feature_sections`, usa `sections` nel JSON (verrà passato come `features` al componente)
3. Per il blocco `stats`, usa `number` invece di `value` per il valore della statistica

## Best Practices

1. **Backup**: Fai sempre un backup del tuo progetto prima di installare un nuovo tema.
2. **Versioning**: Utilizza il versioning per tenere traccia delle modifiche.
3. **Testing**: Testa sempre il tema in un ambiente di sviluppo prima di utilizzarlo in produzione.
4. **Documentazione**: Mantieni sempre aggiornata la documentazione.
5. **Sicurezza**: Assicurati che il tema sia sicuro e non contenga vulnerabilità.
6. **Performance**: Ottimizza sempre le performance del tema.
7. **Supporto**: Fornisci sempre supporto per il tema.
