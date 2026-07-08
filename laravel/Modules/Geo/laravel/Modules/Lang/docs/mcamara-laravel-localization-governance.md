# mcamara/laravel-localization Governance

## Fonte primaria studiata

- repository: `mcamara/laravel-localization`
- configurazione locale del progetto: `laravel/config/laravellocalization.php`
- bootstrap middleware aliases: `laravel/bootstrap/app.php`

## Regole che derivano dal pacchetto

### 1. Le route pubbliche devono vivere nel gruppo localizzato

Pattern canonico:

```php
'prefix' => LaravelLocalization::setLocale()
```

con i middleware del pacchetto:

- `localize`
- `localeSessionRedirect`
- `localizationRedirect`
- `localeViewPath`

### 2. Gli URL non si costruiscono concatenando la locale a mano

Usare:

- `LaravelLocalization::localizeUrl('/path')`
- `LaravelLocalization::getLocalizedURL($locale, null, [], true)`

Non usare:

- `url('/' . app()->getLocale() . '/path')`
- stringhe hardcoded tipo `'/it/events'`

### 3. In questo progetto il prefisso locale e' sempre esplicito

La config corrente imposta:

```php
'hideDefaultLocaleInURL' => false
```

Quindi anche la locale di default va mostrata nell'URL.

### 4. I metodi HTTP mutanti sono ignorati dal redirect di localizzazione

La config corrente imposta:

```php
'httpMethodsIgnored' => ['POST', 'PUT', 'PATCH', 'DELETE']
```

Questa scelta evita redirect indesiderati sui submit. I form devono comunque usare action localizzate.

### 5. Cambio lingua

Per language switcher o alternate links usare `getLocalizedURL()`, non sostituzioni manuali del primo segmento path.

## Anti-pattern

- route pubbliche registrate fuori dal gruppo localizzato;
- redirect manuali basati su `app()->getLocale()` concatenato all'URL;
- helper custom `localized_url()` che duplicano il lavoro del pacchetto;
- hardcode di `/it`, `/en`, ecc. nelle Blade.
