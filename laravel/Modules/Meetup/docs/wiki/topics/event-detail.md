---
title: "Topic event-detail"
type: digest
status: active
qmd: "digest ceiling 100 event-detail"
---

# Topic event-detail

Sintesi automatica di 3 documenti (chiave `event-detail`).

## Event Detail Page - Current State

_Fonte: `event-detail-page-status.md`_

# Event Detail Page - Current State

## Status

Updated on 2026-03-09.

## Active route pattern

- locale aware detail URLs: `/it/events/{slug}`, `/en/events/{slug}`
- Folio entrypoint: `Themes/Meetup/resources/views/pages/[container0]/[slug0]/index.blade.php`
- CMS page rendered: `events.view`
- final detail block: `pub_theme::components.blocks.events.detail`

## 2026-03-09 incident

### User-visible symptom

Clicking an event from `/it/events` did not open the detail page correctly.

### Real failure

The request crashed before normal event fallback logic completed:

- error: `Undefined variable $pageSlug`
- route: `container0.view`

### Root cause

The Folio page introduced redundant derived state (`pageSlug` and `data`) and depended on `mount()` for values that can be computed directly from the route parameters already bound by Volt.

## Event Detail Page - February 2026

_Fonte: `event-detail-page.md`_

# Event Detail Page - February 2026

## URL Structure

- **Local**: `http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party`
- **Target**: `https://laravelpizza.com/events/1` (site currently down)

## Implementation

### Route (Folio)
- File: `Themes/Meetup/resources/views/pages/events/[slug].blade.php`
- Uses Volt component with Livewire
- Model binding by slug (SEO-friendly URLs)

### Component
- File: `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php` (Volt: nome `events.detail` quando il blocco ha `"livewire": "events.detail"`).
- **Pattern**: unica fonte di verità = `Event`; in `mount()` si popolano proprietà pubbliche per la vista (title, date, location, status, ecc.). Vedi tema: `volt-components-usage.md`, `events-detail-volt-class-pattern.md`.
- Displays full event information:
  - Breadcrumb navigation
  - Cover image / placeholder
  - Status badge (Upcoming/Past)
  - Title
  - Date, time, location
  - Language (if set)
  - Attendees count
  - Description
  - CTA button (Register Now)
  - Back to events link

### Model

## Event Detail Page - Technical Requirements

_Fonte: `event-detail-technical.md`_

# Event Detail Page - Technical Requirements

## Analisi Comparativa

Pagina di riferimento: https://laravelpizza.com/events/1
Pagina locale: http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party

## Dati Evento di Riferimento

```json
{
  "title": "Laravel 11 Release Pizza Party",
  "slug": "laravel-11-release-pizza-party",
  "status": "upcoming",
  "date": "2025-12-15",
  "start_time": "18:00",
  "end_time": "21:00",
  "location": {
    "name": "Tech Hub Downtown",
    "address": "123 Main St",
    "coordinates": null
  },
  "description": "Celebrate the release of Laravel 11 with fellow developers! We'll discuss new features, share experiences, and enjoy delicious pizza together. Perfect for both beginners and experienced Laravel developers.",
  "max_attendees": 30,
  "current_attendees": 5,
  "attendees": [
    {"name": "Taylor Otwell", "avatar": "..."},
    "..."
  ],
  "images": 6
