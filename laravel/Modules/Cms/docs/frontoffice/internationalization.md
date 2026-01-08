# Internazionalizzazione

## Introduzione

Il modulo CMS supporta la gestione multilingua attraverso l'integrazione con il sistema di traduzioni di Laravel e plugin specifici per Vite. Questa sezione descrive come configurare e utilizzare le traduzioni nel contesto del CMS.

## Traduzioni con Vite

### Installazione
```bash
npm install vite-plugin-laravel-translations
```

### Configurazione Vite
```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import translations from 'vite-plugin-laravel-translations';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        translations({
            langDir: 'lang',
            locales: ['it', 'en'],
        }),
    ],
});
```

### Utilizzo nelle Viste
```blade
<div>
    <h1>{{ __('Welcome to our website') }}</h1>
    <p>{{ __('Please select your language') }}</p>
</div>
```

### Utilizzo in JavaScript
```javascript
// resources/js/app.js
import { __ } from 'vite-plugin-laravel-translations';

console.log(__('Welcome to our website'));
```

## Gestione delle Lingue

### Configurazione
```php
// config/app.php
'locale' => 'it',
'fallback_locale' => 'en',
'available_locales' => ['it', 'en'],
```

### Middleware per la Lingua
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('locale')) {
            app()->setLocale(session()->get('locale'));
        }

        return $next($request);
    }
}
```

### Cambio Lingua
```php
// routes/web.php
Route::get('locale/{locale}', function ($locale) {
    if (in_array($locale, config('app.available_locales'))) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('locale.switch');
```

## Best Practices

1. **Organizzazione**
   - Raggruppare le traduzioni per modulo
   - Utilizzare chiavi descrittive
   - Mantenere la coerenza

2. **Performance**
   - Implementare il caching
   - Ottimizzare il caricamento
   - Utilizzare CDN

3. **Manutenzione**
   - Documentare le traduzioni
   - Aggiornare regolarmente
   - Verificare la completezza

## Risorse Utili

- [Documentazione Laravel Localization](https://laravel.com/docs/12.x/localization)
- [Vite Plugin Translations](https://github.com/dcodegroup/vite-plugin-laravel-translations)
- [Laravel Localization Guide](https://laravel-news.com/laravel-localization)

## Troubleshooting

### Errori Comuni

1. **Traduzioni Mancanti**
   - Verificare i file di traduzione
   - Controllare le chiavi
   - Aggiornare le traduzioni

2. **Problemi di Cache**
   - Pulire la cache delle traduzioni
   - Riavviare il server
   - Verificare i permessi

3. **Problemi di Performance**
   - Ottimizzare il caricamento
   - Implementare il caching
   - Utilizzare CDN 
