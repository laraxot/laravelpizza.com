---
title: "Topic laravel-localization"
type: digest
status: active
qmd: "digest ceiling 100 laravel-localization"
---

# Topic laravel-localization

Sintesi automatica di 8 documenti (chiave `laravel-localization`).

## Laravel Localization

_Fonte: `laravel-localization-2.md`_

# Laravel Localization

## Introduzione

Il pacchetto `mcamara/laravel-localization` offre un modo semplice per implementare la localizzazione in applicazioni Laravel. Questo documento analizza le funzionalità del pacchetto e suggerisce modifiche utili per il nostro progetto `saluteora`.

## Funzionalità Principali

- **Gestione delle Lingue**: Supporta la gestione di più lingue tramite URL, sessioni o cookie.
- **Middleware**: Include middleware per il redirect basato sulla lingua.
- **URL Localizzati**: Genera URL specifici per ogni lingua supportata.
- **Route Tradotte**: Permette la traduzione dei parametri delle route.
- **Helper**: Fornisce funzioni helper per ottenere informazioni sulla lingua corrente e supportata.

## Analisi del Progetto `saluteora`

Dopo aver analizzato il progetto, ho notato che la localizzazione degli URL è già implementata seguendo la regola fondamentale di includere il prefisso della lingua come primo segmento del percorso (`/{locale}/{sezione}/{risorsa}`). Tuttavia, ci sono aree che possono essere migliorate:

1. **Middleware per Redirect**: Potremmo implementare `LocaleSessionRedirect` o `LocaleCookieRedirect` per gestire automaticamente il redirect basato sulla lingua dell'utente.
2. **URL Localizzati**: Utilizzare gli helper del pacchetto per generare URL localizzati in modo più efficiente.
3. **Route Tradotte**: Implementare la traduzione dei parametri delle route per una user experience più coerente.
4. **Language Selector**: Creare un se

## Guida Completa a Laravel Localization

_Fonte: `laravel-localization-complete-2.md`_

# Guida Completa a Laravel Localization

## Introduzione

Il pacchetto `mcamara/laravel-localization` è una soluzione potente per implementare la localizzazione in applicazioni Laravel. Questa guida, basata sul corso di Laravel Daily, fornisce istruzioni dettagliate per l'installazione, la configurazione e l'uso del pacchetto nel progetto `saluteora`.

## Funzionalità Principali

- **Gestione delle Lingue**: Supporta la gestione di più lingue tramite URL, sessioni o cookie.
- **Middleware**: Include middleware per il redirect basato sulla lingua.
- **URL Localizzati**: Genera URL specifici per ogni lingua supportata.
- **Route Tradotte**: Permette la traduzione dei parametri delle route.
- **Helper**: Fornisce funzioni helper per ottenere informazioni sulla lingua corrente e supportata.

## Installazione

Per installare il pacchetto, seguire questi passaggi:

1. **Installazione del Pacchetto**:
   ```bash
   composer require mcamara/laravel-localization
   ```

2. **Pubblicazione del File di Configurazione**:
   ```bash
   php artisan vendor:publish --provider="Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider"
   ```

3. **Registrazione del Middleware**:
   Modificare il file `app/Http/Kernel.php` per aggiungere i middleware necessari:

## Integrazione tra mcamara/laravel-localization e Laravel Folio

_Fonte: `laravel-localization-folio-2.md`_

# Integrazione tra mcamara/laravel-localization e Laravel Folio

## Obiettivo
Fornire una guida pratica e dettagliata per integrare la localizzazione delle rotte (mcamara/laravel-localization) con il routing file-based di **Laravel Folio**, garantendo URL localizzati, contenuti multilingua e compatibilità con le best practice Laravel.

---

## 1. Cos'è Laravel Folio?
- **Folio** è il sistema di routing file-based introdotto in Laravel 11+, che permette di definire le rotte tramite la struttura delle cartelle e dei file in `resources/views/pages`.
- Ogni file Blade in questa cartella diventa una rotta accessibile via URL.

