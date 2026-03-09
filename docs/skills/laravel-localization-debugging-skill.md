# Skill: Debugging di Laravel Localization

## Panoramica
Questa skill fornisce una metodologia sistematica per diagnosticare e risolvere problemi di localizzazione in applicazioni Laravel che utilizzano il pacchetto `mcamara/laravel-localization`.

## Flusso di Debug

### 1. Verifica Base
```bash
# 1. Controlla se il pacchetto è installato
composer show mcamara/laravel-localization

# 2. Verifica la configurazione
php artisan config:clear
php artisan config:cache
cat config/laravellocalization.php | grep -A 10 "supportedLocales"
```

### 2. Test dell'URL
```bash
# Test diretto con curl
curl -I http://127.0.0.1:8000/de
curl -I http://127.0.0.1:8000/en
curl -I http://127.0.0.1:8000/it

# Verifica il redirect
curl -I -L http://127.0.0.1:8000/de
```

### 3. Debug Middleware
Creare un middleware di debug temporaneo:

```php
<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DebugLocalization
{
    public function handle(Request $request, Closure $next)
    {
        \Log::info('Localization Debug', [
            'url' => $request->fullUrl(),
            'segments' => $request->segments(),
            'path' => $request->path(),
            'locale' => app()->getLocale(),
            'session_locale' => session('locale'),
            'supported_locales' => \LaravelLocalization::getSupportedLanguagesKeys(),
            'current_locale' => \LaravelLocalization::getCurrentLocale(),
        ]);

        return $next($request);
    }
}
```

## Problemi Comuni e Soluzioni

### Problema 1: Lingua Non Cambia con URL `/de`

**Symptoms**:
- URL `http://127.0.0.1:8000/de` restituisce contenuto in italiano
- `app()->getLocale()` restituisce 'it' invece di 'de'

**Diagnosi**:
```php
// Aggiungi in un controller o middleware di debug
\Log::info('Locale Debug', [
    'url' => request()->fullUrl(),
    'segments' => request()->segments(),
    'first_segment' => request()->segments()[0] ?? null,
    'supported_locales' => \LaravelLocalization::getSupportedLanguagesKeys(),
    'app_locale' => app()->getLocale(),
    'config_locale' => config('app.locale'),
]);
```

**Soluzioni**:
1. **Verifica Middleware Chain**:
```bash
# Controlla l'ordine dei middleware
php artisan route:list --name=home
```

2. **Test Middleware Individuale**:
```php
// Testa SetFolioLocale singolarmente
// In un controller temporaneo
$middleware = new \Modules\Cms\Http\Middleware\SetFolioLocale();
$response = $middleware->handle(request(), function($req) {
    return response()->json(['locale' => app()->getLocale()]);
});
```

3. **Verifica Configurazione**:
```php
// Verifica che la lingua sia nella configurazione
$supported = \LaravelLocalization::getSupportedLanguagesKeys();
\Log::info('Supported locales:', $supported);
\Log::info('Is de supported?', in_array('de', $supported));
```

### Problema 2: Reindirizzamenti Ciclici

**Symptoms**:
- L'URL `http://127.0.0.1:8000/de` causa reindirizzamenti infiniti
- Browser mostra "Too Many Redirects"

**Diagnosi**:
```bash
# Verifica gli headers di reindirizzamento
curl -I http://127.0.0.1:8000/de

# Verifica il log
tail -f storage/logs/laravel.log | grep -i "redirect"
```

**Soluzioni**:
1. **Disabilita Temporaneamente Redirect Middleware**:
```php
// In FolioVoltServiceProvider, commenta i middleware di redirect
$base_middleware = [];
// $base_middleware[] = LocaleSessionRedirect::class;
// $base_middleware[] = LaravelLocalizationRedirectFilter::class;
```

2. **Verifica Sessione**:
```bash
# Pulisci la sessione
php artisan session:clear
```

### Problema 3: Lingua di Default Sovrascritta

**Symptoms**:
- Anche con URL `/de`, il contenuto è in italiano
- Le traduzioni tedesche non vengono caricate

**Diagnosi**:
```php
// In un controller
\Log::info('Locale Detection', [
    'url' => request()->fullUrl(),
    'app_locale' => app()->getLocale(),
    'config_locale' => config('app.locale'),
    'app_locale_path' => resource_path('lang/' . app()->getLocale()),
    'file_exists' => file_exists(resource_path('lang/' . app()->getLocale() . '/messages.php')),
]);
```

**Soluzioni**:
1. **Verifica File di Traduzione**:
```bash
ls -la resources/lang/de/
ls -la resources/lang/it/
```

2. **Forza Lingua in Middleware**:
```php
// Modifica SetFolioLocale per debug
public function handle(Request $request, \Closure $next): mixed
{
    $segments = $request->segments();
    $firstSegment = $segments[0] ?? '';

    if ($firstSegment === 'de') {
        \Log::info('Forcing German locale');
        app()->setLocale('de');
        \LaravelLocalization::setLocale('de');
    }

    return $next($request);
}
```

## Comandi di Debug Avanzati

### 1. Verifica Route Localizzate
```bash
# Lista tutte le route localizzate
php artisan route:trans:list de
php artisan route:trans:list it
php artisan route:trans:list en

# Verifica se la route esiste
php artisan route:trans:list de | grep -E "(home|index)"
```

