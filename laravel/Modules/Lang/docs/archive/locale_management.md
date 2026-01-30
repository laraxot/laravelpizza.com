# Gestione delle Lingue in Laravel

## Indice
1. [Configurazione Base](#configurazione-base)
2. [Gestione delle Lingue](#gestione-delle-lingue)
3. [Middleware per la Lingua](#middleware-per-la-lingua)
4. [Best Practice](#best-practice)
5. [Implementazione nel Progetto](#implementazione-nel-progetto)
6. [Risoluzione Problemi](#risoluzione-problemi)

## Configurazione Base

### File di Configurazione Principale

`config/app.php`:
```php
'locale' => 'it',  // Lingua predefinita
'fallback_locale' => 'en',  // Lingua di fallback
'faker_locale' => 'it_IT',  // Impostazioni localizzazione per Faker
```

### File di Configurazione mcamara/laravel-localization

`config/laravellocalization.php`:
```php
'supportedLocales' => [
    'it' => [
        'name' => 'Italiano',
        'script' => 'Latn',
        'native' => 'Italiano',
        'regional' => 'it_IT',
    ],
    'en' => [
        'name' => 'English',
        'script' => 'Latn',
        'native' => 'English',
        'regional' => 'en_GB',
    ],
],

// Nascondi la lingua predefinita nell'URL
'hideDefaultLocaleInURL' => true,
```

## Gestione delle Lingue

### Impostare la Lingua Corrente

```php
use Illuminate\Support\Facades\App;

// Imposta la lingua
App::setLocale('it');

// Verifica la lingua corrente
$currentLocale = App::currentLocale();
```

### Ottenere l'Elenco delle Lingue Supportate

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

$locales = LaravelLocalization::getSupportedLocales();
$locales = LaravelLocalization::getSupportedLanguagesKeys();
```

## Middleware per la Lingua

### Creazione del Middleware

`app/Http/Middleware/SetLocale.php`:
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Verifica la lingua nella sessione
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        
        // 2. Verifica la lingua nell'URL (se usi mcamara/laravel-localization)
        $locale = $request->segment(1);
        if (in_array($locale, config('laravellocalization.supportedLocales'))) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        }
        
        // 3. Verifica l'header Accept-Language
        if (!$request->hasHeader('X-Language')) {
            $preferredLanguage = $request->getPreferredLanguage(
                array_keys(config('laravellocalization.supportedLocales'))
            );
            
            if ($preferredLanguage) {
                App::setLocale($preferredLanguage);
                Session::put('locale', $preferredLanguage);
            }
        }
        
        return $next($request);
    }
}
```

### Registrazione del Middleware

`app/Http/Kernel.php`:
```php
protected $middlewareGroups = [
    'web' => [
        // ...
        \App\Http\Middleware\SetLocale::class,
    ],
];
```

## Best Practice

### 1. Struttura delle Cartelle
```
lang/
├── it/
│   ├── auth.php
│   ├── validation.php
│   └── modules/
│       ├── patient.php
│       └── doctor.php
└── en/
    └── ...
```

### 2. Convenzioni per le Chiavi
- Usa la notazione puntata per le gerarchie
- Prefissa con il nome del modulo
- Usa snake_case per le chiavi

### 3. Gestione delle Eccezioni
```php
try {
    // Codice che potrebbe generare eccezioni
} catch (\Exception $e) {
    if (App::isLocale('it')) {
        return response()->view('errors.custom', ['message' => 'Si è verificato un errore'], 500);
    }
    
    return response()->view('errors.custom', ['message' => 'An error occurred'], 500);
}
```

## Implementazione nel Progetto

### 1. Aggiornare il Service Provider

`Modules/Lang/Providers/LangServiceProvider.php`:
```php
public function boot()
{
    parent::boot();
    
    // Imposta la lingua all'avvio
    $this->app->setLocale(config('app.locale'));
    
    // Altri boot...
}
```

### 2. Creare un Helper per la Lingua

`Modules/Lang/Helpers/locale.php`:
```php
<?php

use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

if (! function_exists('get_current_locale')) {
    function get_current_locale()
    {
        return App::getLocale();
    }
}

if (! function_exists('get_locale_name')) {
    function get_locale_name($locale = null, $displayLocale = null)
    {
        return LaravelLocalization::getSupportedLocales()[$locale ?? App::getLocale()]['name'] ?? $locale;
    }
}
```

## Risoluzione Problemi

### 1. Le traduzioni JSON non funzionano con il fallback
**Problema**: Le traduzioni JSON non rispettano il fallback_locale.

**Soluzione**: Usa file PHP per le traduzioni di sistema o implementa un meccanismo personalizzato:

```php
function translate_with_fallback($key, $replace = [], $locale = null)
{
    $translation = __($key, $replace, $locale);
    
    if ($translation === $key && App::getLocale() !== config('app.fallback_locale')) {
        $translation = __($key, $replace, config('app.fallback_locale'));
    }
    
    return $translation;
}
```

### 2. La lingua non viene mantenuta tra le richieste
**Problema**: La lingua viene reimpostata alla richiesta successiva.

**Soluzione**: Assicurati di salvare la lingua nella sessione:

```php
// Quando cambi lingua
App::setLocale($newLocale);
Session::put('locale', $newLocale);

// Nel middleware
if (Session::has('locale')) {
    App::setLocale(Session::get('locale'));
}
```

## Comandi Artisan Utili

```bash
# Pubblicare le traduzioni di Laravel
php artisan lang:publish

# Verificare le traduzioni mancanti
php artisan translations:missing it

# Pulire la cache delle traduzioni
php artisan view:clear
php artisan config:clear
```

## Configurazione per i Test

`phpunit.xml`:
```xml
<php>
    <env name="APP_LOCALE" value="it"/>
    <env name="APP_FALLBACK_LOCALE" value="en"/>
</php>
```

Questo documento fornisce una panoramica completa sulla gestione delle lingue in Laravel, con particolare attenzione alle esigenze del progetto <nome progetto>.
