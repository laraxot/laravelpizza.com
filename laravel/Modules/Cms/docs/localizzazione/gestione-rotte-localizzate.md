# Gestione delle Rotte Localizzate in Laravel Folio

## Introduzione

Questo documento descrive l'implementazione della localizzazione nelle rotte gestite da Laravel Folio all'interno del progetto. La soluzione implementata consente di accedere alle pagine utilizzando prefissi di lingua (es. `/it`, `/en`) mantenendo la compatibilità con l'architettura esistente.

## Problematica

Il sistema presentava i seguenti problemi nella gestione delle rotte localizzate:

1. **Mancata integrazione tra Folio e localizzazione**: Le rotte generate da Folio non gestivano correttamente i prefissi di lingua
2. **Errori nella rotta `/it`**: La rotta principale con prefisso lingua generava errori a causa di variabili non definite
3. **Inconsistenza nella lingua dell'applicazione**: La lingua dell'applicazione non veniva impostata correttamente in base al prefisso dell'URL

## Soluzione Implementata

### 1. Registrazione delle Rotte Folio con Supporto per la Localizzazione

È stato implementato un nuovo metodo `registerFolioRoutes()` nel `CmsServiceProvider` che:

- Registra le rotte Folio per ogni lingua supportata
- Imposta la lingua corrente in base al prefisso dell'URL
- Gestisce anche le rotte senza prefisso di lingua

```php
public function registerFolioRoutes(): void
{
    $xot = $this->xot;
    $theme = $xot->pub_theme;
    $path = base_path('Themes/'.$theme.'/resources/views/pages');
    
    // Verifica che la directory delle pagine esista
    if (!File::exists($path)) {
        return;
    }
    
    // Ottieni le lingue supportate
    $supportedLocales = array_keys(config('laravellocalization.supportedLocales', ['it' => [], 'en' => []]));
    $defaultLocale = config('app.locale', 'it');
    
    // Registra le rotte Folio per ogni lingua supportata
    foreach ($supportedLocales as $locale) {
        Folio::path($path)
            ->uri($locale)
            ->middleware([
                '*' => [
                    function ($request, $next) use ($locale) {
                        app()->setLocale($locale);
                        return $next($request);
                    },
                ],
            ]);
    }
    
    // Registra anche le rotte senza prefisso di lingua
    Folio::path($path)
        ->middleware([
            '*' => [
                function ($request, $next) use ($defaultLocale) {
                    app()->setLocale($defaultLocale);
                    return $next($request);
                },
            ],
        ]);
}
```

### 2. Miglioramento della Gestione della Lingua Predefinita

Nel metodo `boot()` del `CmsServiceProvider` è stata aggiunta una verifica per impostare la lingua predefinita se non è già impostata:

```php
// Imposta la lingua predefinita se non è già impostata
if (!app()->getLocale()) {
    app()->setLocale($defaultLocale);
}
```

### 3. Gestione Robusta delle Variabili nei Componenti Blade

Per risolvere gli errori "Undefined variable" nel componente `<x-page>`, è stata migliorata la gestione delle variabili predefinite:

```php
@php
    $debug = $debug ?? false;
    $blocks = $blocks ?? [];
    $side = $side ?? 'content';
    $slug = $slug ?? '';
    $page = $page ?? null;
@endphp
```

## Vantaggi della Soluzione

1. **Supporto completo per URL localizzati**: Gli utenti possono accedere alle pagine utilizzando prefissi di lingua (es. `/it/home`, `/en/home`)
2. **Coerenza nella lingua dell'applicazione**: La lingua dell'applicazione viene impostata correttamente in base al prefisso dell'URL
3. **Compatibilità con l'architettura esistente**: La soluzione si integra perfettamente con Laravel Folio e il sistema di componenti Blade
4. **Robustezza**: Gestione degli errori e dei casi limite per garantire un funzionamento stabile

## Utilizzo

### Accesso alle Pagine Localizzate

Gli utenti possono accedere alle pagine utilizzando i seguenti formati:

- `/it` - Pagina principale in italiano
- `/en` - Pagina principale in inglese
- `/it/pages/articles` - Pagina degli articoli in italiano
- `/en/pages/articles` - Pagina degli articoli in inglese

### Generazione di URL Localizzati nei Template

Per generare URL localizzati nei template Blade, utilizzare:

```php
{{ url(app()->getLocale() . '/pages/' . $page->slug) }}
```

O, per una soluzione più robusta:

```php
@php
    $currentLocale = app()->getLocale();
    $url = url($currentLocale . '/pages/' . $page->slug);
@endphp
<a href="{{ $url }}">{{ $page->title }}</a>
```

## Best Practices

1. **Utilizzare sempre il prefisso della lingua corrente**: Per garantire coerenza, utilizzare sempre il prefisso della lingua corrente negli URL generati
2. **Testare tutte le lingue supportate**: Verificare che tutte le pagine funzionino correttamente in tutte le lingue supportate
3. **Gestire correttamente i fallback**: Implementare fallback appropriati per le traduzioni mancanti

## Risoluzione dei Problemi

### Errore "Undefined variable"

Se si verificano errori del tipo "Undefined variable" nei componenti Blade, assicurarsi che tutte le variabili utilizzate abbiano valori predefiniti:

```php
@php
    $variabile = $variabile ?? valore_predefinito;
@endphp
```

### Lingua Non Impostata Correttamente

Se la lingua non viene impostata correttamente, verificare:

1. Che la lingua sia presente nella configurazione `laravellocalization.supportedLocales`
2. Che il middleware di localizzazione sia applicato correttamente
3. Che la lingua predefinita sia impostata correttamente in `config/app.php`

## Riferimenti

- [Documentazione Laravel Folio](https://laravel.com/docs/folio)
- [Documentazione Laravel Localization](https://github.com/mcamara/laravel-localization)
- [Modulo Lang - Documentazione](../../../Lang/docs/working-with-locales.md)