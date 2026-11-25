---
title: "Topic events-page"
type: digest
status: active
qmd: "digest ceiling 100 events-page"
---

# Topic events-page

Sintesi automatica di 3 documenti (chiave `events-page`).

## events page differences analysis

_Fonte: `events-page-differences-analysis.md`_

# events page differences analysis

## data
[DATE]

## obiettivo
allineare la pagina `/it/events` (folio + volt + blocchi cms) al design di `https://laravelpizza.com/events`, utilizzando:
- `Themes/Meetup/resources/views/pages/[slug].blade.php` per il routing folio
- `config/local/laravelpizza/database/content/pages/events.json` per la definizione dei blocchi
- componenti blade del tema `Meetup` (`pub_theme::components.blocks.*`)

## stato attuale

### routing
- folio usa `Themes/Meetup/resources/views/pages/[slug].blade.php`:
  - `name('pages.view')`
  - `middleware(PageSlugMiddleware::class)`
  - layout: `<x-layouts.app>`
  - contenuto: `<x-page side="content" :slug="$slug" />`
- quindi `/it/events` risolve slug `events` e carica `events.json`.

### configurazione cms (`events.json`)
attualmente `events.json` è configurato correttamente con il blocco eventi:
```json
{
    "type": "events",
    "slug": "events-list",
    "data": {
        "view": "pub_theme::components.blocks.events.list",
        "title": "Upcoming Events",

## Events Page Implementation

_Fonte: `events-page-implementation.md`_

# Events Page Implementation

## Status: ✅ WORKING

The events page at `http://127.0.0.1:8000/it/events` is now fully functional with events loaded from the database.

## What Was Fixed

### 1. ResolveBlockQueryAction.php
Added support for singular `scope` parameter (was only supporting plural `scopes`).

### 2. Database Events Import
Executed `ImportEventsFromJsonAction` to generate slugs for events in the database.

### 3. events.json Configuration
Added query configuration with `wrap_in: "events"`:
```json
{
  "type": "events",
  "slug": "events-list",
  "data": {
    "view": "pub_theme::components.blocks.events.list",
    "title": "Upcoming Events",
    "subtitle": "Join us for pizza and Laravel discussions",
    "query": {
      "model": "Modules\\Meetup\\Models\\Event",
      "orderBy": "start_date",
      "direction": "asc",
      "limit": 50,
      "wrap_in": "events"

## Events Page - Implementation Status

_Fonte: `events-page-status.md`_

# Events Page - Implementation Status

## Current Status: ✅ Working

URL: `http://127.0.0.1:8000/it/events`

## Events Displayed
1. **Laravel 11 Release Pizza Party** - February 24, 2026
2. **Filament Admin Panel Workshop** - March 10, 2026  
3. **Livewire 3 Pizza Meetup** - March 24, 2026

## Architecture
- **Source**: Database via `Modules\Meetup\Models\Event`
- **Loading**: Dynamic query with scope `upcoming`
- **Ordering**: `start_date` ASC
- **Limit**: 50 events
- **Rendering**: Alpine.js with client-side filtering

## Key Fix Applied
Fixed JSON escaping issue in Alpine.js `x-data` attribute by pre-computing `Js::from()` in PHP variable instead of direct blade echo.

## Files
- Component: `Themes/Meetup/resources/views/components/blocks/events/list.blade.php`
- Model: `Modules/Meetup/app/Models/Event.php`
- Page Config: `config/local/laravelpizza/database/content/pages/events.json`

## SEO
Event detail pages use slug-based URLs: `/events/{slug}` (not ID-based)
