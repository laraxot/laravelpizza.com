# Tema One per il progetto

## Introduzione

Tema One è il tema predefinito per il progetto, basato su Filament 3.3. Offre un'interfaccia moderna e responsive per la gestione dei contenuti del sito web.

## Requisiti

- PHP 8.1+
- Laravel 10+
- Filament 3.3+
- Node.js 16+
- NPM 8+

## Installazione

1. Aggiungi il tema al tuo `composer.json`:

```json
{
    "require": {
        "<nome progetto>/theme-one": "^1.0"
    }
}
```

2. Esegui l'installazione:

```bash
composer update
```

3. Pubblica gli asset del tema:

```bash
php artisan vendor:publish --tag=theme-one-assets
php artisan vendor:publish --tag=theme-one-views
php artisan vendor:publish --tag=theme-one-config
```

4. Installa le dipendenze NPM:

```bash
npm install
```

5. Compila gli asset:

```bash
npm run build
```

6. Copia gli asset compilati:

```bash
npm run copy
```

## Configurazione

### Tailwind CSS

Assicurati che i seguenti file siano configurati correttamente:

1. `postcss.config.js`:

```js
module.exports = {
    plugins: {
        tailwindcss: {},
        autoprefixer: {},
    },
}
```

2. `tailwind.config.js`:

```js
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './vendor/<nome progetto>/theme-one/resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
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
    ],
}
```

3. `vite.config.js`:

```js
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

## Struttura del Tema

```
laravel/Themes/One/
├── app/
│   └── Providers/
│       └── ThemeServiceProvider.php
├── config/
│   └── theme.php
├── resources/
│   ├── views/
│   │   ├── components/
│   │   │   └── blocks/
│   │   └── pages/
│   │       ├── pages/
│   │       │   └── [slug].blade.php
│   │       └── it/
│   │           └── pages/
│   └── assets/
└── docs/
    ├── blocks.md
    ├── folio.md
    └── installation.md
```

## Blocchi Disponibili

### Hero
Blocco hero per le pagine principali con titolo, sottotitolo e CTA.

### Feature Sections
Sezioni di caratteristiche con icone, titoli e descrizioni.

### Team
Sezione per visualizzare i membri del team con foto, nomi e ruoli.

### Stats
Statistiche con numeri e etichette.

### CTA
Call to Action con titolo, descrizione e pulsante.

### Paragraph
Paragrafo di testo formattato.

## Personalizzazione

### Viste
Le viste possono essere personalizzate copiandole dalla directory `resources/views` del tema nella directory `resources/views` della tua applicazione.

### Asset
Gli asset possono essere personalizzati modificando i file nella directory `resources/assets` del tema.

### Configurazione
La configurazione del tema può essere personalizzata modificando il file `config/theme.php`.

## Integrazione con Laravel Folio

Il tema utilizza Laravel Folio per la gestione delle rotte frontend. Vedi la documentazione in `docs/folio.md` per maggiori dettagli.

## Integrazione con il CMS

Il tema si integra con il modulo CMS per la gestione dei contenuti. I blocchi di contenuto sono gestiti attraverso il modello `Page` del modulo CMS.

## Compatibilità

Assicurati che i nomi dei parametri nel database corrispondano a quelli attesi dai componenti. In particolare:

- Il blocco `feature_sections` utilizza il parametro `sections` invece di `features`
- Il blocco `stats` utilizza il parametro `number` invece di `value` per i valori delle statistiche

## Supporto

Per assistenza tecnica, contattare:
- Email: support@<nome progetto>.com
- Documentazione: https://docs.<nome progetto>.com 
