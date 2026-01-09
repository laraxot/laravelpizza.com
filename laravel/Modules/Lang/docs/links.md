# Gestione delle Traduzioni in Laravel

## Pacchetti Raccomandati

### Gestione Base delle Traduzioni
- [spatie/laravel-translation-loader](https://github.com/spatie/laravel-translation-loader)
  > Pacchetto avanzato per la gestione delle traduzioni che permette di memorizzare le stringhe nel database. Ottimo per progetti che richiedono gestione dinamica delle traduzioni.

- [barryvdh/laravel-translation-manager](https://github.com/barryvdh/laravel-translation-manager)
  > Interfaccia web per gestire le traduzioni. Ideale per team che necessitano di un'interfaccia user-friendly per gestire le stringhe di traduzione.

### Traduzioni Automatiche
- [tanmuhittin/laravel-google-translate](https://github.com/tanmuhittin/laravel-google-translate)
  > Integrazione con Google Translate per traduzioni automatiche. Utile per progetti che necessitano di traduzioni rapide e automatizzate.

### Gestione Modelli Multilingua
- [Astrotomic/laravel-translatable](https://github.com/Astrotomic/laravel-translatable)
  > Soluzione moderna per gestire modelli multilingua. Offre un'API pulita e funzionalità avanzate per la gestione dei contenuti tradotti.

### Gestione UI Multilingua
- [statikbe/laravel-filament-chained-translation-manager](https://github.com/statikbe/laravel-filament-chained-translation-manager)
  > Manager delle traduzioni integrato con Filament. Perfetto per progetti che utilizzano Filament come pannello amministrativo.

## Risorse di Apprendimento

### Tutorial e Guide
- [Laravel Localization Course](https://github.com/LaravelDaily/laravel11-localization-course)
  > Corso completo sulla localizzazione in Laravel 11, con esempi pratici e best practices.

### Pacchetti per Route Multilingua
- [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)
  > Gestione avanzata delle route multilingua. Essenziale per progetti che necessitano di URL localizzati.

## Implementazioni di Esempio

### Formattazione Valuta
```php
if(! function_exists('formatCurrency')) {
    function formatCurrency($amount, $locale = 'en_US', $currency = 'USD')
    {
        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, $currency);
    }
}
```

### Middleware per Impostazione Locale
```php
use Auth;
use Carbon\Carbon;

public function handle(Request $request, Closure $next): Response
{
    if (Auth::check()) {
        app()->setLocale(Auth::user()->language);
        Carbon\Carbon::setLocale(Auth::user()->language);
    } else {
        app()->setLocale(session('locale', 'en'));
        Carbon\Carbon::setLocale(session('locale', 'en'));
    }

    return $next($request);
}
```

### Navigazione Multilingua con Blade
```php
@foreach(config('app.available_locales') as $locale)
    <x-nav-link
        :href="route('change-locale', $locale)"
        :active="app()->getLocale() == $locale">
        {{ strtoupper($locale) }}
    </x-nav-link>
@endforeach
```

## Collegamenti ai Moduli Correlati

### Moduli Core
- [Modulo GDPR](../../../Gdpr/docs/links.md)
  > Documentazione sulla gestione delle traduzioni per il modulo GDPR.

- [Modulo User](../../../User/docs/links.md)
  > Gestione delle traduzioni per l'interfaccia utente e le notifiche.

### Moduli di Supporto
- [Modulo Notify](../../../Notify/docs/links.md)
  > Sistema di notifiche multilingua.

- [Modulo CMS](../../../Cms/docs/links.md)
  > Gestione dei contenuti multilingua.

### Moduli Tematici
- [Theme One](../../../../Themes/One/docs/links.md)
  > Gestione delle traduzioni specifiche per il tema One.

## Best Practices

### 1. Organizzazione
- Utilizzare file di lingua separati per modulo
- Mantenere una struttura gerarchica chiara
- Documentare le chiavi di traduzione

### 2. Performance
- Implementare il caching delle traduzioni
- Utilizzare lazy loading quando possibile
- Ottimizzare le query al database

### 3. Manutenzione
- Mantenere un registro delle modifiche
- Implementare un sistema di backup
- Aggiornare regolarmente le traduzioni

### 4. Sicurezza
- Validare gli input di traduzione
- Implementare controlli di accesso
- Proteggere i file di traduzione

## Comandi Utili

```bash

# Lista delle route tradotte
php artisan route:trans:list {locale}

# Altri comandi utili per la gestione delle traduzioni
php artisan translations:import    # Importa traduzioni
php artisan translations:export    # Esporta traduzioni
php artisan translations:clean     # Pulisce le traduzioni non utilizzate
```

- [Gestione console commands: filosofia e tecnica](./lang-service-provider.md)
- [Filosofia Xot: zen e automazione](./PHILOSOPHY.md)



