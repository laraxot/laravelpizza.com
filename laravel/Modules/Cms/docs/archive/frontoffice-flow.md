# Flusso Frontoffice <main module>

## Indice
1. [Introduzione](#introduzione)
2. [Struttura delle Route](#struttura-delle-route)
3. [Layout e Componenti](#layout-e-componenti)
4. [Gestione dei Contenuti](#gestione-dei-contenuti)
5. [Integrazione dei Moduli](#integrazione-dei-moduli)
6. [Best Practices](#best-practices)

## Introduzione

Questo documento descrive il flusso completo del frontoffice di <main module>, dalla gestione delle route alla renderizzazione dei componenti.

## Struttura delle Route

### Gestione delle Lingue
- La route base `/` reindirizza a `/{locale}` (es. `/it`)
- Il locale viene gestito da Laravel Folio
- Il file corrispondente si trova in `/laravel/Themes/One/resources/views/pages/index.blade.php`

### Struttura delle Directory
```
/laravel/Themes/One/resources/views/
├── pages/                # Pagine del frontoffice (Folio)
├── components/           # Componenti Blade
│   ├── blocks/          # Blocchi di contenuto
│   ├── sections/        # Sezioni della pagina
│   └── ui/              # Componenti UI riutilizzabili
├── layouts/             # Layout principali
└── livewire/           # Componenti Livewire
```

## Layout e Componenti

### Layout Principale (main.blade.php)
```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Meta tags e risorse -->
        @filamentStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'],'themes/One')
    </head>
    <body>
        {{ $slot }}
        <livewire:toast />
        @livewire('notifications')
        @filamentScripts
    </body>
</html>
```

### Layout Applicazione (app.blade.php)
```blade
<x-layouts.main>
    <x-ui.marketing.header />
    @if (isset($header))
        <header>
            {{ $header }}
        </header>
    @endif
    <div class="mx-auto mt-5 max-w-7xl">
        {{ $slot }}
    </div>
</x-layouts.main>
```

## Gestione dei Contenuti

### Sezioni e Blocchi
- Le sezioni sono definite in `/laravel/config/local/<directory progetto>/database/content/sections/`
- Ogni sezione ha un file JSON che definisce:
  - ID e nome
  - Blocchi di contenuto
  - Attributi e stili
  - Metadata

### Esempio di Sezione (1.json)
```json
{
    "id": "1",
    "name": {
        "it": "Header Principale",
        "en": "Main Header"
    },
    "blocks": {
        "it": [
            {
                "name": {
                    "it": "Logo",
                    "en": "Logo"
                },
                "type": "logo",
                "data": {
                    "view": "pub_theme::components.blocks.logo",
                    "src": "patient::images/logo.svg"
                }
            }
        ]
    }
}
```

## Integrazione dei Moduli

### Modulo User
- Gestisce l'autenticazione e il profilo utente
- Fornisce widget Filament per login/registrazione
- Integra Livewire per componenti dinamici

### Modulo Cms
- Gestisce la struttura delle pagine
- Fornisce i blocchi di contenuto
- Integra Filament per l'amministrazione

## Best Practices

### 1. Gestione delle Route
- Usare Laravel Folio per le pagine statiche
- Definire route API in `routes/api.php`
- Mantenere la coerenza nella struttura URL

### 2. Componenti
- Riutilizzare i componenti UI esistenti
- Seguire le convenzioni di naming
- Documentare i props e gli eventi

### 3. Contenuti
- Usare i file JSON per la configurazione
- Mantenere la struttura modulare
- Supportare la localizzazione

### 4. Performance
- Lazy loading dei componenti
- Caching dei contenuti
- Ottimizzazione delle risorse

## Collegamenti
- [Struttura Route e Viste](./struttura-route-e-viste.md)
- [Layout e Componenti](./struttura-layout-componenti-blade-<nome progetto>.md)
- [Best Practices Filament](./best-practices/filament.md) 