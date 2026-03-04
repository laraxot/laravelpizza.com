# Componenti Personalizzati in Filament V3

Questa guida spiega come implementare componenti personalizzati all'interno di un pannello Filament V3 utilizzando Livewire e TailwindCSS.

## Prerequisiti

- Laravel 10+
- Filament V3
- Node.js e NPM
- Installazione base di Filament completata

## Configurazione Iniziale

### 1. Creazione del Theme

Per prima cosa, creare un nuovo tema Filament:

```bash
php artisan make:filament-theme
```

Questo comando:
- Installa le dipendenze JavaScript necessarie:
  - tailwindcss
  - @tailwindcss/forms
  - @tailwindcss/typography
  - postcss
  - autoprefixer
- Prepara i file di configurazione necessari

### 2. Configurazione Vite

Aggiungere l'entry point del tema nel file `vite.config.js`:

```javascript
export default defineConfig({
    plugins: [
        laravel({
            input: [
                // ... altri entry points
                'resources/css/filament/admin/theme.css',
            ],
        }),
    ],
});
```

### 3. Registrazione del Theme

Nel provider del pannello (`app/Providers/Filament/AdminPanelProvider.php`):

```php
use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        // ... altre configurazioni
        ->viteTheme('resources/css/filament/admin/theme.css');
}
```

### 4. Configurazione Tailwind

Aggiungere i percorsi Livewire in `resources/css/filament/admin/tailwind.config.js`:

```javascript
export default {
    content: [
        // ... altri percorsi
        './app/Livewire/**/*.php',
        './resources/views/livewire/**/*.blade.php',
    ],
};
```

## Sviluppo dei Componenti

### 1. Struttura dei File

```
resources/
├── css/
│   └── filament/
│       └── admin/
│           ├── theme.css
│           └── tailwind.config.js
├── views/
│   └── livewire/
│       └── components/
│           └── custom-component.blade.php
app/
└── Livewire/
    └── Components/
        └── CustomComponent.php
```

### 2. Creazione Componente Livewire

```php
<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CustomComponent extends Component
{
    public function render()
    {
        return view('livewire.components.custom-component');
    }
}
```

### 3. View del Componente

```blade
<div>
    {{-- Contenuto del componente con classi Tailwind --}}
    <div class="p-4 bg-white rounded-lg shadow">
        {{ $slot }}
    </div>
</div>
```

## Integrazione con Filament

### 1. Widget Personalizzati

Per creare un widget personalizzato:

```bash
php artisan make:filament-widget CustomWidget
```

### 2. Registrazione Widget

Nel provider del pannello:

```php
use App\Filament\Widgets\CustomWidget;

public function panel(Panel $panel): Panel
{
    return $panel
        // ... altre configurazioni
        ->widgets([
            CustomWidget::class,
        ]);
}
```

## Best Practices

1. **Organizzazione del Codice**
   - Mantenere i componenti in moduli separati
   - Seguire le convenzioni di naming di Laravel/Filament
   - Documentare i componenti personalizzati

2. **Performance**
   - Utilizzare lazy loading quando possibile
   - Ottimizzare le query del database
   - Minimizzare le chiamate AJAX

3. **Stile e Design**
   - Seguire le linee guida di design di Filament
   - Mantenere consistenza con i componenti nativi
   - Utilizzare le variabili CSS di Filament

4. **Accessibilità**
   - Implementare attributi ARIA appropriati
   - Testare con screen reader
   - Supportare la navigazione da tastiera

## Hot Reloading

Per lo sviluppo attivo, utilizzare:

```bash
npm run dev
```

Questo abiliterà:
- Hot module replacement
- Ricompilazione automatica dei file CSS
- Aggiornamento immediato del browser

## Note sulla Sicurezza

1. **Validazione Input**
   - Validare tutti gli input utente
   - Utilizzare i middleware di autenticazione
   - Implementare protezione CSRF

2. **Autorizzazioni**
   - Definire policies chiare
   - Utilizzare gate e middleware
   - Controllare accessi ai componenti

## Troubleshooting

### Problemi Comuni

1. **Stili non Applicati**
   - Verificare la configurazione di Tailwind
   - Controllare i percorsi nel content array
   - Pulire la cache di Vite

2. **Componenti non Registrati**
   - Controllare i namespace
   - Verificare l'autoloading
   - Pulire la cache delle view

### Comandi Utili

```bash
# Pulizia cache
php artisan view:clear
php artisan cache:clear

# Rigenerazione autoload
composer dump-autoload

# Ricompilazione assets
npm run build
```

## Riferimenti

- [Documentazione Filament](https://filamentphp.com)
- [Documentazione Livewire](https://livewire.laravel.com)
- [Documentazione TailwindCSS](https://tailwindcss.com) 
