---
title: "Topic folio-routing"
type: digest
status: active
qmd: "digest ceiling 100 folio-routing"
---

# Topic folio-routing

Sintesi automatica di 4 documenti (chiave `folio-routing`).

## Folio routing e locale (mcamara/laravel-localization)

_Fonte: `folio-routing-locale.md`_

# Folio routing e locale (mcamara/laravel-localization)

## Come funziona

- **FolioVoltServiceProvider** (modulo Cms) registra le pagine Folio del tema pubblico e dei moduli con **prefisso lingua**.
- Per ogni lingua in **`config('laravellocalization.supportedLocales')`** (es. `it`, `en`) viene registrato un path Folio con **`->uri($locale)`**.
- Risultato: le pagine sono servite sotto **`/{locale}/...`** (es. `/it/`, `/en/events`, `/it/contact`).

## Middleware

- **LocaleSessionRedirect**: salva il locale in session quando è presente in URL; se manca, redirect con locale (da session o Accept-Language).
- **LaravelLocalizationRedirectFilter**: in questo progetto `hideDefaultLocaleInURL` deve restare **false**, quindi `/it/...` non va mai compresso a `/...`.
- Inline: **`app()->setLocale($locale)`** per ogni request Folio.

## Implicazioni per i moduli e il tema

1. **Link**: tutti i link verso pagine pubbliche (home, events, community, login, register, predicts, ecc.) devono usare **`LaravelLocalization::localizeUrl($path)`**. Non usare `url('/events')` o `url(app()->getLocale() . '/events')`.
2. **Form**: le action di form (login, register, submit) devono essere localizzate con **`LaravelLocalization::localizeUrl('/login')`** ecc., altrimenti POST diventa GET dopo redirect.
3. **Componenti**: header, footer, nav, blocchi CTA, auth buttons: ovunque ci sia un `<a href="...">` o `action="..."` verso una pagina localizzata, usare gli helper di mcamara (vedi [laravel-localizati

## Sistema di Routing e Localizzazione con Laravel Folio + Volt

_Fonte: `folio-routing-system-2.md`_

# Sistema di Routing e Localizzazione con Laravel Folio + Volt

## Risorse Ufficiali
- [Laravel Folio Documentation](https://laravel.com/docs/12.x/folio)
- [Livewire Volt Documentation](https://livewire.laravel.com/docs/volt)
- [Volt Class-based API](https://laravel-news.com/livewire-volt-class-based-api)

## Collegamenti correlati
- [Indice documentazione CMS](/laravel/modules/cms/project_docs/index.md)
- [Gestione Route Folio](/laravel/modules/cms/project_docs/gestione-route-folio.md)
- [Frontoffice Flow](/laravel/modules/cms/project_docs/frontoffice-flow.md)
- [Volt Folio Structure](/laravel/modules/cms/project_docs/volt-folio-structure-2.md)
- [Documentazione generale progetto](/project_docs/README.md)

## Panoramica

Il modulo CMS utilizza **Laravel Folio** per gestire le rotte del frontoffice, incluse le rotte localizzate come `/it`, `/en`, ecc. Questo sistema permette di creare pagine dinamiche basate su file di view senza dover definire esplicitamente le rotte.

## Architettura

### Laravel Folio
- **Folio** gestisce automaticamente le rotte basandosi sulla struttura dei file nelle directory `pages`
- Le rotte sono registrate automaticamente nel `CmsServiceProvider`
- Supporta la localizzazione attraverso parametri URI dinamici

### Localizzazione
- Utilizza **Laravel Localization** per gestire le lingue supportate
- Le rotte sono prefissate con il codice lingua (es. `/it`, `/en`)
- La lingua corrente viene determinata automaticamente da `LaravelLocalization::setLocal

## Sistema di Routing e Localizzazione con Laravel Folio

_Fonte: `folio-routing-system.md`_

# Sistema di Routing e Localizzazione con Laravel Folio

## Collegamenti correlati
- [Indice documentazione CMS](/laravel/modules/cms/project_docs/index.md)
- [Gestione Route Folio](/laravel/modules/cms/project_docs/gestione-route-folio.md)
- [Frontoffice Flow](/laravel/modules/cms/project_docs/frontoffice-flow.md)
- [Volt Folio Structure](/laravel/modules/cms/project_docs/volt-folio-structure-2.md)
- [Documentazione generale progetto](/project_docs/README.md)

## Panoramica

Il modulo CMS utilizza **Laravel Folio** per gestire le rotte del frontoffice, incluse le rotte localizzate come `/it`, `/en`, ecc. Questo sistema permette di creare pagine dinamiche basate su file di view senza dover definire esplicitamente le rotte.

## Architettura

### Laravel Folio
- **Folio** gestisce automaticamente le rotte basandosi sulla struttura dei file nelle directory `pages`
- Le rotte sono registrate automaticamente nel `CmsServiceProvider`
- Supporta la localizzazione attraverso parametri URI dinamici

### Localizzazione
- Utilizza **Laravel Localization** per gestire le lingue supportate
- Le rotte sono prefissate con il codice lingua (es. `/it`, `/en`)
- La lingua corrente viene determinata automaticamente da `LaravelLocalization::setLocale()`

## Configurazione nel CmsServiceProvider

```php
public function registerFolio(): void

## Folio Routing System

_Fonte: `themes/folio-routing-system.md`_

# Folio Routing System

## Overview
This document explains the Folio routing system used in the CMS module for handling page routing and language prefixes.

## How It Works

The Folio routing system is integrated with Laravel's routing system to provide a file-based routing approach. Here's how it works:

1. **Page Discovery**: Folio automatically discovers page components in the `resources/views/pages` directory of each theme.

2. **Language Support**: The system supports multi-language routing with language prefixes (e.g., `/it/about`, `/en/about`).

3. **Route Registration**: Routes are registered in the `CmsServiceProvider` with the following middleware stack:
   - `LocaleSessionRedirect` - Handles locale session management
   - `LaravelLocalizationRoutes` - Manages localized routes
   - `LaravelLocalizationRedirectFilter` - Handles language redirection

## Configuration

### Supported Languages
Languages are configured in `config/laravellocalization.php`:

```php
'supportedLocales' => [
    'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'italiano', 'regional' => 'it_IT'],
    'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
],
```
