# Gestione di Forme Plurali e Localizzazione di Date/Valute in Laravel

## Indice
1. [Introduzione](#introduzione)
2. [Gestione delle Forme Plurali](#gestione-delle-forme-plurali)
   - [Utilizzo di trans_choice()](#utilizzo-di-trans_choice)
   - [Sintassi per i Plurali](#sintassi-per-i-plurali)
   - [Esempi Pratici](#esempi-pratici)
3. [Localizzazione di Date e Orari](#localizzazione-di-date-e-orari)
   - [Configurazione di Carbon](#configurazione-di-carbon)
   - [Formattazione delle Date](#formattazione-delle-date)
   - [Differenze tra Date](#differenze-tra-date)
4. [Localizzazione di Valute e Numeri](#localizzazione-di-valute-e-numeri)
   - [Utilizzo di NumberFormatter](#utilizzo-di-numberformatter)
   - [Helper Personalizzati](#helper-personalizzati)
5. [Implementazione nel Progetto](#implementazione-nel-progetto)
6. [Best Practice](#best-practice)
7. [Risoluzione Problemi](#risoluzione-problemi)

## Introduzione

La gestione corretta delle forme plurali e la localizzazione di date e valute sono aspetti fondamentali per un'applicazione multilingua. Questo documento fornisce una guida completa per implementare queste funzionalità in Laravel.

## Gestione delle Forme Plurali

### Utilizzo di trans_choice()

Laravel fornisce la funzione `trans_choice()` per gestire le forme plurali in modo elegante:

```php
// Esempio base
echo trans_choice('messages.notifications', $count, ['count' => $count]);
```

### Sintassi per i Plurali

Nei file di traduzione, è possibile definire le diverse forme utilizzando la seguente sintassi:

```php
// In lang/it/messages.php
return [
    'notifications' => '{0} Non ci sono notifiche|{1} Hai una notifica|[2,*] Hai :count notifiche',
];

// Oppure in JSON (lang/it.json)
{
    "{0} Non ci sono notifiche|{1} Hai una notifica|[2,*] Hai :count notifiche": "{0} Non ci sono notifiche|{1} Hai una notifica|[2,*] Hai :count notifiche"
}
```

### Esempi Pratici

#### Esempio 1: Messaggi di Notifica

```php
// In un controller
$unreadCount = auth()->user()->unreadNotifications()->count();
$message = trans_choice('messages.notifications', $unreadCount, ['count' => $unreadCount]);
```

#### Esempio 2: Prodotti nel Carrello

```php
// In una vista
{{ trans_choice('cart.items', $cart->count(), ['count' => $cart->count()]) }}

// In lang/it/cart.php
return [
    'items' => '{0} Il carrello è vuoto|{1} 1 articolo nel carrello|[2,*] :count articoli nel carrello',
];
```

## Localizzazione di Date e Orari

### Configurazione di Carbon

Carbon è la libreria utilizzata da Laravel per la gestione delle date. Per impostare la localizzazione corretta:

```php
// In AppServiceProvider.php
use Carbon\Carbon;

public function boot()
{
    // Imposta la localizzazione di Carbon
    Carbon::setLocale(config('app.locale'));
    
    // Opzionale: imposta la localizzazione per le date in italiano
    setlocale(LC_TIME, 'it_IT.UTF-8');
}
```

### Formattazione delle Date

```php
// Formattazione di base
$date = now()->isoFormat('dddd D MMMM YYYY');
// Output: "lunedì 3 aprile 2023"

// Formattazione personalizzata
$formatted = $date->translatedFormat('j F Y');
// Output: "3 aprile 2023"
```

### Differenze tra Date

```php
// Differenza in formato leggibile
$postDate = Carbon::parse('2023-01-15');
$diff = $postDate->diffForHumans();
// Output: "2 mesi fa"

// Differenza dettagliata
$diff = $postDate->longRelativeDiffForHumans(now(), 3);
// Output: "2 mesi, 3 settimane e 4 giorni fa"
```

## Localizzazione di Valute e Numeri

### Utilizzo di NumberFormatter

PHP fornisce la classe NumberFormatter per la formattazione di valute e numeri in base alla localizzazione:

```php
// Creazione di un formattatore per la valuta
$formatter = new NumberFormatter('it_IT', NumberFormatter::CURRENCY);
$formatted = $formatter->formatCurrency(1234.56, 'EUR');
// Output: "1.234,56 €"

// Formattazione di numeri
$formatter = new NumberFormatter('it_IT', NumberFormatter::DECIMAL);
$formatted = $formatter->format(1234.5);
// Output: "1.234,5"
```

### Helper Personalizzati

Per semplificare l'utilizzo, possiamo creare degli helper personalizzati:

```php
// In app/helpers.php
if (!function_exists('format_currency')) {
    function format_currency($amount, $currency = 'EUR', $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        
        return $formatter->formatCurrency($amount, $currency);
    }
}

if (!function_exists('format_number')) {
    function format_number($number, $decimals = 2, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $formatter = new NumberFormatter($locale, NumberFormatter::DECIMAL);
        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, $decimals);
        
        return $formatter->format($number);
    }
}
```

## Implementazione nel Progetto

### 1. Creazione dei File di Traduzione

Crea i file di traduzione per le forme plurali in tutte le lingue supportate:

```
lang/
├── it/
│   ├── messages.php
│   └── cart.php
└── en/
    ├── messages.php
    └── cart.php
```

### 2. Aggiornamento del Service Provider

Aggiorna `AppServiceProvider` per configurare correttamente Carbon e NumberFormatter:

```php
// In AppServiceProvider.php
use Carbon\Carbon;
use NumberFormatter;

public function boot()
{
    // Imposta la localizzazione di Carbon
    Carbon::setLocale(config('app.locale'));
    
    // Imposta la localizzazione per le date
    setlocale(LC_TIME, config('app.locale') . '.UTF-8');
    
    // Condivide le lingue disponibili con tutte le viste
    view()->composer('*', function ($view) {
        $view->with('availableLocales', config('laravellocalization.supportedLocales'));
    });
}
```

### 3. Creazione di un Middleware per la Lingua

Crea un middleware per gestire la lingua dell'utente:

```php
// In app/Http/Middleware/SetLocale.php
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
        if (in_array($locale, array_keys(config('laravellocalization.supportedLocales')))) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        }
        
        // 3. Verifica l'header Accept-Language
        if (!Session::has('locale') && $request->hasHeader('Accept-Language')) {
            $preferredLanguage = $request->getPreferredLanguage(
                array_keys(config('laravellocalization.supportedLocales'))
            );
            
            if ($preferredLanguage) {
                App::setLocale($preferredLanguage);
                Session::put('locale', $preferredLanguage);
            }
        }
        
        // Imposta la localizzazione per Carbon
        setlocale(LC_TIME, App::currentLocale() . '.UTF-8');
        \Carbon\Carbon::setLocale(App::currentLocale());
        
        return $next($request);
    }
}
```

### 4. Creazione di un Helper per i Plurali

Aggiungi un helper personalizzato per semplificare la gestione dei plurali:

```php
// In app/helpers.php
if (!function_exists('trans_choice_with_count')) {
    function trans_choice_with_count($key, $count, $replace = [], $locale = null)
    {
        $replace['count'] = $count;
        
        return trans_choice($key, $count, $replace, $locale);
    }
}
```

## Best Practice

1. **Consistenza**
   - Utilizza sempre le funzioni di traduzione per i testi che verranno visualizzati all'utente
   - Mantieni uno stile coerente per le chiavi di traduzione

2. **Performance**
   - Cache le traduzioni in produzione con `php artisan config:cache`
   - Utilizza la cache di Laravel per le traduzioni dinamiche

3. **Manutenibilità**
   - Raggruppa le traduzioni in file logici (es: `auth.php`, `validation.php`)
   - Documenta le chiavi di traduzione complesse con commenti

4. **Accessibilità**
   - Assicurati che le date e i numeri siano formattati correttamente per la lingua dell'utente
   - Utilizza le funzioni di formattazione integrate per garantire la correttezza

## Risoluzione Problemi

### Le traduzioni non vengono caricate
- Verifica che i file di traduzione siano nella cartella corretta
- Assicurati che la chiave di traduzione sia corretta
- Esegui `php artisan config:clear` e `php artisan cache:clear`

### Le date non vengono formattate correttamente
- Verifica che l'estensione `intl` di PHP sia installata e abilitata
- Controlla che la localizzazione sia impostata correttamente in `config/app.php`
- Assicurati che i pacchetti di localizzazione siano installati sul server

### I plurali non funzionano come previsto
- Controlla la sintassi della stringa di traduzione
- Verifica che il conteggio passato a `trans_choice()` sia un numero
- Assicurati che tutte le forme necessarie siano definite nella stringa di traduzione

### Problemi con le valute
- Verifica che il codice valuta sia valido (es: 'EUR', 'USD')
- Controlla che la localizzazione supporti la valuta specificata
- Assicurati che il server abbia i dati di localizzazione installati
