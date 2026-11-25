---
title: "Topic events-page"
type: digest
status: active
qmd: "digest ceiling 100 events-page"
---

# Topic events-page

Sintesi automatica di 8 documenti (chiave `events-page`).

## Events Page Analysis

_Fonte: `events-page-analysis.md`_

# Events Page Analysis

## Current Implementation

La pagina `/it/events` attualmente:
1. Usa Folio route `[slug].blade.php`
2. Legge content da `config/local/laravelpizza/database/content/pages/events.json`
3. Renderizza content blocks tramite `<x-page>` component
4. Usa layout pubblico (`<x-layouts.app>` → `<x-layouts.public>`)

## Content Blocks da JSON

Attualmente `events.json` contiene:

### 1. Hero Section
- View: `pub_theme::components.blocks.hero.main`
- Title: "Laravel Developers. Pizza. Community."
- Subtitle: "Join fellow Laravel, Filament..."
- CTAs: "Join the Community", "View Events"

### 2. Features Grid
- View: `pub_theme::components.blocks.features.grid`
- Title: "Why Join Our Community?"
- 4 Features:
  - Regular Meetups (calendar icon)
  - Growing Community (users icon)
  - Multiple Locations (map-pin icon)
  - Real-time Chat (chat icon)

### 3. Stats Section

## Confronto Pagina Events: Locale vs Originale

_Fonte: `events-page-comparison.md`_

# Confronto Pagina Events: Locale vs Originale

**Screenshot**: `docs/screenshots/local-events/` e `docs/screenshots/original-events/`

---

## Stato Attuale

### Locale (`/it/events`) - ROTTO

La pagina mostra un errore:
```
View not found: pub_theme::components.blocks.events.list
```

Il file Blade `components/blocks/events/list.blade.php` non esiste nel tema Meetup.
Dopo l'errore viene mostrato solo il footer.

### Originale (`laravelpizza.com/events`) - FUNZIONANTE

Pagina completa con:
- Header: "Upcoming Events" + subtitle "Join us for pizza and Laravel discussions"
- Filtri: "All Events" | "Upcoming" | "Past Events" (pill buttons)
- Grid 3 colonne con event cards
- 5 eventi di esempio con:
  - Immagine placeholder
  - Badge status (Upcoming/Past, verde/grigio)
  - Titolo evento
  - Descrizione troncata
  - Data (icona calendario)

## events page differences analysis - tema meetup

_Fonte: `events-page-differences-analysis.md`_

# events page differences analysis - tema meetup

## data
[DATE]

## obiettivo
allineare la resa visuale di `/it/events` al design di `https://laravelpizza.com/events`, partendo dalla versione statica:
- `Themes/Meetup/resources/html/events.html`
e mappandola sulla pipeline:
- `Themes/Meetup/resources/views/pages/[slug].blade.php` (folio)
- `config/local/laravelpizza/database/content/pages/events.json` (blocchi)
- `Themes/Meetup/resources/views/components/blocks/events/list.blade.php` (lista eventi).

## stato attuale

### folio page
`Themes/Meetup/resources/views/pages/[slug].blade.php`:
- layout: `<x-layouts.app>`
- contenuto:
  - `@volt('pages.view')`
  - `<x-page side="content" :slug="$slug" />`

quindi `/it/events` risolve slug `events` e carica `events.json`.

### configurazione cms (`events.json`)
attuale configurazione (semplificata):
- blocco `hero` con `pub_theme::components.blocks.hero.main`
- blocco `features` con `pub_theme::components.blocks.features.grid`
- blocco `stats` con `pub_theme::components.blocks.stats.overview`
- blocco `cta` con `pub_theme::components.blocks.cta.banner`

## Events Page Fixes - Implementation Summary

_Fonte: `events-page-fixes-summary.md`_

# Events Page Fixes - Implementation Summary

## Data
[DATE]

## Issues Fixed

### 1. Component Namespace Resolution Error

**Error**: `Unable to locate a class or view for component [pub_theme::components.layouts.main]`

**Root Cause**:
- `CmsServiceProvider.php` was using incorrect `Blade::component()` registration
- Attempted to register view-based components with class-based component syntax

**Solution**:
```php
// BEFORE (WRONG)
Blade::component('pub_theme::components.layouts.main', 'pub_theme::components.layouts.main');

// AFTER (CORRECT)
Blade::anonymousComponentNamespace(
    $theme_type.'::',
    app(FixPathAction::class)->execute(base_path($resource_path.'/views'))
);
```

**File**: `/Modules/Cms/app/Providers/CmsServiceProvider.php:86-89`

### 2. Events Not Displaying on `/it/events`

## Events Page Implementation Plan

_Fonte: `events-page-implementation-plan.md`_

# Events Page Implementation Plan

## Objective

