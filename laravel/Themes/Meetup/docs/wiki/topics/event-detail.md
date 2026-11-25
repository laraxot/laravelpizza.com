---
title: "Topic event-detail"
type: digest
status: active
qmd: "digest ceiling 100 event-detail"
---

# Topic event-detail

Sintesi automatica di 5 documenti (chiave `event-detail`).

## Analisi Differenze - Event Detail Page

_Fonte: `event-detail-alignment-analysis.md`_

# Analisi Differenze - Event Detail Page

## Obiettivo
Allineare la pagina evento locale (`/it/events/{slug}-{id}`) con la versione produzione di laravelpizza.com (`/events/{id}`).

## Screenshot di Riferimento

| Fonte | URL | Screenshot |
|-------|-----|------------|
| Produzione | https://laravelpizza.com/events/1 | `laravelpizza-events-1-prod.png` |
| Locale | http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party-1 | `laravelpizza-events-local.png` |

---

## Analisi Sezione per Sezione

### 1. Header & Navigation
| Elemento | Produzione | Locale | Stato | Azione |
|----------|------------|--------|-------|--------|
| Logo | LaravelPizza logo | LaravelPizza logo | ✅ OK | - |
| Nav menu | Hamburger mobile | Hamburger mobile | ✅ OK | - |
| Language switch | IT/EN toggle | IT/EN toggle | ✅ OK | - |
| Active state | Evidenzia "Events" | Verificare | 🟡 Check | Verificare highlight |

### 2. Hero Section
| Elemento | Produzione | Locale | Stato | Azione |
|----------|------------|--------|-------|--------|
| Cover gradient | Rosso Laravel (#ef4444) | Simile | ✅ OK | - |
| Event title | H1 grande, bold | Presente | ✅ OK | - |
| Date badge | "In arrivo" / "Upcoming" | Presente | ✅ OK | - |

## Piano di Implementazione - Event Detail Alignment

_Fonte: `event-detail-implementation-plan.md`_

# Piano di Implementazione - Event Detail Alignment

## Obiettivo
Completare l'allineamento della pagina evento locale con la versione produzione di laravelpizza.com.

## Data Inizio
2026-02-18

---

## Sprint 1: Fix Critici (Priorità Alta)

### Issue 1: Attendees Avatars Non Funzionanti 🔴
**File**: `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`

**Problema**: Mostra "NaN" o placeholder vuoti invece degli avatar reali

**Analisi**: 
- `$this->event->attendees_count` potrebbe essere null
- Relazione `attendees()` non caricata o non esistente

**Implementazione**:
```php
// Nel Volt component, aggiungere/migliorare
public function getAttendees(): Collection
{
    if (!$this->event) {
        return collect();
    }

## Event Detail Page - Theme Implementation

_Fonte: `event-detail-page-theme.md`_

# Event Detail Page - Theme Implementation

## Status

Updated on 2026-03-09 after a real review of `/it/events/id-id-quidem-quae-eveniet-Jy1p`.

## Current route/component chain

- Folio route: `Themes/Meetup/resources/views/pages/[container0]/[slug0]/index.blade.php`
- CMS page slug: `events.view`
- Theme presenter: `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`

## Improvements applied

- kept the detail page on localized slug URLs (`/it/events/{slug}`)
- preserved schema.org JSON-LD and social share support
- added clearer event summary badges:
  - status
  - attendance mode
  - free entry
- improved location usefulness:
  - multiline rendering
  - direct map CTA
- added event metadata section when available:
  - organizer
  - registration opening date
  - audience
  - age range
  - topics/keywords
- replaced the misleading fake RSVP state with a real booking modal backed by:

## Event Detail Visual Parity Roadmap

_Fonte: `event-detail-parity.md`_

# Event Detail Visual Parity Roadmap

**Objective**: Ensure `http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party-1` is an exact visual and functional clone of `https://laravelpizza.com/events/1`.

## 📸 Reference Screenshots
*   **Production**: `docs/screenshots/production_event_detail.png` (Pending Capture)
*   **Local**: `docs/screenshots/local_event_detail.png` (Pending Capture)

## 📊 Discrepancy Analysis (High Fidelity)

### 1. Header & Typography
- **Reference**: Large white bold title "Laravel 11 Release Pizza Party" on a dark/slate gradient background.
- **Local**: Currently uses a more complex 2-column layout with a sidebar.
- **Action**: Flatten the header and ensure the title is the focal point with proper alignment.

### 2. Information Blocks (Date/Time/Location)
- **Reference**: Three distinct blocks with rounded icons (light backgrounds) for Date, Time, and Location, arranged horizontally.
- **Local**: Uses a sidebar sidebar for RSVP.
- **Action**: Refactor the information display to match the horizontal block pattern with SVG icons.

### 3. Navigation & Badges
- **Reference**: "< Torna agli eventi" breadcrumb and a vivid green "Upcoming" pill badge.
- **Local**: Uses a custom breadcrumb with multiple levels.
- **Action**: Simplify breadcrumbs and update badge styling to match the reference.

### 4. Background & Accents
- **Reference**: Very dark slate background with subtle glow/gradient effects.
- **Local**: Uses Glassmorphism with orange/blue blurs.


## Event Detail UX gaps - id-id-quidem-quae-eveniet-Jy1p

_Fonte: `troubleshooting/event-detail-ux-gaps-id-id-quidem.md`_

# Event Detail UX gaps - id-id-quidem-quae-eveniet-Jy1p

## URL

`/it/events/id-id-quidem-quae-eveniet-Jy1p`

## Stato verificato

- HTTP: `200 OK`
- Rendering pagina: corretto
- Problema: coerenza UX e microcopy nel dettaglio evento

## Gap confermati

1. Mancano organizer o host anche se il model espone `organizer()` e `owner()`.
2. `event_attendance_mode` non e' mostrato in una forma leggibile per l'utente.
3. La location e' testo grezzo e non aiuta l'utente a capire dove andare o cosa aspettarsi.
4. La CTA RSVP non deve promettere una registrazione se non esiste `registration_url` o backend di iscrizione reale.
5. I metadata opzionali (`audience`, `typical_age_range`, `keywords`, `registration_opens_at`) non vengono valorizzati quando presenti.
6. Il blocco partecipanti deve avere un empty state esplicito e copy coerente.
7. I testi di social share devono restare localizzati.

## Direzione fix (DRY + KISS)

- Tenere `ResolvePageAction` come single source per la risoluzione del model.
- Tenere `events/detail.blade.php` come presenter puro, senza query DB nel path standard.
- Mostrare organizer o host solo se disponibili.
- Rendere esplicita la modalita' di partecipazione.
- Migliorare la location con formattazione, badge e link mappa solo se coerente con il dato.
- Rendere la CTA onesta:
