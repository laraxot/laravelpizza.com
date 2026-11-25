---
title: "Lingua e pagine Folio/Volt"
type: reference
module: Lang
updated: 2026-11-25
qmd: "folio volt livewire locale uri prefisso lingua SetFolioLocale RedirectUnlocalizedPath named routes route() localizzazione pagine pubbliche"
related:
  - ./laravel-localization-mcamara-reference.md
  - ../../Cms/docs/folio-routing-locale.md
---
# Lingua e pagine Folio/Volt

Come le pagine pubbliche (Folio + Volt) ricevono la lingua. Il codice sta in Cms; Lang fornisce la sorgente delle lingue
(`laravellocalization.supportedLocales`) e le traduzioni. Regole generali sui link: [laravel-localization-mcamara-reference.md](laravel-localization-mcamara-reference.md).

## Come sono montate le pagine

`Modules\Cms\Providers\FolioVoltServiceProvider` monta le cartelle di pagine **una volta per ogni lingua** di `supportedLocales`
(`Folio::path($path)->uri($locale)`):

- la cartella `pages` del tema pubblico (`XotData::make()->getPubThemeViewPath('pages')`);
- `resources/views/pages` di ogni modulo abilitato; la sottocartella `pages/api` e' montata una sola volta su `/api` con il solo middleware `web`.

Le pagine esistono quindi solo sotto `/{lingua}/...`. Ogni montaggio ha questa catena:
`SetFolioLocale`, poi i middleware della chiave `base` del file tenant `config/{tenant}/middleware.php` (con `web` sempre presente),
poi `LaravelLocalizationRoutes`, `LocaleSessionRedirect`, `LaravelLocalizationRedirectFilter`.

## Lingua della richiesta

`SetFolioLocale` sceglie nell'ordine: primo segmento dell'URL se e' una lingua supportata; altrimenti `lang` dell'utente autenticato
se e' supportata; altrimenti `app.locale`. Poi imposta la lingua **sia** su `app()` **sia** su `LaravelLocalization`
(senza la seconda, `localizeUrl()` e `getLocalizedURL()` restano sulla lingua precedente).

## URL senza prefisso

Senza prefisso nessuna rotta Folio corrisponde, quindi `LaravelLocalizationRedirectFilter` non scatta mai e l'utente vedrebbe un 404.
`FolioVoltServiceProvider::boot()` aggiunge al kernel HTTP il middleware globale `RedirectUnlocalizedPath`, che chiama
`RedirectUnlocalizedPathAction`:

- solo GET/HEAD; la home `/` e i percorsi che iniziano gia' con una lingua non si toccano;
- la lingua e' quella negoziata dall'header `Accept-Language` (se `useAcceptLanguageHeader` e' `true`), altrimenti quella di default;
- redirect 302 a `/{lingua}{percorso}` (query string conservata) **solo** se la pagina esiste in una cartella Folio montata per quella lingua; altrimenti resta 404.

## `route()` e nomi di rotta

Le pagine sono montate una volta per lingua con lo stesso nome di rotta e `FolioRoutes` tiene l'ultima: `route('x.view')` puntava
sempre a `/it/...` anche da `/de`. `localizeFolioNamedRoutes()` sostituisce il resolver di Folio con uno che sposta il prefisso sulla
lingua corrente (`app()->getLocale()`), cosi' `route()` resta nella lingua della pagina.

## Volt e Livewire

- I blocchi Volt/Livewire del tema (`resources/views/livewire`, `resources/views/components/blocks`) sono aggiunti ai percorsi Folio.
- Nel progetto non c'e' `Livewire::setUpdateRoute()`: l'endpoint resta `/livewire/update`, fuori dal prefisso di lingua. Nei form
  l'`action` va localizzata (`localizeUrl()`), come per ogni POST.
- Nei test: richieste con prefisso (`$this->get('/en/...')`) e `refreshApplicationWithLocale($locale)`.

## Verifica rapida

- `/events` risponde con redirect a `/it/events` (o alla lingua negoziata) se la pagina esiste.
- `route('...')` da `/de/...` genera URL con `/de`.
- Una lingua aggiunta a `supportedLocales` ha le pagine montate al riavvio dell'app, senza altro codice.

Dettagli di routing e slug delle pagine CMS: [`Modules/Cms/docs/folio-routing-locale.md`](../../Cms/docs/folio-routing-locale.md).