To make the local route `http://127.0.0.1:8000/it/events` visually and functionally identical to `https://laravelpizza.com/events`. This involves ensuring all necessary content blocks are rendered correctly based on `events.json`.

## Problem Description

The `events` page is likely not rendering completely or correctly, possibly showing missing view errors or visual discrepancies, similar to the initial state of the homepage.

## Analysis & Strategy

The user guidance confirms that:
1.  The local `http://127.0.0.1:8000/it/events` route is handled by a Laravel Folio page.
2.  The specific Folio page used is likely `Themes/Meetup/resources/views/pages/[slug].blade.php`.
3.  The content for this page is driven by `config/local/laravelpizza/database/content/pages/events.json`.

The strategy is to:
1.  Fetch the live content from `https://laravelpizza.com/events` to establish the target appearance.
2.  Analyze `events.json` to identify all required content blocks.
3.  Verify if Blade views for these blocks already exist. (Note: The content blocks in the provided `events.json` snippet are identical to those in `home.json`, for which components have already been created: `hero.main`, `features.grid`, `stats.overview`, `cta.banner`).
4.  If new blocks or missing views are identified in `events.json` (compared to `home.json`), create those additional Blade files.
5.  Ensure the `Themes/Meetup/resources/views/pages/[slug].blade.php` cor

## Events Page Implementation

_Fonte: `events-page-implementation.md`_

# Events Page Implementation

## Overview
The events page at `/it/events` is dynamically generated using a Block component and configured via JSON.

## Configuration
The configuration is located in `laravel/config/local/laravelpizza/database/content/pages/events.json`.

```json
{
    "slug": "events",
    "content_blocks": {
        "it": [
            {
                "type": "events",
                "data": {
                    "view": "pub_theme::components.blocks.events.list",
                    "title": "Upcoming Events",
                    "description": "Join us for pizza and Laravel discussions",
                    "query": {
                        "model": "Modules\\Meetup\\Models\\Event",
                        "orderBy": "start_date",
                        "direction": "asc",
                        "limit": 50,
                        "wrap_in": "events"
                    }
                }
            }
        ]
    }

## Events Page - Theme Implementation

_Fonte: `events-page-theme.md`_

# Events Page - Theme Implementation

## Status: ✅ WORKING

The events page at `http://127.0.0.1:8000/it/events` is now displaying events from the database.

## Component

`Themes/Meetup/resources/views/components/blocks/events/list.blade.php`

## Features

- Events loaded dynamically from `Modules\Meetup\Models\Event`
- Scope filtering: `upcoming` scope
- Ordering: by `start_date` ascending
- SEO-friendly URLs with slugs

## Sorgenti del blocco (versione del progetto, non quella generica)

`events/list.blade.php` legge `events_source` dal JSON della pagina CMS (`pages/events.json`, `pages/events/past.json`,
`pages/events/my.json`): `public` (elenco pubblico con filtri citta'/date, `SearchPublicEventsAction`), `user_subscribed`
("I miei eventi", `GetUserRegisteredEventsAction`), nessuna (eventi passati dal CMS). Icone solo come `<x-filament::icon icon="meetup-...">`
(niente SVG inline). Una sincronizzazione con il tema generico aveva rimesso la versione senza `events_source`: l'elenco
`/it/events` usciva senza eventi (`PublicEventsListTest`, `EventVisibilityPageTest`). Ripristinata la versione del progetto e
rimesse in `lang/{it,de,es}/events.php` le chiavi `search.*` (guardia: `ThemeIntegrityTest`).

## Screenshots

- Desktop: `docs/screenshots/events-page-desktop.png`
- Mobile: `docs/screenshots/events-page-mobile.png`

## Events Page Analysis

_Fonte: `events-page.md`_

# Events Page Analysis

> [!NOTE]
> For current technical implementation details, see [Events Page Implementation](events-page-implementation.md).

## = Obiettivo
Trasformare `/it/events` in un vero hub di eventi, replicando il design e le funzionalità di laravelpizza.com/events.

### Expected Results
- **Engagement:** +40% rispetto a pagina statica
- **Conversion:** 5-8% booking rate
- **AOV:** €35-60 per evento
- **Repeat bookings:** 25% clienti partecipano a 2+ eventi

## = File Correlati

- **HTML:** `resources/html/events.html`
- **CSS:** `resources/html/css/app.css` (TailwindCSS)
- **JS:** Inline in events.html (può essere estratto in `js/events.js`)
- **Best Practices:** `BEST_PRACTICES_ANALYSIS.md`
- **Implementation:** `IMPLEMENTATION_SUMMARY.md`

## = Risorse & Referenze

### Research Sources
- UX Project: Pizza App (Medium)
- Food delivery website design examples
- Meetup.com UI patterns
- Eventbrite best practices
- Community engagement strategies