### 2. Verifica Cache
```bash
# Pulisci cache di routing
php artisan route:clear

# Pulisci cache di configurazione
php artisan config:clear

# Ricarica configurazione
php artisan config:cache
```

### 3. Verifica Sessione
```bash
# Verifica sessione attuale
php artisan tinker
>>> session()->all()
>>> session()->get('locale')
>>> session()->put('locale', 'de')
>>> session()->save()
```

## Script di Debug Automatico

### Script PHP di Debug
```php
<?php
// debug_localization.php

echo "=== Laravel Localization Debug ===\n\n";

echo "1. Supported Locales:\n";
$supported = \LaravelLocalization::getSupportedLanguagesKeys();
print_r($supported);

echo "\n2. Current Locale:\n";
echo \LaravelLocalization::getCurrentLocale() . "\n";

echo "\n3. App Locale:\n";
echo app()->getLocale() . "\n";

echo "\n4. Request Info:\n";
echo "URL: " . request()->fullUrl() . "\n";
echo "Segments: " . implode(', ', request()->segments()) . "\n";
echo "Path: " . request()->path() . "\n";

echo "\n5. Session:\n";
echo "Session locale: " . session('locale', 'not set') . "\n";

echo "\n6. Config:\n";
echo "App locale: " . config('app.locale') . "\n";
echo "Hide default in URL: " . config('laravellocalization.hideDefaultLocaleInURL') . "\n";
echo "Use accept language: " . config('laravellocalization.useAcceptLanguageHeader') . "\n";

echo "\n7. Available Languages:\n";
foreach (\LaravelLocalization::getSupportedLocales() as $locale => $properties) {
    echo "- {$locale}: {$properties['native']}\n";
}
```

### Script Bash di Debug
```bash
#!/bin/bash
# debug_localization.sh

echo "=== Debug Localization ==="
echo "URL: $1"

echo -e "\n1. HTTP Headers:"
curl -I "$1" 2>/dev/null | head -10

echo -e "\n2. Follow redirects:"
curl -I -L "$1" 2>/dev/null | head -15

echo -e "\n3. Response body:"
curl -s "$1" | head -20

echo -e "\n4. Laravel logs:"
tail -20 storage/logs/laravel.log | grep -i -E "(locale|localization|redirect)"
```

## Testing Automatizzato

### Test di Localizzazione
```php
<?php
// tests/Feature/LocalizationTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\TestCase;
use Mcamara\LaravelLocalization\LaravelLocalization;

class LocalizationTest extends TestCase
{
    public function test_german_locale()
    {
        $this->refreshApplicationWithLocale('de');
        $response = $this->get('/de');
        $response->assertStatus(200);
        $response->assertSee('Deutsch');
    }

    public function test_english_locale()
    {
        $this->refreshApplicationWithLocale('en');
        $response = $this->get('/en');
        $response->assertStatus(200);
    }

    public function test_italian_locale()
    {
        $this->refreshApplicationWithLocale('it');
        $response = $this->get('/it');
        $response->assertStatus(200);
    }

    protected function refreshApplicationWithLocale(string $locale): void
    {
        self::tearDown();
        putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale);
        self::setUp();
    }
}
```

## Best Practices di Debug

### 1. Logging Strategico
```php
// In SetFolioLocale
\Log::debug('SetFolioLocale processing', [
    'url' => $request->fullUrl(),
    'segments' => $request->segments(),
    'first_segment' => $firstSegment,
    'supported_locales' => $supportedLocales,
    'default_locale' => $defaultLocale,
    'app_locale' => app()->getLocale(),
]);
```

### 2. Middleware Chain Testing
```bash
# Test middleware individualmente
php artisan tinker
>>> $middleware = new \Modules\Cms\Http\Middleware\SetFolioLocale();
>>> $request = Illuminate\Http\Request::create('/de', 'GET');
>>> $response = $middleware->handle($request, function($req) { return 'OK'; });
>>> app()->getLocale()
```

### 3. Session Management
```bash
# Verifica e resetta sessione
php artisan tinker
>>> session()->flush();
>>> session()->put('locale', 'de');
>>> session()->save();
>>> session()->get('locale')
```

## Strumenti di Monitoring

### 1. Laravel Telescope
Se installato, usa Telescope per monitorare:
- Richieste e risposte
- Middleware execution
- Logs di localizzazione

### 2. DebugBar
Se installato, verifica:
- Locale corrente
- Configurazione
- Sessione

## Checklist di Debug

- [ ] Verifica che il pacchetto sia installato e configurato
- [ ] Controlla che la lingua sia nella lista `supportedLocales`
- [ ] Verifica l'ordine dei middleware
- [ ] Testa URL singolarmente con curl
- [ ] Controlla i logs per errori di localizzazione
- [ ] Verifica la sessione
- [ ] Testa il reindirizzamento
- [ ] Verifica i file di traduzione
- [ ] Pulisci cache e sessione
- [ ] Testa con altri browser
- [ ] Verifica configurazione del server web

## Riferimenti

- [LaravelLocalization GitHub](https://github.com/mcamara/laravel-localization)
- [Laravel Localization Docs](https://laravel.com/docs/11.x/localization)
- [Laravel Middleware Docs](https://laravel.com/docs/11.x/middleware)