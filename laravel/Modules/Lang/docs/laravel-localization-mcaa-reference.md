# mcamara/laravel-localization — Riferimento per moduli e temi

## Scopo

Questo documento riassume come il package [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization) è usato nel progetto e come ogni modulo/tema può sfruttarlo.

## Funzionalità principali

- **Prefisso lingua in URL**: tutte le rotte pubbliche localizzate sono sotto `/{locale}/...` (es. `/it/`, `/en/events`).
- **Redirect**: richiesta senza locale → redirect con locale (da session, cookie o Accept-Language).
- **Helper**: generazione URL localizzati, locale corrente, lingue supportate, ordine lingue.
- **Translated routes** (opzionale): segmenti URL tradotti per lingua (es. `/en/about`, `/es/acerca`) tramite `lang/{locale}/routes.php` e `transRoute()`.
- **Route cache**: usare `php artisan route:trans:cache` e trait `LoadsTranslatedCachedRoutes`; non usare `route:cache` per le rotte localizzate.

## Configurazione

- **File**: `config/laravellocalization.php`.
- **supportedLocales**: array di lingue (es. `it`, `en`) con `name`, `script`, `native`, `regional`.
- **hideDefaultLocaleInURL**: se true, la lingua di default non appare in URL.
- **useAcceptLanguageHeader**: rilevamento lingua da browser.
- **localesOrder**: ordine delle lingue (es. per lo switcher).
- **httpMethodsIgnored**: metodi HTTP da non processare per redirect (es. POST, PUT, PATCH, DELETE).

## Uso obbligatorio in Blade (tutti i moduli e temi)

### Link

- Usare **sempre** `LaravelLocalization::localizeUrl($path)` per link verso pagine localizzate (path senza prefisso lingua).

```blade
<a href="{{ LaravelLocalization::localizeUrl('/') }}">Home</a>
<a href="{{ LaravelLocalization::localizeUrl('/events') }}">Events</a>
<a href="{{ LaravelLocalization::localizeUrl('/login') }}">Login</a>
```

### Form

- L’**action** di form (login, register, submit) deve essere localizzata, altrimenti il redirect cambia POST in GET e la validazione usa il locale sbagliato.

```blade
<form action="{{ LaravelLocalization::localizeUrl('/login') }}" method="POST">
```

### Language selector

- Per mantenere la pagina corrente e solo cambiare lingua: **`LaravelLocalization::getLocalizedURL($localeCode, null, [], true)`** (il quarto parametro `true` forza il locale in URL anche se `hideDefaultLocaleInURL` è true).
- Locale corrente: **`LaravelLocalization::getCurrentLocale()`**.
- Elenco lingue: **`LaravelLocalization::getSupportedLocales()`** o **`getLocalesOrder()`**.

## Come aiuta il modulo Lang

- Il modulo Lang **dipende** da mcamara/laravel-localization.
- Fornisce componenti Livewire/Blade per lo switcher lingua e le traduzioni.
- Tutte le view e i componenti che generano link devono usare gli helper sopra; non costruire URL a mano con `app()->getLocale()`.

## Come aiuta Cms (Folio + Volt)

- **FolioVoltServiceProvider** legge `config('laravellocalization.supportedLocales')` e registra Folio con **`->uri($locale)`** per ogni lingua.
- Middleware: **LocaleSessionRedirect**, **LaravelLocalizationRedirectFilter**; per ogni request viene impostato **`app()->setLocale($locale)`**.
- Le pagine pubbliche sono quindi sempre sotto `/{locale}/...`. Qualsiasi link da componenti (header, footer, blocchi) deve usare **`LaravelLocalization::localizeUrl($path)`**.

## Come aiuta Meetup (modulo e tema)

- Link a eventi, community, sponsors, login, register: **`LaravelLocalization::localizeUrl('/events')`** ecc.
- Header e footer: tutti i link già localizzati con `localizeUrl()`; language switcher con **getLocalizedURL($code, null, [], true)**.
- Nuovi link aggiunti in futuro devono seguire lo stesso pattern.

## Come aiuta User (auth)

- Form di login, registrazione, logout: **action** localizzata (es. `LaravelLocalization::localizeUrl('/login')`, `localizeUrl('/logout')`).
- Redirect dopo login/registrazione: verso URL localizzati.

## Test

- Nei test il package non conosce la rotta (bootstrap prima della request). Usare **refreshApplicationWithLocale($locale)**:
  - **putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale)** prima della request.
  - **tearDown** (o afterEach) per pulire l’env.
- Effettuare le request con prefisso locale (es. `$this->get('/en/')`).

Vedi README del package per PHPUnit e Pest.

## Riferimenti

- [Regola progetto](../../../../.cursor/rules/laravel-localization-mcamara.mdc)
- [Memoria](../../../../.cursor/memories/laravel-localization-mcamara.md)
- [README mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)
- [Meetup localization standard](../../Meetup/docs/localization-standard.md)
- [Themes/Meetup localization standard](../../../Themes/Meetup/docs/localization-standard.md)
