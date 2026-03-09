# Regole di Governance per Laravel Localization

## Panoramica
Queste regole governano l'uso del pacchetto `mcamara/laravel-localization` nel progetto LaravelPizza. Il pacchetto fornisce funzionalità di localizzazione per applicazioni Laravel multilingua.

## Configurazione Principale

### File di Configurazione
- **Percorso**: `config/laravellocalization.php`
- **Stato**: Già pubblicato e configurato
- **Versione Laravel**: Compatibile con Laravel 11+ (versione 2.0.x del pacchetto)

### Lingue Supportate
```php
'supportedLocales' => [
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'italiano', 'regional' => 'it_IT'],
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    'de' => ['name' => 'German', 'script' => 'Latn', 'native' => 'Deutsch', 'regional' => 'de_DE'],
    'fr' => ['name' => 'French', 'script' => 'Latn', 'native' => 'français', 'regional' => 'fr_FR'],
    'es' => ['name' => 'Spanish', 'script' => 'Latn', 'native' => 'español', 'regional' => 'es_ES'],
    'ru' => ['name' => 'Russian', 'script' => 'Cyrl', 'native' => 'Pусский', 'regional' => 'ru_RU'],
],
```

### Impostazioni Chiave
- `useAcceptLanguageHeader`: true - Rileva automaticamente la lingua dal browser
- `hideDefaultLocaleInURL`: false - Mostra sempre il prefisso lingua nell'URL
- `localesOrder`: Ordine di visualizzazione delle lingue
- `httpMethodsIgnored`: ['POST', 'PUT', 'PATCH', 'DELETE'] - Metodi HTTP ignorati per la localizzazione

## Middleware di Localizzazione

### Alias Registrati in bootstrap/app.php
```php
'middleware->alias([
    'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
    'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
    'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
    'localeCookieRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
    'localeViewPath' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
])'
```

### Middleware Folio
Il servizio `FolioVoltServiceProvider` configura automaticamente i middleware per Folio:
- `LocaleSessionRedirect::class`
- `LaravelLocalizationRedirectFilter::class`
- `SetFolioLocale::class`

## Middleware SetFolioLocale

### Posizione
`Modules/Cms/app/Http/Middleware/SetFolioLocale.php`

### Logica di Priorità
1. **Utente Autenticato con Lingua Salvata**: Usa la lingua dell'utente
2. **Prefisso Lingua nell'URL**: Estrae il primo segmento dall'URL
3. **Lingua di Default**: Imposta la lingua predefinita (it)

### Implementazione Critica
```php
public function handle(Request $request, \Closure $next): mixed
{
    // Priority 1: Utente autenticato con lingua salvata
    if ($request->user() && $request->user()->lang) {
        $userLocale = $request->user()->lang;
        app()->setLocale($userLocale);
        LaravelLocalization::setLocale($userLocale);
        return $next($request);
    }

    // Priority 2: Estrae il primo segmento dall'URL
    $segments = $request->segments();
    $firstSegment = $segments[0] ?? '';

    // Priority 3: Imposta lingua di default se il segmento non è supportato
    if (in_array($firstSegment, $supportedLocales, true)) {
        app()->setLocale($firstSegment);
    } else {
        app()->setLocale($defaultLocale);
    }

    return $next($request);
}
```

## Routing e URL

### Struttura URL
- **Base**: `http://127.0.0.1:8000/{locale}`
- **Esempi**:
  - `http://127.0.0.1:8000/it`
  - `http://127.0.0.1:8000/en`
  - `http://127.0.0.1:8000/de`

### Middleware di Reindirizzamento
Il middleware `LocaleSessionRedirect` reindirizza automaticamente gli utenti senza prefisso lingua:
- Se `useAcceptLanguageHeader=true`, rileva la lingua dal browser
- Se c'è una lingua salvata in sessione, reindirizza all'URL con prefisso
- Se `hideDefaultLocaleInURL=false`, mantiene il prefisso anche per la lingua di default

## Testing

### Configurazione Test
Per testare specifiche lingue, usare il metodo `refreshApplicationWithLocale()`:

```php
protected function refreshApplicationWithLocale(string $locale): void
{
    self::tearDown();
    putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale);
    self::setUp();
}
```

### Esempio di Test
```php
public function it_can_visit_the_home_page_in_german()
{
    $this->refreshApplicationWithLocale('de');
    $response = $this->get('/de');
    $response->assertStatus(200);
}
```

## Problemi Comuni e Soluzioni

### 1. Lingua Non Impostata correttamente
**Problema**: L'URL `http://127.0.0.1:8000/de` non imposta la lingua tedesca.
**Soluzione**: Verificare che:
- Il middleware `SetFolioLocale` sia applicato correttamente
- La lingua 'de' sia nella lista `supportedLocales`
- Nessun altro middleware interferisca con il processo

### 2. Problemi con Route Caching
**Problema**: `php artisan route:cache` causa errori 404 per le route localizzate.
**Soluzione**: Usare il comando specifico del pacchetto:
```bash
php artisan route:trans:cache
```

### 3. Problemi con Form
**Problema**: Form POST perdono la localizzazione.
**Soluzione**: Localizzare l'azione del form:
```php
<form action="{{ LaravelLocalization::localizeUrl('/logout') }}" method="POST">
```

## Best Practices

### 1. Middleware Order
Assicurarsi che i middleware di localizzazione siano in ordine corretto:
1. `LocaleSessionRedirect` (o `LocaleCookieRedirect`)
2. `LaravelLocalizationRedirectFilter`
3. `SetFolioLocale`

### 2. Linguaggio Utente
Per utenti autenticati, salvare la lingua preferita nell'attributo `lang` del modello User.

### 3. Testing
Testare sempre le diverse lingue nei test di sistema, specialmente per pagine dinamiche.

## Monitoraggio e Debug

### Debug Locale
Per debuggare il locale corrente:
```php
// In controller o view
dd(app()->getLocale());
dd(LaravelLocalization::getCurrentLocale());
```

### Logging
Implementare logging per il cambiamento di lingua:
```php
Log::info('Locale changed', [
    'old' => session('locale'),
    'new' => app()->getLocale(),
    'user_id' => auth()->id(),
    'url' => request()->fullUrl(),
]);
```

## Version Control

### Cambiamenti alla Configurazione
- Modifiche a `config/laravellocalization.php` richiedono revisione del codice
- Aggiunta di nuove lingue richiede aggiornamento di tutti i componenti localizzati
- Cambiamenti ai middleware richiedono testing completo

### Pubblicazione Configurazione
Per pubblicare la configurazione (se necessario):
```bash
php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
```

## Referenze

- [Documentazione LaravelLocalization](https://github.com/mcamara/laravel-localization)
- [Laravel Localization Middleware](https://laravel.com/docs/11.x/localization)
- [Middleware di Routing Laravel](https://laravel.com/docs/11.x/middleware)