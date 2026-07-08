# Layout del Tema Zero

## Panoramica

Il tema Zero fornisce due layout principali per gestire la struttura delle pagine dell'applicazione:

1. **Layout Principale (main.blade.php)**: Layout completo per pagine pubbliche
2. **Layout App (app.blade.php)**: Layout semplificato per componenti interni

## Layout Principale (main.blade.php)

### Caratteristiche

- **HTML5 Semantico**: Utilizza tag semantici per una migliore accessibilità
- **Meta Tag Dinamici**: Supporto per SEO e social media
- **Responsive Design**: Ottimizzato per tutti i dispositivi
- **Integrazione Vite**: Caricamento ottimizzato degli asset
- **Navigazione**: Header con menu di navigazione
- **Footer**: Area footer personalizzabile

### Struttura

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Meta tag e SEO -->
    <!-- Fonts -->
    <!-- Styles -->
</head>
<body>
    <!-- Header con navigazione -->
    <!-- Contenuto principale -->
    <!-- Footer -->
    <!-- Scripts -->
</body>
</html>
```

### Utilizzo

```blade
<x-layouts.main>
    <x-slot name="title">
        Titolo della Pagina
    </x-slot>
    
    <x-slot name="description">
        Descrizione della pagina per SEO
    </x-slot>
    
    <!-- Contenuto della pagina -->
    <div class="container mx-auto px-4 py-8">
        <h1>Benvenuto</h1>
        <p>Contenuto della pagina...</p>
    </div>
</x-layouts.main>
```

### Slot Disponibili

- `title`: Titolo della pagina (obbligatorio)
- `description`: Meta description per SEO
- `keywords`: Meta keywords
- `og_image`: Immagine per Open Graph
- `canonical`: URL canonico
- `header`: Contenuto personalizzato per l'header
- `footer`: Contenuto personalizzato per il footer

## Layout App (app.blade.php)

### Caratteristiche

- **Layout Semplificato**: Per componenti e sezioni interne
- **Flessibile**: Adattabile a diversi contesti
- **Minimalista**: Design pulito e essenziale

### Struttura

```blade
<div class="min-h-screen bg-gray-100">
    <!-- Header opzionale -->
    <!-- Contenuto principale -->
</div>
```

### Utilizzo

```blade
<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <!-- Contenuto del componente -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Contenuto del componente...
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
```

## Personalizzazione

### Stili CSS

I layout utilizzano Tailwind CSS per lo styling. È possibile personalizzare:

1. **Colori**: Modificare la palette in `tailwind.config.js`
2. **Tipografia**: Cambiare i font nelle classi CSS
3. **Spaziature**: Aggiustare padding e margin
4. **Layout**: Modificare la struttura dei container

### Esempio di Personalizzazione

```css
/* resources/css/app.css */
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer components {
    .layout-header {
        @apply bg-white shadow-sm border-b border-gray-200;
    }
    
    .layout-main {
        @apply min-h-screen bg-gray-50;
    }
    
    .layout-footer {
        @apply bg-gray-800 text-white py-8;
    }
}
```

### Variabili CSS

```css
:root {
    --primary-color: #3b82f6;
    --secondary-color: #64748b;
    --accent-color: #f59e0b;
    --background-color: #f8fafc;
    --text-color: #1e293b;
}
```

## Best Practices

### 1. Accessibilità

- Utilizzare sempre tag semantici appropriati
- Includere attributi ARIA quando necessario
- Assicurare un contrasto adeguato dei colori
- Fornire testi alternativi per le immagini

### 2. SEO

- Includere sempre meta tag appropriati
- Utilizzare URL canonici
- Ottimizzare i titoli delle pagine
- Strutturare correttamente i heading

### 3. Performance

- Minimizzare il caricamento degli asset
- Utilizzare lazy loading per le immagini
- Ottimizzare i font web
- Implementare caching appropriato

### 4. Responsive Design

- Testare su diversi dispositivi
- Utilizzare breakpoint appropriati
- Assicurare la leggibilità su mobile
- Ottimizzare la navigazione touch

## Esempi di Utilizzo

### Pagina Home

```blade
<x-layouts.main>
    <x-slot name="title">Home - {{ config('app.name') }}</x-slot>
    <x-slot name="description">Benvenuto nella nostra applicazione</x-slot>
    
    <div class="hero-section">
        <h1 class="text-4xl font-bold text-center mb-8">
            Benvenuto
        </h1>
        <p class="text-xl text-center text-gray-600">
            La tua applicazione è pronta
        </p>
    </div>
</x-layouts.main>
```

### Dashboard

```blade
<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Widget del dashboard -->
    </div>
</x-layouts.app>
```

## Troubleshooting

### Problemi Comuni

1. **Asset non caricati**: Verificare la configurazione di Vite
2. **Stili non applicati**: Controllare l'ordine di caricamento CSS
3. **Layout spezzato**: Verificare le classi Tailwind
4. **SEO non funzionante**: Controllare i meta tag

### Debug

```bash
# Verificare la compilazione degli asset
npm run build

# Controllare i log di Laravel
tail -f storage/logs/laravel.log

# Verificare la configurazione del tema
php artisan config:cache
```

## Riferimenti

- [Documentazione Blade](https://laravel.com/docs/blade)
- [Documentazione Tailwind CSS](https://tailwindcss.com/docs)
- [Guida Accessibilità](https://www.w3.org/WAI/WCAG21/quickref/)
- [Best Practices SEO](https://developers.google.com/search/docs) 