---

## 2. Sfida dell'integrazione
- **mcamara/laravel-localization** si basa su gruppi di rotte Laravel classici (`Route::group`) per aggiungere il prefisso della lingua e gestire la localizzazione.
- **Folio** genera le rotte in modo automatico, senza passare da `routes/web.php`.
- È necessario assicurarsi che tutte le rotte Folio siano "wrappate" dal middleware di localizzazione e che i path siano localizzati.

---

## 3. Best Practice per l'integrazione

### a) Registrazione delle rotte Folio nel gruppo localizzato
**Soluzione consigliata:**
- Registra Folio **dentro** il gruppo di localizzazione, esattamente come faresti con le rotte classiche.

Esempio in `routes/web.php`:
```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Laravel\Folio\Folio;

## Integration of Mcamara Laravel Localization with Laravel Folio

_Fonte: `laravel-localization-folio-integration-2.md`_

# Integration of Mcamara Laravel Localization with Laravel Folio

## Overview
In the `saluteora` project, providing a multi-language experience with localized URLs is essential for accessibility and SEO. This document explores the integration between [`mcamara/laravel-localization`](https://github.com/mcamara/laravel-localization) and [`laravel/folio`](https://github.com/laravel/folio), ensuring that our page routing system supports language prefixes and locale-specific content in a healthcare context.

## Purpose of Integration
- **Localized URLs**: Enable language prefixes in URLs (e.g., `/en/services`, `/it/servizi`) for better user experience and SEO.
- **Dynamic Page Routing**: Use Laravel Folio for managing page routes directly from Blade files while maintaining locale awareness.
- **Seamless Language Switching**: Ensure users can switch languages without breaking page navigation or losing context.

## Analysis of Components

### Mcamara Laravel Localization
This package provides robust tools for:
- Managing localized routes with prefixes.
- Middleware to detect and set the application locale based on URL or user preference.
- Helpers for generating localized URLs and handling language switching.

Key features relevant to Folio integration:
- **Route Translation**: Automatically prepends locale to routes.
- **Locale Detection**: Determines the current locale from URL segments.
- **URL Generation**: Generates URLs with the appropriate locale prefix via the `route()` and 

## Implementazione della Localizzazione

_Fonte: `laravel-localization-implementation-2.md`_

# Implementazione della Localizzazione 

## Collegamenti correlati
- [Documentazione centrale](/docs/README.md)
- [Collegamenti documentazione](/docs/collegamenti-documentazione.md)
- [Regole Traduzioni Lang](/laravel/Modules/Lang/docs/translation-keys-rules-2.md)
- [Componenti SVG Bandiere](/laravel/Modules/UI/docs/archive/flags-components-2.md)
- [Implementazione Header](/laravel/Themes/One/docs/sections/HEADER_LANGUAGE_USER_DROPDOWN.md)

## Panoramica

<main module> utilizza il pacchetto `mcamara/laravel-localization` per gestire la localizzazione dell'applicazione. Questo documento descrive come implementare correttamente il selettore di lingue e come utilizzare le funzioni del pacchetto.

## Regole Fondamentali

1. **NON creare rotte personalizzate** per la gestione delle lingue (come `language.switch`)
2. **NON creare controller specifici** per la gestione delle lingue
3. Utilizzare **ESCLUSIVAMENTE** le funzioni native del pacchetto `mcamara/laravel-localization`
4. Filament e Folio gestiscono già la localizzazione, non è necessario implementare logiche personalizzate

## Funzioni del Pacchetto `mcamara/laravel-localization`

### Ottenere la Lingua Corrente

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

$currentLocale = LaravelLocalization::getCurrentLocale();
```

## Integrazione avanzata: mcamara/laravel-localization + Laravel Folio

_Fonte: `laravel-localization-integration-2.md`_

# Integrazione avanzata: mcamara/laravel-localization + Laravel Folio

## 1. Introduzione

Questa guida approfondisce l'integrazione tra [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization) e [Laravel Folio](https://github.com/laravel/folio), con focus su:
- Localizzazione delle route Folio (file-based routing)
- Traduzione degli slug e dei parametri dinamici
- Best practice, criticità e raccomandazioni operative

---

## 2. Analisi tecnica e criticità

### 2.1. Come funziona Folio
- Genera route da `resources/views/pages` (ogni file Blade = una route)
- Supporta parametri dinamici (`[slug].blade.php` → `/qualcosa`)

### 2.2. Come funziona mcamara/laravel-localization
- Wrappa le route in un gruppo con prefisso lingua e middleware
- Permette la traduzione degli slug tramite `lang/{locale}/routes.php`
- Offre helper per URL localizzati e parametri tradotti

### 2.3. Punti critici
- Folio **non supporta nativamente** la traduzione degli slug: serve mappatura manuale
- Cache delle route: usare sempre `php artisan route:trans:cache`
- Parametri dinamici: richiedono override custom (vedi sotto)
- Fallback locale: va gestito sia lato Folio che localization

---

## Integrazione di mcamara/laravel-localization con Livewire Volt

_Fonte: `laravel-localization-livewire-volt-2.md`_

# Integrazione di mcamara/laravel-localization con Livewire Volt

## Obiettivo
Fornire una guida pratica per integrare la localizzazione delle rotte e dei contenuti con Livewire Volt, sfruttando le potenzialità di mcamara/laravel-localization.

---

## 1. Cos'è Livewire Volt?
Volt è una sintassi semplificata per creare componenti Livewire, che permette di scrivere componenti reattivi direttamente in Blade, con una sintassi più concisa e moderna.

---

## 2. Sfida dell'integrazione
- **Volt** genera componenti Livewire che vengono richiamati tramite rotte Laravel.
- **mcamara/laravel-localization** lavora a livello di routing, aggiungendo il prefisso della lingua e gestendo la localizzazione delle rotte.
- È necessario assicurarsi che i componenti Volt siano accessibili tramite rotte localizzate e che i contenuti siano tradotti correttamente.

---

## 3. Best Practice per l'integrazione

### a) Registrazione delle rotte Volt nel gruppo localizzato
Assicurati che tutte le rotte che richiamano componenti Volt siano dichiarate all'interno del gruppo di localizzazione:

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),

## Utilizzo di mcamara/laravel-localization

_Fonte: `laravel-localization-usage-2.md`_

# Utilizzo di mcamara/laravel-localization 

## Collegamenti correlati
- [README modulo Lang](./README.md)
- [Best Practices Chiavi di Traduzione](translation-keys-best-practices-3.md)
- [Implementazione Header con Selettore Lingua](/laravel/Modules/User/docs/header-language-selector-with-flags-3.md)
- [Collegamenti Documentazione](/docs/collegamenti-documentazione.md)

## Panoramica

Questo documento descrive come utilizzare correttamente il pacchetto `mcamara/laravel-localization`  per gestire la localizzazione delle URL e l'interfaccia multilingua.

## Regole Fondamentali

1. **MAI creare rotte aggiungendole in web.php**
   - Filament e Folio gestiscono automaticamente le rotte
   - Non creare file di rotte personalizzati

2. **MAI creare controller personalizzati**
   - Utilizzare le funzionalità di Filament e Folio
   - Evitare di creare controller HTTP tradizionali

3. **Gestione della Localizzazione**
   - Utilizzare SEMPRE il pacchetto mcamara/laravel-localization
   - Seguire la documentazione ufficiale: https://github.com/mcamara/laravel-localization
   - Assicurarsi che tutti gli URL includano il prefisso della lingua

## Configurazione

Il pacchetto `mcamara/laravel-localization` è già configurato . La configurazione si trova in:
