---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 125 file oltre target 100.

### `02-theme-aration-architecture.md` — Architettura Separazione Tema - Modulo Meetup

# Architettura Separazione Tema - Modulo Meetup

**Stato**: Documentazione fondamentale per il progetto

---

## 🏗️ **Introduzione**

Il modulo Meetup è strettamente legato all'architettura di tema separato del progetto Laravel Pizza. Questa documentazione spiega come il modulo interagisce con il tema e le sue dipendenze.

---

## 📁 **Integrazione Modulo-Tema**

### **Struttura del Modulo**
```
laravel/Modules/Meetup/
├── app/
│   ├── Models/
│   │   └── Event.php                    # Modello Evento

### `accessibility-standards.md` — Accessibility Standards - Meetup Module

# Accessibility Standards - Meetup Module

## Standard: WCAG 2.1 Level AA

All frontend components in the Meetup theme follow WCAG 2.1 AA. See `Themes/Meetup/docs/wcag-accessibility-implementation.md` for the full implementation reference.

## Quick Rules for New Components

### Every interactive element needs:
- `focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2` classes
- Keyboard operability (Enter/Space for buttons, Escape to dismiss overlays)

### Every decorative image/icon needs:
- `aria-hidden="true"` on the element or its container

### Every navigation region needs:
- `<nav aria-label="Descriptive name">` (unique labels when multiple navs exist)

### Every `target="_blank"` link needs:
- `rel="noopener noreferrer"` attribute

### `architecture-reference.md` — 🏗️ Laravel Pizza Meetups - Architecture Reference

# 🏗️ Laravel Pizza Meetups - Architecture Reference

## 🚨 Critical Rule: Front Office Architecture

**For the front office, we use exclusively:**
- ✅ **Laravel Folio** - File-based routing (NO traditional controllers/routes in web.php/api.php)
- ✅ **Laravel Volt** - Declarative components
- ✅ **Filament** - Admin panel and backend UI

**What we do NOT use for front office:**
- ❌ Traditional controllers
- ❌ Routes in web.php/api.php for front office
- ❌ Traditional Laravel views with controller approach

## 📋 Key Principles

- **DRY** - Don't Repeat Yourself
- **KISS** - Keep It Simple, Stupid
- **SOLID** - Object-oriented design principles
- **Robust** - Error-resistant and reliable

### `artisan-serve-analysis.md` — Analisi Comando `php artisan serve`

# Analisi Comando `php artisan serve`

## Data: [DATE]

## Obiettivo
Eseguire `php artisan serve` dalla cartella `laravel` e risolvere eventuali problemi che si presentano.

## Problema Noto Precedente
Dal documento `folio-list-command-analysis.md` sappiamo che c'è un errore:
```
Target class [env] does not exist.
Class "env" does not exist
```

Questo errore si verifica anche con altri comandi artisan, suggerendo un problema nel bootstrap dell'applicazione.

## Piano di Esecuzione

### Fase 1: Preparazione
- [ ] Verificare esistenza file `.env`

### `artisan-serve-solution.md` — Soluzione Problema `php artisan serve`

# Soluzione Problema `php artisan serve`

## Data: [DATE]

## Problema Risolto

Il comando `php artisan serve` ora funziona correttamente. Il server è attivo su `http://127.0.0.1:8000` e risponde correttamente.

## Problemi Identificati e Risolti

### 1. Ricorsione Infinita in `App\Application->make('env')`

**Causa**:
- `App\Application` aveva un override di `make()` che cercava di risolvere "env" come `$this->environment()`
- `AppServiceProvider` registrava un binding `'env'` che chiamava `$app->environment()`
- Questo creava una ricorsione infinita: `make('env')` -> `environment()` -> `$this['env']` -> `make('env')` -> ...

**Soluzione**:
- ✅ Rimosso override di `make()` in `App\Application`
- ✅ Rimosso binding `'env'` in `AppServiceProvider`

### `attendee-registration-domain-rules.md` — Attendee Registration Domain Rules

# Attendee Registration Domain Rules

## Goal
Define deterministic business rules for registering a user to a meetup event.

## Core rules

1. Capacity guard:
   - registration is denied when `attendees_count >= max_attendees`.
2. Duplicate guard:
   - same user cannot register twice for the same event.
3. Counter consistency:
   - successful registration increments `attendees_count` by exactly 1.
4. Atomicity:
   - pivot insert (`event_user`) and counter increment must run in one DB transaction.

## Data model touchpoints

- `events` table (`attendees_count`, `max_attendees`)
- `event_user` pivot (`event_id`, `user_id`)

### `belongs-to-many-x-rule.md` — Architectural Rule: Always Use `belongsToManyX()` Instead of `belongsToMany()`

# Architectural Rule: Always Use `belongsToManyX()` Instead of `belongsToMany()`

## Why

The Laraxot framework provides a **`belongsToManyX()`** method via the `RelationX` trait (used by `XotBaseModel`). This method **must always be used** in place of Laravel's native `belongsToMany()`.

## What `belongsToManyX()` Does Automatically

1. **Auto-discovers the Pivot model** from naming conventions (e.g., `EventUser` for `Event ↔ User`).
2. **Handles cross-database pivot tables** (different DB connections, e.g., `meetup` vs `user`).
3. **Auto-adds `withPivot()` fields** from the pivot model's `$fillable`.
4. **Auto-adds `withTimestamps()`**.
5. **Auto-adds `using(PivotClass)`**.

## DRY / KISS Benefits

Instead of writing:

```php
// ❌ WRONG — verbose, fragile, manually coupling pivot details

### `belongstomanyx-governance.md` — belongsToManyX Governance

# belongsToManyX Governance

## Regola

Nel modulo `Meetup`, e piu' in generale nel progetto, le relazioni many-to-many devono usare `belongsToManyX()`.

`belongsToMany()` va considerato una deviazione architetturale.

## Motivo

- `RelationX` conosce il pattern Laraxot delle pivot.
- riduce configurazione manuale e ripetuta;
- abilita auto-discovery di pivot, fillable e timestamps;
- mantiene compatibilita' con scenari cross-database.

## Esempio corretto

```php
public function attendees(): BelongsToMany
{

### `belongstomanyx-relationship-rule.md` — Meetup belongsToManyX Relationship Rule

# Meetup belongsToManyX Relationship Rule

## Regola

Nel modulo `Meetup` le relazioni many-to-many devono usare `belongsToManyX()`.

Questo vale per le relazioni pubbliche e per quelle che alimentano:

- card eventi;
- pagina dettaglio evento;
- block CMS;
- structured data JSON-LD.

## Relazioni coperte

- `Event::attendees()`
- `Event::performers()`
- `Event::sponsors()`
- `Performer::events()`
- `Sponsor::events()`

### `build-and-copy-workflow.md` — Build e Copy Workflow - Tema Meetup

# Build e Copy Workflow - Tema Meetup

## Data
[DATE]

## Panoramica

Il workflow di build e copy per il tema Meetup consiste in due passaggi:
1. **`npm run build`**: Compila gli asset CSS/JS con Vite
2. niente `npm run copy`: `public_html/themes/<Tema>` è un symlink a `../../laravel/Themes/<Tema>/public`

## Perché Eseguire Questi Comandi?

### 1. `npm run build`

**Scopo**: Compila gli asset frontend (CSS, JS) per la produzione.

**Cosa fa**:
- Esegue TypeScript compiler (`tsc`) per verificare errori TypeScript
- Esegue Vite build che:

### `calendar-events-missing.md` — Sistema Eventi e Calendario - Documentazione Mancante

# Sistema Eventi e Calendario - Documentazione Mancante

## Panoramica
Il sistema di eventi e calendario rappresenta una componente fondamentale del modulo Meetup che è stata pianificata ma non ancora implementata. Questo documento descrive in dettaglio tutte le funzionalità calendaristiche e di gestione eventi mancanti.

## 1. Architettura del Sistema di Eventi

### Modello Evento
```php
// Struttura prevista per il modello Event
- id (primary key)
- title (string) - Titolo dell'evento
- description (text) - Descrizione dettagliata
- start_time (datetime) - Inizio evento
- end_time (datetime) - Fine evento
- timezone (string) - Fuso orario
- location_name (string) - Nome sede
- location_address (text) - Indirizzo completo
- location_lat (decimal) - Latitudine
- location_lng (decimal) - Lo

### `chaos-monkey-event-rendering-playbook.md` — Chaos Monkey Event Rendering Playbook (Meetup Module)

# Chaos Monkey Event Rendering Playbook (Meetup Module)

## Scope

This playbook covers failures in events listing and event detail rendering across CMS blocks and Folio routes.

## Core Dependencies

- Model: `Modules\\Meetup\\Models\\Event`
- Data contract: `Event::toBlockArray()`
- Pages: `events` and `events.view` JSON pages
- Theme blocks: `pub_theme::components.blocks.events.list` and `.detail`

## Invariants

1. `toBlockArray()` must provide localized `url`.
2. Events list block must accept pre-hydrated `events` data.
3. Event detail block must be able to resolve event via `slug0` when `item` is not injected.
4. `events.view` fallback page must exist.


### `chaos-monkey-readiness.md` — Chaos Monkey Readiness (Meetup Module)

# Chaos Monkey Readiness (Meetup Module)

## Obiettivo
Preparare il modulo Meetup a fault randomizzati su pagine eventi, URL localizzati e integrazione CMS.

## Surface Critica
- Modelli eventi e mapping `toBlockArray()` con `url` localizzato
- Pagine Folio/Volt del frontoffice
- Widget Filament per interazioni server-side
- Integrazione con blocchi CMS

## Failure Modes Prioritari
1. URL non localizzati in Alpine (`/events/slug` invece di `/it/events/slug`).
2. Pattern route Folio errato (`container0.view` non rispettato).
3. Regressione su pattern model-first nei componenti Volt.
4. Componenti interattivi implementati in Livewire puro invece di Filament Widget.

## Checklist Diagnostica
1. Verificare che i link frontend usino `event.url` precomputato.
2. Verificare che le pagine dettagli

### `chaos-readiness-toolkit.md` — Chaos Readiness Toolkit - Meetup Module

# Chaos Readiness Toolkit - Meetup Module

## Runner

```bash
bashscripts/quality/chaos-readiness-check.sh --tenant=laravelpizza
```

## Focus Meetup

1. Integrita rendering `events` e `events.view`.
2. Verifica URL localizzate in blocchi dinamici eventi.
3. Verifica regressioni dovute a dipendenze Filament/Livewire.

## Baseline

- Script: `PASSED with warnings`.
- Nessun errore bloccante su JSON/view mapping eventi.

## Remediation prioritarie

### `community-implementation-report.md` — Implementazione Sistema di Meetup/Community - Report Dettagliato

# Implementazione Sistema di Meetup/Community - Report Dettagliato

## 📋 Stato Generale

**Data**: 2026-03-07  
**Progresso Totale**: 67%  
**Moduli Creati**: 10/15  
**Modelli Creati**: 7/15  

## 🎯 Issue #461 - Sistema di gestione meetup

### ✅ Entità Create (10/15)
1. **EventCategory** - ✅ Completato
2. **EventTag** - ✅ Completato  
3. **EventRegistration** - ✅ Completato
4. **EventFeedback** - ✅ Completato
5. **EventSchedule** - ✅ Completato
6. **EventSpeaker** - ✅ Completato
7. **EventSponsor** - ✅ Completato
8. **EventTicket** - ✅ Completato

### `comprehensive-missing-documentation.md` — Comprehensive Missing Documentation and Features List

# Comprehensive Missing Documentation and Features List

## Executive Summary
This document provides a comprehensive analysis of missing documentation and features across the Laravel Pizza project, focusing on modules and themes that require additional documentation.

## Documentation Priority Matrix

### Critical Documentation (High Priority)
These should be created immediately as they affect core functionality:

1. **Activity Module Documentation**
   - Event sourcing implementation guide
   - StoredEvent and Snapshot usage patterns
   - Aggregate root design patterns
   - Event replay and audit trail mechanisms

2. **Security Documentation**
   - Authentication and authorization architecture
   - Multi-tenancy security considerations
   - Input validation and sanitization

### `configuration-environment.md` — Laravel Pizza Configuration & Environment Setup

# Laravel Pizza Configuration & Environment Setup

## Environment Configuration

### Main Environment File (.env)

The main environment configuration file contains essential settings for the application:

```env
APP_NAME=LaravelPizza
APP_ENV=local
APP_KEY=base64:your-app-key-here
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravelpizza
DB_USERNAME=root

### `container0-pattern-philosophy.md` — Filosofia Architetturale: Pattern [container0] Generico

# Filosofia Architetturale: Pattern [container0] Generico

## 🎯 Principio Fondamentale: DRY + CMS-Driven + Scalabilità

Il pattern `[container0]` rappresenta la **filosofia architetturale** di LaravelPizza: **un sistema generico, scalabile e CMS-driven** che evita la creazione di directory specifiche per ogni tipo di contenuto.

## 🏛️ Filosofia: Genericità vs Specificità

### ❌ Approccio Tradizionale (Anti-Pattern)

```
pages/
├── events/
│   ├── index.blade.php
│   └── [slug].blade.php
├── articles/
│   ├── index.blade.php
│   └── [slug].blade.php
├── products/
│   ├── index.blade.php

### `container0-slug0-agnostic-pattern.md` — Pattern [container0]/[slug0] - Agnostic CMS-Driven

# Pattern [container0]/[slug0] - Agnostic CMS-Driven

## 🎯 Principio Fondamentale: Complete Agnosticism

Il file `[container0]/[slug0]/index.blade.php` deve essere **completamente agnostico** e **CMS-driven**. Non deve contenere logica specifica per alcun tipo di contenuto (Event, Article, Product, ecc.).

## ❌ Anti-Pattern: Logica Specifica nel Routing

**NON fare mai questo:**

```php
// ❌ VIETATO - Logica specifica per Event
use Modules\Meetup\Models\Event;

if ($container0 === 'events' && !empty($slug0)) {
    $event = Event::where('slug', $slug0)->first();
    if ($event) {
        return view('pub_theme::components.blocks.events.detail', ['event' => $event]);
    }
}

### `container0-use-x-page-not-content-resolver.md` — Container0 Slug0: Usare `<x-page>` NON `<x-blocks.content-resolver>`

# Container0 Slug0: Usare `<x-page>` NON `<x-blocks.content-resolver>`

## 🎯 Principio: Usare Componente CMS `<x-page>` per Routing Agnostic

**Il file `[container0]/[slug0]/index.blade.php` deve usare `<x-page>` per passare i dati al sistema CMS, NON `<x-blocks.content-resolver>`.**

## ❌ SBAGLIATO: Usare `content-resolver`

**NON fare MAI questo:**

```blade
@volt('container0.view')
<div>
    <!-- ❌ SBAGLIATO: content-resolver contiene logica specifica -->
    <x-blocks.content-resolver :container0="$this->container0" :slug0="$this->slug0" />
</div>
@endvolt
```

**Perché è SBAGLIATO:**

### `contracts/event-published-scope.md` — Event published scope contract

# Event published scope contract

`Event::published()` returns only events whose workflow status is exactly
`published`. Domain filter on the `status` column — not Spatie/CMS
`published_at`.

`HasCommonScopes::scopePublished` (filters `published_at`) must **not** live
on `XotBaseModel`: wiring it there made `Event::scopePublished` a child
override and PHPStan failed (`method.childParameterType` /
`method.childReturnType` on `Builder<$this>` vs `Builder<static(XotBaseModel)>`).
Consumer of `HasCommonScopes`: `Notify\Models\NotificationTemplate` and
`Xot\Models\Module` only (never the base).

Se PHPStan riporta ancora quei 2 errori con il trait gia' fuori da
`XotBaseModel`: e' cache stantia — `./vendor/bin/phpstan clear-result-cache`
poi `analyse Modules`.

The scope filters the internal wor

### `creating-filament-pages.md` — Creating Filament Pages in Modules

# Creating Filament Pages in Modules

This document outlines the correct base classes to use when creating new Filament pages within a module in this project. Adhering to these conventions is crucial for maintaining architectural consistency.

## Dashboard Pages

When creating a dashboard page for a module, the class **must** extend `Modules\Xot\Filament\Pages\XotBaseDashboard`.

This base class is specifically designed for model-less pages that primarily serve to display widgets.

### Example:

```php
// a/Modules/YourModule/Filament/Pages/Dashboard.php

namespace Modules\YourModule\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard

### `creator-profile-contract-governance.md` — Creator ProfileContract Governance

# Creator ProfileContract Governance

Nel modulo Meetup, le annotazioni PHPDoc di audit (`creator`, `updater`, `deleter`) devono usare:

- `\Modules\Xot\Contracts\ProfileContract|null`

Non usare il modello concreto `\Modules\Meetup\Models\Profile` nelle annotazioni audit per evitare coupling inter-modulo.

Questa regola vale anche dopo refresh automatici (`ide-helper:models -W`): se il tool reintroduce tipi concreti, correggere subito in forward-only.

### `critical-dashboard-rules.md` — Critical Rules for MeetupDashboard Implementation

# Critical Rules for MeetupDashboard Implementation

## Rule: MeetupDashboard Must Include Specific Widgets

When enhancing the MeetupDashboard (`Modules/Meetup/app/Filament/Pages/MeetupDashboard.php`), always include the following specific widgets:

1. **MeetupStatsOverviewWidget** - For key event statistics
2. **EventCalendarWidget** - For event visualization 
3. **RecentEventsWidget** - For showing latest events

This ensures the dashboard provides actionable insights specific to meetup management rather than generic content.

## Implementation Pattern

```php
public function getWidgets(): array
{
    return [
        MeetupStatsOverviewWidget::class,
        EventCalendarWidget::class,

### `critical-learnings-session.md` — Critical Learning Session - iFlow CLI

# Critical Learning Session - iFlow CLI

## 📋 Session Summary

### **Date**: [DATE]  
### **Session Type**: Critical Error Analysis and Learning Session  
### **Agent**: iFlow CLI  
### **Learning Focus**: Logo Design, Reference Analysis, and Improvement Process

---

## 🎯 **Critical Error Identified**

### **Error**: Created identical logo instead of improving existing one
- ❌ **Issue**: Generated new logo `/var/www/_bases/base_laravelpizza/laravel/Modules/Meetup/resources/svg/meetup-logo.svg`
- ❌ **Problem**: Same design as existing `/var/www/_bases/base_laravelpizza/laravel/Modules/Meetup/resources/svg/logo.svg`
- ❌ **Result**: Redundant file, no improvement

### **Existing Logo Analysis**
```svg

### `critical-rules-consolidated.md` — Regole Critiche Consolidate - Modulo Meetup

# Regole Critiche Consolidate - Modulo Meetup

## Data
[DATE]

## ⚠️ REGOLE CRITICHE OBBLIGATORIE

### 1. Frontend Asset Management (CSS/JS)

**REGOLA**: Ogni modifica a `resources/css/app.css` o `resources/js/app.js` richiede `npm run build`.

**Comando**:
```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run build
```

**Perché**:
- Vite compila i file source in asset ottimizzati
- Gli asset devono essere copiati in `public_html/themes/Meetup/` per essere accessibili via web

### `current-state-analysis.md` — Analisi Stato Attuale del Progetto

# Analisi Stato Attuale del Progetto

## Data: [DATE]

## Problemi Rilevati

### 1. Environment Issues
Il comando `php artisan folio:list` fallisce con errore:
```
Target class [env] does not exist.
Class "env" does not exist
```

**Cause Probabile**:
- Problemi di autoloading PSR-4
- Classi vendor non correttamente registrate
- Configurazione Laravel non corretta

### 2. Autoloading Issues
Durante `composer dump-autoload` vengono rilevati problemi:

### `dashboard-architecture.md` — Architettura Dashboard - Modulo Meetup

# Architettura Dashboard - Modulo Meetup

## Panoramica

Il dashboard del modulo Meetup (MeetupDashboard.php) rappresenta il centro nevralgico dell'esperienza admin per la gestione degli eventi e delle attività della community. Implementa i principi architetturali fondamentali del progetto Laravel Pizza Meetups basati su Laravel Folio, Laravel Volt e Filament PHP.

## Struttura e Componenti

### MeetupDashboard.php
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Pages;

use Modules\Meetup\Filament\Widgets\EventCalendarWidget;
use Modules\Xot\Filament\Pages\XotBasePage;
use Override;


### `dashboard-implementation-sumy.md` — Dashboard.php Implementation Summary

# Dashboard.php Implementation Summary

**Modulo**: Meetup  
**Status**: ✅ **COMPLETATO E VERIFICATO**

---

## 📋 Implementazione

### File Creato
`Modules/Meetup/app/Filament/Pages/Dashboard.php`

### Struttura
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Pages;


### `dashboard-page-completion.md` — Completamento Dashboard.php - Modulo Meetup

# Completamento Dashboard.php - Modulo Meetup

**Status**: ✅ **COMPLETATO**

---

## 🔍 Analisi Situazione

### File Esistenti
1. **`Dashboard.php`** - Esiste ma è vuoto (solo commenti)
2. **`MeetupDashboard.php`** - Completo con widget, estende `XotBasePage`

### Problema Identificato
Il file `Dashboard.php` è presente ma non implementato. Secondo la documentazione `creating-filament-pages.md`, le Dashboard pages devono estendere `XotBaseDashboard` (non `XotBasePage`).

---

## 🧠 Litigata Interna e Vincitore

### Posizione A: Usare MeetupDashboard.php come base

### `dependency-intelligence.md` — Dependency Intelligence - Module Meetup

# Dependency Intelligence - Module Meetup

Aggiornato da `composer show` il 2026-03-02.

## Runtime dependencies (`require`)

| Package | Constraint | Installed | Area |
|---|---|---|---|
| `saade/filament-fullcalendar` | `^4.0@beta` | `v4.0.0-beta3` | `application-support` |

## Dev dependencies (`require-dev`)

| Package | Constraint | Installed | Area |
|---|---|---|---|
| _(none)_ | - | - | - |

## Declared but missing from installed set

- Nessun pacchetto mancante nel lock corrente.


### `development-workflow-css-js-changes.md` — Workflow Sviluppo - Modifiche CSS/JS

# Workflow Sviluppo - Modifiche CSS/JS

## Data
[DATE]

## ⚠️ REGOLA CRITICA

**OGNI VOLTA che modifichi file CSS (`resources/css/app.css`) o JavaScript (`resources/js/app.js`), DEVI eseguire `npm run build` per vedere le modifiche nel browser.**

## Perché?

### 1. Vite Compilation

I file CSS e JS sono **source files** che devono essere compilati da Vite:
- `resources/css/app.css` → Vite compila Tailwind CSS e genera CSS ottimizzato
- `resources/js/app.js` → Vite bundle JavaScript e genera JS ottimizzato

**Senza build**: Le modifiche ai file source NON sono visibili nel browser.

### 2. Asset Distribution

### `documentation-gaps-analysis.md` — = Analisi Gap Documentazione - Laravel Pizza

# = Analisi Gap Documentazione - Laravel Pizza

> **Data**: 28 Novembre 2024
> **Obiettivo**: Identificare e riorganizzare file .md fuori dalle cartelle docs

## < Executive Summary

**Trovati**: 221 file `.md` fuori dalle cartelle `docs/`
**Esclusi**: `README.md` (permessi ovunque)
**Azione Richiesta**: Spostare/organizzare file nelle cartelle docs appropriate

---

## = Distribuzione File .md

### Per Directory

```bash
# Totale file .md fuori docs (escluso README.md)
221 file

### `documentation-implementation-guide.md` — Documentation Implementation Guide

# Documentation Implementation Guide

## Overview
This guide provides a framework for implementing comprehensive documentation across all modules and themes in the Laravel Pizza project.

## Documentation Standards

### File Naming
- Use descriptive, lowercase names with hyphens
- Include context in filename (e.g., `event-sourcing-integration.md`)
- Maintain consistent terminology

### Content Structure
- Start with clear overview
- Use hierarchical headings (##, ###, etc.)
- Include code examples where appropriate
- Link to related documentation

## Module Documentation Template


### `documentation-naming-rules.md` — Regole di Naming per Documentazione

# Regole di Naming per Documentazione

## Regole Assolute

### ❌ COSA NON FARE MAI
- ❌ **NON** usare caratteri MAIUSCOLI nei nomi file .md
- ❌ **NON** creare nuove cartelle docs - usare quelle esistenti
- ❌ **NON** mettere file .md fuori dalle cartelle docs (eccetto README.md e changelog.md)

### ✅ COSA FARE SEMPRE
- ✅ Usare **solo lowercase** per nomi file .md
- ✅ Usare **hyphens** invece di underscores: `file-name.md` non `file_name.md`
- ✅ **SOLO** README.md e changelog.md possono avere maiuscole
- ✅ Tutti gli altri file .md devono essere in **lowercase**
- ✅ Usare cartelle docs esistenti, NON crearne di nuove

## Esempi Corretti

### ✅ CORRETTO
```

### `env-class-resolution-error.md` — Errore "Target class [env] does not exist" - Analisi Completa

# Errore "Target class [env] does not exist" - Analisi Completa

## Data: [DATE]

## Problema
L'errore "Target class [env] does not exist" si verifica quando si esegue qualsiasi comando artisan, impedendo l'esecuzione di `php artisan serve` e altri comandi.

## Scoperte Chiave

### 1. Il Bootstrap Funziona
```bash
php -r "require 'vendor/autoload.php'; \$app = require_once 'bootstrap/app.php'; echo 'Bootstrap OK';"
# Output: Bootstrap OK ✅
```

### 2. Il Kernel Console Funziona
```bash
php -r "require 'vendor/autoload.php'; \$app = require_once 'bootstrap/app.php'; \$app->make('Illuminate\Contracts\Console\Kernel'); echo 'Console Kernel OK';"
# Output: Console Kernel OK ✅
```

### `error-analysis-pub-theme-namespace.md` — error analysis: pub_theme namespace not found

# error analysis: pub_theme namespace not found

## problema

**errore:** `view not found: pub_theme::components.blocks.hero.main`

**stack trace:** parte da `Themes/Meetup/resources/views/pages/index.blade.php:22`

## analisi del flusso

### 1. entry point: index.blade.php

**file:** `/var/www/_bases/base_laravelpizza/laravel/Themes/Meetup/resources/views/pages/index.blade.php`

```blade
<x-layouts.app>
    @volt('home')
        <div>
            <x-page side="content" slug="home" :type="auth()->user()?->type?->value" />
        </div>

### `event-management-roadmap.md` — Meetup Module - Enterprise Event Management System

# Meetup Module - Enterprise Event Management System

## Overview

The Meetup module provides comprehensive event management capabilities including event creation, registration management, scheduling, venue management, and attendee coordination for modern web applications.

## Current Implementation Status

### 🔴 **State**: Basic/Placeholder  
**Completion**: 10%  
**Priority**: Medium  
**Estimated Development Time**: 8-12 weeks

### Existing Structure
```
Modules/Meetup/
├── app/
│   ├── Models/
│   │   ├── Meetup.php          (Basic)
│   │   ├── Event.php           (Planned)

### `event-sourcing-integration.md` — Event Sourcing Integration

# Event Sourcing Integration

## Overview
The Laravel Pizza project implements event sourcing using the spatie/laravel-event-sourcing package, primarily through the Activity module.

## Core Components

### StoredEvent Model
- Captures all significant domain events
- Maintains event history for audit trails
- Supports event replay for state reconstruction
- Implements proper serialization

### Snapshot Model
- Optimizes event replay performance
- Captures aggregate state at specific points
- Reduces replay time for long-lived aggregates
- Maintains data consistency

### Aggregate Roots

### `events-cms-driven-pages.md` — Events System - CMS-Driven Pages

# Events System - CMS-Driven Pages

## Overview

The events system uses CMS-driven pages with JSON files and Plain Blade components to display event lists and event details.

## REGOLA D'ORO: Plain Blade > Volt!

> **Plain Blade è la scelta migliore quando NON serve interactivity!**

Solo usare Volt/Livewire quando serve:
- Form con validazione server
- Modali interattive
- Dropdown dinamici
- Real-time updates

Per la visualizzazione di eventi: **Plain Blade**!

## Pages


### `events-detail-slug0-loading.md` — Events Detail Component - Slug0 Model Loading

# Events Detail Component - Slug0 Model Loading

## 🎯 Principio: Caricamento Automatico Modello da Slug0

Il componente `events/detail.blade.php` può ricevere `$slug0` tramite i content blocks JSON e caricare automaticamente il modello Event quando necessario.

## 📜 Flusso Completo

### 1. JSON Content Block + Slug0 dalla Route

**File**: `config/local/laravelpizza/database/content/pages/events/view.json`

```json
{
    "slug": "events.view",
    "content_blocks": {
        "it": [
            {
                "type": "events",
                "slug": "events-list",

### `events-detail-volt-class-pattern.md` — Events Detail Component - Plain Blade Pattern

# Events Detail Component - Plain Blade Pattern

## Core Principle: CMS Block Components Are Always Plain Blade

CMS block components in `components/blocks/` are **plain Blade files** — not Volt, not Livewire.
They use a PHP block at the top for variable setup and Alpine.js for client-side interactivity.

The name of this file preserves historical continuity but documents the **correct** pattern,
which is the opposite of what the filename implies: CMS blocks must NOT use Volt.

---

## Why Volt/Livewire Is Wrong for CMS Block Components

The CMS block rendering system uses `@include` (or equivalent PHP `include`) to render blocks:

```php
// Modules/Cms/resources/views/components/page-content.blade.php
@include($block['view'], $block['data'] ?? [])
```

### `events-dynamic-architecture.md` — Architettura Eventi Dinamici - Modulo Meetup

# Architettura Eventi Dinamici - Modulo Meetup

## Panoramica

Il sistema eventi del modulo Meetup utilizza un'architettura **dinamica e configurabile via JSON** che permette di:

1. Caricare eventi dal database usando scope, ordinamenti e limit configurabili
2. Visualizzare eventi hardcoded solo quando necessario (fallback)
3. Supportare SEO con URL basati su slug (non ID numerici)
4. Riutilizzare la stessa configurazione JSON in contesti diversi

## Struttura Architetturale

### 1. Modello Event (Modules/Meetup/app/Models/Event.php)

Il modello fornisce:

**Campi principali:**
- `slug` - Identificatore SEO-friendly univoco
- `title`, `description` - Contenuto evento

### `filament-5-ecosystem-benchmark.md` — Filament 5 Ecosystem Benchmark (Meetup) - 2026-03-02

# Filament 5 Ecosystem Benchmark (Meetup) - 2026-03-02

## Perché serve al modulo Meetup
Il modulo Meetup dipende direttamente da Filament 5, Livewire 4, Folio/Volt e routing localizzato: il confronto con altri base Fila5 riduce rischio di fix non portabili.

## Benchmark sintetico
- Cluster aggiornato: `base_fixcity_fila5`, `base_laravelpizza`.
- Cluster intermedio: `base_techplanner_fila5`.
- Cluster arretrato Fila5: `base_ptv_fila5_mono`.

## Regole operative
1. Per bug su widget/dashboard: confrontare con pattern `filament/filament >= 5.2`.
2. Per bug su pagina frontoffice: validare comportamento su `laravel/folio` stable.
3. Evitare dipendenze da comportamenti di `dev-master` Folio.

## Riferimento
- [Filament 5 Bases Study](../../Xot/docs/filament-5-bases-study-2026-03-02.md)

### `filament-widgets-not-livewire-critical-rule.md` — ⚠️ REGOLA CRITICA: Filament Widgets, NON Livewire Diretto

# ⚠️ REGOLA CRITICA: Filament Widgets, NON Livewire Diretto

## 🎯 Principio Fondamentale

**NEL PROGETTO NON USIAMO LIVEWIRE DIRETTAMENTE - USIAMO SOLO WIDGET FILAMENT!**

Questa è una regola **ASSOLUTA** e **CRITICA** che deve essere sempre rispettata.

Vedi anche: [Themes/Meetup/docs/filament-widgets-not-livewire-critical-rule.md](../../themes/meetup/docs/filament-widgets-not-livewire-critical-rule.md)

## ❌ VIETATO ASSOLUTO

### 1. Componenti Livewire Puri

```php
// ❌ MAI creare componenti Livewire puri
namespace Modules\Meetup\Http\Livewire;

use Livewire\Component;


### `folio-configuration-troubleshooting.md` — Folio Configuration Troubleshooting

# Folio Configuration Troubleshooting

## Issue: "Target class [env] does not exist" Error

### Problem Description
When attempting to run `php artisan folio:list` or other Artisan commands, the following error occurs:
```
Target class [env] does not exist.
Class "env" does not exist
```

### Root Cause Analysis
This error occurs during the Laravel application boot process when the service container attempts to resolve 'env' as a class instead of using the global `env()` helper function. Based on investigation, the issue occurs in the following sequence:

1. `Modules\Cms\Providers\FolioVoltServiceProvider::boot()` calls `TenantService::config('middleware')`
2. The `TenantService::config()` method processes tenant-specific configurations
3. During configuration merging, somewhere in the pro

### `folio-container-routing-priority.md` — Folio Container Routing Priority: index.blade.php vs [slug].blade.php

# Folio Container Routing Priority: index.blade.php vs [slug].blade.php

## Problema

Per la URL `/it/events/laravel-beginners-pizza-night`, Folio usa `[container0]/[container1]/index.blade.php` invece di `[container0]/[slug].blade.php`.

## Causa Tecnica: La Pipeline di Folio

Il file `vendor/laravel/folio/src/Router.php` (linee 55-81) esegue un ciclo `for` su ogni segmento URL. Per ogni segmento, passa lo stato attraverso una **Pipeline** con quest'ordine **fisso e non modificabile**:

```
Step 1: MatchRootIndex                               → /
Step 2: MatchDirectoryIndexViews                      → dir/index.blade.php (dir letterale)
Step 3: MatchWildcardViewsThatCaptureMultipleSegments → [...param].blade.php
Step 4: MatchLiteralDirectories                       → events/ (cartella sta

### `folio-list-command-analysis.md` — Analisi Comando `php artisan folio:list`

# Analisi Comando `php artisan folio:list`

## Data: [DATE]

## Obiettivo
Analizzare e risolvere l'errore del comando `php artisan folio:list` per verificare lo stato delle pagine Folio configurate nel progetto.

## Problema Identificato

### Errore
```
Target class [env] does not exist.
Class "env" does not exist
```

### Analisi Preliminare
L'errore suggerisce che c'è un problema con la risoluzione di dipendenze nel container Laravel. Potrebbe essere:
1. Problema di configurazione Folio
2. Problema con service provider
3. Problema con binding nel container

### `folio-pages-json-only-rule.md` — Regola Critica: Pagine Folio = Solo JSON, NO Blade Files

# Regola Critica: Pagine Folio = Solo JSON, NO Blade Files

## Data
[DATE]

## ⚠️ REGOLA CRITICA OBBLIGATORIA

**PER CREARE UNA NUOVA PAGINA PUBBLICA (FRONTOFFICE), SEGUIRE SEMPRE QUESTA REGOLA:**

### ❌ VIETATO
- **NON creare file Blade** in `Themes/Meetup/resources/views/pages/{slug}.blade.php` per pagine dinamiche
- **NON creare rotte** in `routes/web.php` o `routes/api.php`
- **NON creare controller** per pagine pubbliche

### ✅ OBBLIGATORIO
- **Creare SOLO file JSON** in `config/local/laravelpizza/database/content/pages/{slug}.json`
- Il file `[slug].blade.php` già esiste e gestisce automaticamente tutte le pagine dinamiche
- Il componente `<x-page side="content" :slug="$slug" />` legge automaticamente il JSON corrispondente

## Come Funziona il Sistema

### `folio-route-naming-convention.md` — Folio Route Naming Convention

# Folio Route Naming Convention

## 🎯 Principio Fondamentale: Naming Semantico e Generico

I nomi delle route Folio devono essere **semantici e generici**, non legati ai parametri specifici della route.

## 📜 Convenzione Naming

### Pattern Generale

```
name('{scope}.{action}')
```

Dove:
- `{scope}`: Il contesto della route (container0, pages, auth, ecc.)
- `{action}`: L'azione/ruolo della route (view, index, ecc.)

### Esempi Corretti


### `folio-route-precedence.md` — Folio Route Precedence - Why the Wrong Blade is Matched

# Folio Route Precedence - Why the Wrong Blade is Matched

## Problem

When accessing `/it/events/laravel-beginners-pizza-night`, the wrong Blade file was being rendered.

### Root Cause

The `events` directory was **deleted** from `Themes/Meetup/resources/views/pages/`, so Folio couldn't find the specific route and fell back to the catch-all `[slug].blade.php`.

### Why This Happens

Folio searches for routes in this priority order:

1. **Exact match**: `pages/events/index.blade.php` → `/events`
2. **Static routes**: `pages/about.blade.php` → `/about`
3. **Nested routes**: `pages/events/detail.blade.php` → `/events/detail`
4. **Parameter routes**: `pages/events/[slug].blade.php` → `/events/{slug}`

When the `events` directory doesn't exist, Folio:

### `genesis-starter-kit-analysis.md` — Analisi Genesis Starter Kit - TALL Stack con Folio + Volt

# Analisi Genesis Starter Kit - TALL Stack con Folio + Volt

## Data: [DATE]

## Panoramica

**Genesis** è uno starter kit per il TALL Stack (Tailwind CSS, Alpine.js, Laravel, Livewire) costruito con **Laravel Folio** e **Livewire Volt**. È stato creato da TheDevDojo e rappresenta un esempio pratico e completo di come utilizzare Folio e Volt insieme in un'applicazione reale.

**Repository**: [thedevdojo/genesis](https://github.com/thedevdojo/genesis)
**Articolo Laravel News**: [Genesis is a Starter Kit for the TALL Stack](https://laravel-news.com/genesis-starter-kit)

---

## Caratteristiche Principali

### Stack Tecnologico

- **Laravel**: Framework PHP
- **Livewire 3**: Framework per componenti reattivi
- **Volt**: API funzionale per Livewire (riduce boilerplate)

### `github-repositories-analysis.md` — github repositories analysis - folio + volt patterns

# github repositories analysis - folio + volt patterns

## overview

analisi di 22 repository github reali che implementano Laravel Folio + Volt per estrarre pattern comuni, best practices e architetture consolidate.

**data analisi:** [DATE]
**repository studiati:** 22
**pattern identificati:** 15+

## repository analizzati

1. jasonlbeggs/laravel-news-volt-folio-example
2. benjamincrozat/dummy-store
3. irsyadadl/liosk
4. inmanturbo/b2bsaas0
5. thinkverse/tangerine
6. inmanturbo/b2bsaas
7. jumbaeric/laravel-folio-volt-urlshortener
8. inmanturbo/vflat

### `hero-section-display-issue-analysis.md` — Analisi Problema Visualizzazione Hero Section

# Analisi Problema Visualizzazione Hero Section

## Data
[DATE]

## Problema Identificato

La hero section non viene visualizzata correttamente. Confrontando l'immagine attuale (Image #1) con quella desiderata (Image #2) e con la versione HTML statica, sono state identificate le seguenti differenze:

### Differenze Principali

1. **Titolo non visualizzato correttamente**:
   - **Atteso**: "Laravel Developers." (bianco) + "Pizza. Community." (rosso) su due righe
   - **Attuale**: Il titolo potrebbe non essere visualizzato o formattato male

2. **Struttura dati non allineata**:
   - Il componente hero usa `@props(['data'])` e accede a `$data['subtitle']`, `$data['description']`, etc.
   - Ma `page-content.blade.php` fa `@include($block->view, $block->data)`, che passa le chiavi dell'array co

### `implementation-analysis-sumy.md` — 🎓 LaravelPizza Schema.org Implementation - Complete Status

# 🎓 LaravelPizza Schema.org Implementation - Complete Status

**Date**: [DATE]  
**Status**: ✅ ANALISI COMPLETA - PRONTO PER IMPLEMENTAZIONE

---

## 🎯 Missione Compiuta

Ho condotto un'analisi approfondita dell'architettura LaravelPizza e delle specifiche Schema.org richieste, creando una documentazione completa che rende il progetto pronto per implementare un sistema di gestione eventi **classe mondiale** basato su standard internazionali.

---

## 📊 Risultati dell'Analisi

### ✅ Riepilogo Specifiche Schema.org Studiate

**Tipi Event Principali**:
- **Event** - Tipologia base per tutti gli eventi
- **EventSeries** - Gestione eventi ricorrenti con scheduling ISO 8601

### `implementation-roadmap-final.md` — Roadmap Implementazione Finale - Laravel Pizza Meetups

# Roadmap Implementazione Finale - Laravel Pizza Meetups

## Data: [DATE]

## Panoramica Architettura Finale

### Stack Tecnologico Confermato
- **Frontend**: Laravel Folio + Volt + Tailwind CSS
- **Backend**: Laravel 11.x + Modular Architecture
- **Admin**: Filament PHP
- **Principles**: DRY + KISS + SOLID + Robust + Laraxot

### Pattern Architetturali
- **Genesis Style**: Folio + Volt per rapid prototyping
- **WarriorFolio Style**: Modular components + Filament CMS
- **Hybrid Approach**: Best of both worlds

---

## Fase 1: Foundation Setup (Settimana 1)

### `implementation-roadmap.md` — Roadmap Implementazione - Funzionalità Mancanti

# Roadmap Implementazione - Funzionalità Mancanti

## Panoramica
Questa roadmap descrive l'ordine e le priorità per implementare tutte le funzionalità mancanti del modulo Meetup, con particolare focus sul sistema di eventi e calendario. La roadmap è suddivisa in fasi, con obiettivi specifici, dipendenze e tempistiche stimate.

## Fase 1: Fondamenta (Settimane 1-4) - Alta Priorità

### Obiettivo: Creare la struttura base per il modulo Meetup

#### 1.1 Setup Iniziale Modulo
- [ ] Creare file `module.json` per Meetup
- [ ] Configurare struttura directory completa
- [ ] Impostare provider e routing base
- [ ] Creare database migrations per eventi
- [ ] Implementare modelli base (Event, EventCategory)

**Tempo stimato:** 1 settimana
**Dipendenze:** Nessuna
**Output:** Struttura modulo funzionan

### `kinetic-ux-screenshot-analysis.md` — kinetic ux — screenshot & verifica (modulo meetup)

# kinetic ux — screenshot & verifica (modulo meetup)

## scopo

Questa nota “modulo-side” collega la business logic `Meetup` alla verifica visiva del **tema pubblico** (che è l’interfaccia primaria dell’utente).

In Laraxot, il modulo `Meetup` è **fonte dati e comportamento**, mentre il tema `Meetup` è **presentazione** (Folio/Volt + Blade).

## evidenze (screenshot)

La cattura screenshot e l’analisi sono mantenute nel tema (perché lì vivono layout/blocchi):

- report: `../../Themes/Meetup/docs/visual-analysis/kinetic-ux-baseline.md`
- screenshot: `../../Themes/Meetup/docs/screenshots/grafica-confronto/`

## cosa abbiamo verificato lato modulo

- **routing/events**: la pagina eventi è renderizzata correttamente e usa `event.url` pre-calcolato (URL localizzato).
- **empty state**: messaggi

### `laravel-folio-volt-guide.md` — Laravel Folio + Volt Implementation Guide

# Laravel Folio + Volt Implementation Guide

## Overview

Laravel Folio and Laravel Volt represent a modern approach to building Laravel applications, particularly for front office implementations. This combination provides a clean, efficient way to build dynamic web applications without traditional controllers.

## Laravel Folio

### What is Laravel Folio?

Laravel Folio is a page-based router that simplifies routing in Laravel applications. Instead of defining routes in web.php, you create Blade templates in your application's `resources/views/pages` directory, and Laravel automatically creates routes for them.

### Key Features

- **File-based routing**: Create routes by creating Blade files
- **Automatic route generation**: `/resources/views/pages/events/index.blade.php` becomes `/even

### `laravel-localization-implementation-complete.md` — Laravel Localization Implementation - Laravelpizza (Laravel 12.x)

# Laravel Localization Implementation - Laravelpizza (Laravel 12.x)

## 📋 Overview

Questo documento documenta l'implementazione completa del pacchetto Laravel Localization di mcamara nel progetto Laravel Pizza che segue la filosofia Laravel 12.x con multi-tenant support.

## 🎯 Filosofia Laravel Localization

### **Principi Fondamentali**
- ✅ **Rilevamento automatico lingua browser**
- ✅ **Redirect intelligente con session/cookie**
- ✅ **Routing tradotto centralizzato**
- ✅ **Caching route supportato**
- ✅ **Testing multilingua**
- ✅ **Helper per URL localizzati**

### **Struttura Architetturale**
```
laravel/config/laravellocalization.php
├── supportedLocales          # Lingue supportate

### `laraxot-architectural-compliance.md` — Compatibilità Architetturale Laraxot - Modulo Meetup

# Compatibilità Architetturale Laraxot - Modulo Meetup

## Data
[DATE]

## ✅ Correzioni Implementate

### 1. MeetupServiceProvider
- **Prima**: Estendeva `Illuminate\Support\ServiceProvider`
- **Dopo**: Estende `Modules\Xot\Providers\XotBaseServiceProvider`
- **Benefici**:
  - Codice DRY, funzionalità automatiche
  - Coerenza con architettura Laraxot
  - Configurazione standardizzata

### 2. EventResource
- **Rimosse**: Proprietà vietate in XotBaseResource
  - `$navigationIcon`
  - `$navigationLabel`
  - `$modelLabel`

### `livewire-volt-folio-tutorial-analysis.md` — Analisi Tutorial: Livewire 3, Volt e Folio - Podcast Player

# Analisi Tutorial: Livewire 3, Volt e Folio - Podcast Player

## Data: [DATE]

## Panoramica

Questo documento analizza il tutorial pratico "Learn Livewire 3, Volt, and Folio by building a podcast player" pubblicato su Laravel News. Il tutorial dimostra come costruire un'applicazione completa utilizzando Folio per il routing, Volt per i componenti Livewire, e Livewire 3 per l'interattività.

**Articolo**: [Learn Livewire 3, Volt, and Folio by building a podcast player](https://laravel-news.com/livewire-volt-and-folio)
**Autore**: Jason Beggs
**Repository**: [jasonlbeggs/laravel-news-volt-folio-example](https://github.com/jasonlbeggs/laravel-news-volt-folio-example)

---

## Obiettivo del Tutorial

Costruire un'applicazione che:
1. Elenca episodi di un podcast
2. Permette di riprodurre epi

### `logo-branding-guidelines.md` — Logo e Branding Guidelines - Laravel Pizza Meetups

# Logo e Branding Guidelines - Laravel Pizza Meetups

## Overview

Questo documento definisce le linee guida per l'uso del logo e degli elementi di branding per Laravel Pizza Meetups.

## 🍕 Logo Principale

### SVG Originale da laravelpizza.com

Il logo è uno **spicchio di pizza stilizzato** estratto direttamente da `laravelpizza.com`.

```svg
<svg xmlns="http://www.w3.org/2000/svg"
     width="24"
     height="24"
     viewBox="0 0 24 24"
     fill="none"
     stroke="currentColor"
     stroke-width="2"

### `meetup-dashboard-philosophy.md` — MeetupDashboard Philosophy and Implementation

# MeetupDashboard Philosophy and Implementation

## Date: [DATE]

## Overview

The MeetupDashboard (located at `Modules/Meetup/app/Filament/Pages/MeetupDashboard.php`) serves as the administrative dashboard for the Meetup module. It follows the Filament convention but should provide specific insights relevant to meetup management.

## Architecture Context

- **Front Office**: Uses Folio+Volt for public pages (`/it/events`, `/it`, etc.)
- **Back Office**: Uses Filament for admin panels and management (`/admin/...`)
- **MeetupDashboard**: Filament admin page for meetup-specific metrics and insights

## Current Implementation

- Extends `XotBasePage`
- Uses `meetup-dashboard.blade.php` view
- Contains `EventCalendarWidget`
- Returns 1 column layout

### `meetup-lifecycle-gdpr-profile-gap-analysis.md` — Meetup Lifecycle + GDPR + Profile Gap Analysis

# Meetup Lifecycle + GDPR + Profile Gap Analysis

## Obiettivo

Coprire end-to-end il flusso utente:

1. proposta pizzata/meetup;
2. approvazione staff;
3. visibilita' pubblica solo se approvata;
4. visibilita' privata al proponente con badge `pending`;
5. registrazione RSVP con contatore partecipanti;
6. gestione GDPR in registrazione e aggiornamento preferenze;
7. gestione profilo utente e password.

## Stato attuale (codebase)

### Meetup

- Esiste `Event` con `status` (`draft`/`published`) e `attendees_count`/`max_attendees`.
- Esistono azioni RSVP:

### `meetup-service-provider-laraxot-compliance.md` — MeetupServiceProvider - Conformità Filosofia Laraxot

# MeetupServiceProvider - Conformità Filosofia Laraxot

## Data
[DATE]

## Problema Identificato

Il `MeetupServiceProvider` non rispetta la filosofia Laraxot per i ServiceProvider:

### Violazioni

1. **❌ NON estende `XotBaseServiceProvider`**
   - Estende direttamente `ServiceProvider` invece di `XotBaseServiceProvider`
   - Perde tutta la registrazione automatica (traduzioni, views, config, componenti, comandi)

2. **❌ Duplica logica già presente nel parent**
   - Registra manualmente traduzioni (`registerTranslations()`)
   - Registra manualmente config (`registerConfig()`)
   - Registra manualmente views (`registerViews()`)
   - Tutto questo è già fatto automaticamente da `XotBaseServiceProvider::boot()`

### `meetup-use-cases-implementation.md` — Laravel Pizza Meetups - Practical Implementation Examples

# Laravel Pizza Meetups - Practical Implementation Examples

## overview

questo documento fornisce esempi pratici e pronti all'uso per implementare le funzionalità principali della piattaforma Laravel Pizza Meetups usando Folio + Volt.

**basato su ricerca di progetti reali:**
- Genesis Starter Kit (thedevdojo)
- Laravel News tutorials
- Multi-step form (Neon)
- Podcast Player (Jason Beggs)
- Todo Application (Nuno Maduro)

## use case 1: event listing with live search and filters

**file:** `Themes/Meetup/resources/views/pages/events/index.blade.php`

```blade
<?php
use Modules\Meetup\Models\Event;

### `memories/belongstomanyx-critical.md` — 🚨 CRITICAL MEMORY - belongsToManyX Pattern

# 🚨 CRITICAL MEMORY - belongsToManyX Pattern

## ⚠️ ERRORE GRAVE IDENTIFICATO

**Hai DIMENTICATO la regola FONDAMENTALE del progetto!**

**Non usare MAI**: `$this->belongsToMany()`
**USA SEMPRE**: `$this->belongsToManyX()`

---

## 🎯 REGOLA CRITICA - belongsToManyX

### **PERCHÉ belongsToManyX è OBBLIGATORIO**

1. **Auto-Pivot Management**: Gestisce automaticamente tabella pivot
2. **Cross-Database Compatibility**: Funziona tra database diversi  
3. **WithPivot Automatic**: Include automaticamente campi pivot
4. **Timestamps Automatici**: Created_at/updated_at sulla pivot
5. **Laraxot Pattern**: È il trait standard del progetto

### `memories/database-config-critical.md` — CRITICAL ANALYSIS - Database Configuration Issue

# CRITICAL ANALYSIS - Database Configuration Issue

## 🚨 PROBLEMA GRAVE IDENTIFICATO

**Il tuo file `config/local/laravelpizza/database.php` è SBAGLIATO!**

Hai violato la regola FONDAMENTALE del progetto: **NESSUNA connessione per-modulo nel database config!**

---

## ❌ **COSA HAI SBAGLIATO**

### 1. **Connessioni Modulari VIETATE**
```php
// ❌ SBAGLIATO - TUTTE QUESTE CONNESSIONI VANNO RIMOSE!
'notify' => [...],
'geo' => [...],
'media' => [...],
'job' => [...],
'xot' => [...],

### `memories/svg-no-hardcoded-blade-critical.md` — SVG: NO HARDCODED IN BLADE - REGOLA CRITICA ANALIZZATA

# SVG: NO HARDCODED IN BLADE - REGOLA CRITICA ANALIZZATA

## 🚨 **PROBLEMA GRAVE IDENTIFICATO**

Il logo che ho creato precedentemente era SBAGLIATO! Era hardcoded direttamente nel Blade invece di usare il sistema SVG corretto.

---

## ❌ **ERRORE COMMITTUTO**

### **Logo Precedente (SBAGLIATO)**
```php
// INI FILE SBAGLIATO: Solo 9 righe, troppo semplice!
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
    <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
```

**Problemi**:
- ❌ SVG troppo semplice (9 righe vs 15+ del logo reale)
- ❌ Design basic, non dettagliato

### `memories/theme-resolution-critical.md` — Theme Resolution Critical Memory

# Theme Resolution Critical Memory

## REGOLA CRITICA - Separazione Tema

Il **tema pubblico** non è hardcodat: si ricava dalla configurazione tenant.

### 0. Workflow di Risoluzione Tema (CRITICAL)

1. **`.env`** → `APP_URL` (es. `http://laravelpizza.local`)
2. **Cartella config** → da `APP_URL` il modulo Tenant ricava il nome tenant (es. `local/laravelpizza`) → **`laravel/config/local/laravelpizza`**
3. **`config/local/laravelpizza/xra.php`** → chiave **`pub_theme`** (es. `'Meetup'`)
4. **Tema** → **`laravel/Themes/Meetup`**; view namespace **`pub_theme::`**

### 1. Comandi Tema (OBBLIGATORI dopo modifiche CSS/JS)

```bash
# Dalla cartella del tema
cd laravel/Themes/Meetup

# 1. Install dependencies

### `metatags-component-structure-analysis.md` — Analisi Struttura Componente Metatags

# Analisi Struttura Componente Metatags

## Data
[DATE]

## ⚠️ IMPORTANTE - Struttura Componente

Il componente `<x-metatags>` **già include il tag `<head>` completo** nel suo template. Non è un componente da inserire dentro un `<head>`, ma **sostituisce completamente** il tag `<head>`.

## Struttura Componente

### Template: `Modules/Cms/resources/views/components/metatags.blade.php`

```blade
<head>
    <title>{{ $meta->getTitle() }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- SEO Basics --}}

### `metatags-component-usage.md` — Uso Componente Metatags - Regola Critica

# Uso Componente Metatags - Regola Critica

## Data
[DATE]

## ⚠️ REGOLA CRITICA

**NEVER scrivere manualmente il tag `<head>` nei layout Blade. Usa SEMPRE il componente `<x-metatags>`.**

## Perché?

### 1. Centralizzazione e DRY

Il componente `<x-metatags>` centralizza tutta la gestione dei metatag in un unico punto:
- `Modules/Cms/app/View/Components/Metatags.php` - Logica componente
- `Modules/Cms/resources/views/components/metatags.blade.php` - Template

**Vantaggi:**
- ✅ Modifiche ai metatag in un solo file
- ✅ Consistenza su tutte le pagine

### `migrate-testing-error-analysis.md` — Meetup: Analisi Errori `migrate --env=testing` (2026-03-06)

# Meetup: Analisi Errori `migrate --env=testing` (2026-03-06)

## Contesto verificato

Comando eseguito da `laravel/`:

```bash
php artisan migrate --env=testing -vvv
```

Sequenza osservata nel debugging reale:

1. In sandbox: `SQLSTATE[HY000] [2002]` (falso primario dovuto al contesto di esecuzione).
2. Fuori sandbox: parse blocker transitorio su migration Meetup 2026.
3. Dopo riesecuzione: blocker strutturale persistente su migration Meetup 2025.

## Failure strutturale confermato

Migration:
- `Modules/Meetup/database/migrations/2025_01_01_000008_create_event_user_table.php`

### `migrate-testing-failure-report.md` — Report: Fallimento Strutturale Migration `event_user` (2026-03-06)

# Report: Fallimento Strutturale Migration `event_user` (2026-03-06)

## Situazione Attuale

A seguito di un intervento di "fix" per l'errore `Duplicate column name 'user_id'`, la tabella `event_user` si trova in uno stato inconsistente nell'ambiente di testing.

### Evidenza Empirica

L'ispezione del modello `Modules\Meetup\Models\EventUser` tramite `artisan model:show` rivela la mancanza della colonna `user_id`:

```
  Attributes ............................................................................... type / cast  
  id increments, unique ................................................... bigint(20) unsigned / string  
  event_id fillable ................................................................ bigint(20) unsigned  
  status ...............................................

### `migration-tablecreate-no-outer-guard.md` — Meetup Migration Rule: No Outer `tableExists()` Guard

# Meetup Migration Rule: No Outer `tableExists()` Guard

## Rule

When a migration extends `Modules\Xot\Database\Migrations\XotBaseMigration`, do not wrap `tableCreate()` with an additional outer guard like:

```php
if (! $this->tableExists()) {
    $this->tableCreate(...);
}
```

## Why

- `tableCreate()` already checks table existence internally.
- Double-checks add noise and increase cognitive load.
- Keeping only helper-level guard keeps migrations shorter and consistent.

## Correct Pattern


### `migration-uuid-conversion.md` — Migration UUID Conversion - Meetup Module

# Migration UUID Conversion - Meetup Module

## Conversione Chiavi da bigint a UUID

Il modulo Meetup utilizza UUID per le chiavi primarie. Le migrazioni devono gestire correttamente la conversione.

### ✅ Pattern Corretto per Conversione UUID

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {

### `missing-documentation-analysis.md` — Missing Documentation and Features Analysis

# Missing Documentation and Features Analysis

## Overview
This document analyzes the current state of the Laravel Pizza project and identifies missing documentation and features that should be addressed.

## Module Documentation Gaps

### Core Modules Missing Documentation
1. **Activity Module**
   - Event sourcing patterns documentation
   - StoredEvent and Snapshot usage
   - Integration examples with other modules

2. **Geo Module**
   - Geographic data management
   - Location services integration
   - Address management features

3. **Job Module**
   - Task scheduling capabilities

### `modern-architecture-patterns.md` — Pattern Architetturali Moderni - Sintesi Finale

# Pattern Architetturali Moderni - Sintesi Finale

## Data: [DATE]

## Analisi Comparativa: Genesis vs WarriorFolio

### Genesis Starter Kit
**Focus**: Developer Experience + Rapid Prototyping
- ✅ Folio + Volt nativi
- ✅ File-based routing semplice
- ✅ Componenti UI base
- ✅ Testing integrato
- ❌ Limitata modularità
- ❌ No Filament integration

### WarriorFolio
**Focus**: Enterprise Modularity + No-code Management
- ✅ Architettura modulare avanzata
- ✅ Filament come CMS completo
- ✅ Sistema componenti building blocks

### `module-implementation-guide.md` — Guida Implementazione Modulo Meetup

# Guida Implementazione Modulo Meetup

## 📋 Panoramica

Questa guida descrive come implementare completamente il modulo Meetup per gestire il sistema di ordinazione pizze, integrandolo con l'architettura **Laraxot** (Folio + Volt + Filament).

## 🎯 Obiettivi Implementazione

1. **Implementare modelli Eloquent** seguendo pattern Laraxot
2. **Creare Filament Resources** per admin panel
3. **Implementare Frontend** usando **Folio** (Routing) e **Volt** (Logic)
4. **Gestire business logic** con Actions pattern
5. **NO Controllers, NO Routes files**

## 📁 Struttura Modulo Target

```
Modules/Meetup/
├── app/
│   ├── Actions/                    # Business logic

### `module-integrations-missing.md` — Integrazioni Mancanti tra Moduli

# Integrazioni Mancanti tra Moduli

## Panoramica
Questo documento descrive tutte le integrazioni pianificate ma non ancora implementate tra i diversi moduli del progetto Laravel Pizza. Il sistema utilizza un'architettura modulare che richiede integrazioni ben definite tra i vari componenti.

## 1. Integrazione Meetup con Pizza (Molto Mancante)

### Event Catering Integration
- [ ] **Menu Selection** - Selezione menu specifico per eventi
- [ ] **Group Order System** - Sistema ordini di gruppo per partecipanti
- [ ] **Event Pricing** - Prezzi speciali per eventi
- [ ] **Catering Orders** - Ordini catering per eventi
- [ ] **Dietary Requirements** - Gestione esigenze dietetiche partecipanti

### Event-Based Pizza Features
- [ ] **Themed Pizzas** - Pizze tematiche per eventi
- [ ] **Event Spe

### `npm-commands-execution-rule.md` — Regola Generale: Esecuzione Comandi NPM in Temi e Moduli

# Regola Generale: Esecuzione Comandi NPM in Temi e Moduli

## Data
[DATE]

## ⚠️ REGOLA CRITICA

**I comandi NPM (`npm install`, `npm run build`, `npm run dev`, etc.) DEVONO essere eseguiti SEMPRE nella directory root del tema o modulo, NON nella root del progetto Laravel.**

## Perché?

### 1. Risoluzione Path Relativi

Ogni tema/modulo ha il suo `vite.config.js` che usa `resolve(__dirname, ...)` per risolvere i path:

```javascript
// vite.config.js in Themes/Meetup/
import { resolve } from 'path';

export default defineConfig({

### `package-dependency-chaos-map.md` — Package Dependency Chaos Map (Meetup)

# Package Dependency Chaos Map (Meetup)

## Catalogo completo
- [Composer Packages Full Catalog (2026-03-02)](../../Xot/docs/composer-packages-full-catalog-2026-03-02.md)

## Pacchetti studiati rilevanti
- `laravel/framework`
- `laravel/folio`
- `livewire/livewire`
- `livewire/volt`
- `filament/filament`
- `mcamara/laravel-localization`
- `spatie/laravel-data`

## Rischi principali
1. Regressioni route/page su Folio e binding Volt.
2. Interazioni server-side non allineate ai widget Filament.
3. URL non localizzati in rendering dinamico eventi.

## Test operativo minimo

### `phpstan-errors-roadmap.md` — PHPStan Level 10 Errors Roadmap - Meetup Module

# PHPStan Level 10 Errors Roadmap - Meetup Module

**Modulo**: Meetup  
**Livello PHPStan**: 10  
**Status**: 🧘 **IN ANALISI**

---

## 📊 Errori Identificati

### Totale Errori: 2

1. **`app/Actions/Event/CreateEventAction.php`** (Linea 24)
   - **Errore**: `Variable $event in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

2. **`app/Actions/Event/DeleteEventAction.php`** (Linea 21)
   - **Errore**: `Variable $result in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`


### `piano-completamento-progetto.md` — Piano di Completamento Progetto - Laravel Pizza Meetups

# Piano di Completamento Progetto - Laravel Pizza Meetups

## Data: [DATE]

## 📊 Stato Attuale

### ✅ Completato

#### Frontend HTML Statico
- ✅ Homepage (index.html) - Design dark theme allineato a laravelpizza.com
- ✅ Events page (events.html) - Lista eventi con filtri
- ✅ Dashboard (dashboard.html) - Overview personale con statistiche
- ✅ Profile (profile.html) - Profilo utente completo
- ✅ Community Chat (chat.html) - Interfaccia chat con canali
- ✅ Login (login.html) - Pagina autenticazione
- ✅ Register (register.html) - Pagina registrazione
- ✅ Componenti riutilizzabili (navigation.html, footer.html)
- ✅ JavaScript per interattività (navigation.js, footer.js, app.js)
- ✅ Tailwind CSS configurato e funzionante


### `progetto-completamento-esteso.md` — Laravel Pizza Meetups - Piano di Completamento Esteso

# Laravel Pizza Meetups - Piano di Completamento Esteso

## Scopo del Progetto

**Laravel Pizza Meetups** è una piattaforma community per sviluppatori Laravel che organizza meetup, workshop e eventi tech dove si condivide pizza e conoscenza.

**IMPORTANTE**: NON è un sito e-commerce per vendere pizza, ma una metafora per eventi tech informali.

## Analisi dello Stato Attuale

### Cosa è già Implementato
- ✅ Modulo Meetup con modello Event base
- ✅ Tema HTML statico con design dark theme
- ✅ Documentazione estensiva in italiano e inglese
- ✅ Architettura modulare Laravel
- ✅ Integrazione Filament per admin panel

### Cosa Mancano
- ❌ Collegamento tema HTML con backend Laravel
- ❌ Sistema RSVP eventi funzionante

### `project-completion-plan.md` — Laravel Pizza Meetups - Project Completion Plan

# Laravel Pizza Meetups - Project Completion Plan

## Project Overview
Complete the Laravel Pizza Meetups community platform that connects Laravel developers through pizza-fueled meetups and events.

## Phase 1: Foundation & Core Features (Weeks 1-3)
### Week 1: Setup & User Management
- [ ] Complete user authentication system using Folio + Volt (login, register, profile)
- [ ] Implement user profiles with bio, interests, and social links using Volt components
- [ ] Set up user dashboard with activity statistics using Folio pages
- [ ] Create user management system for admins using Filament

### Week 2: Event Management
- [ ] Develop event creation using Filament admin panel
- [ ] Implement event registration and attendance tracking using Volt components
- [ ] Create event listing pages wi

### `pub-theme-component-namespace-error-analysis.md` — Analisi Errore Namespace Componente pub_theme

# Analisi Errore Namespace Componente pub_theme

## Data
[DATE]

## Problema Identificato

**Errore**: `Unable to locate a class or view for component [pub_theme::components.layouts.main]`

### Causa Root

Il componente `<x-pub_theme::components.layouts.main>` viene usato in `index.blade.php`, ma Laravel non riesce a risolverlo.

### Analisi Tecnica

#### 1. Registrazione Namespace

`CmsServiceProvider::registerNamespaces()` registra:
- **View Namespace**: `app('view')->addNamespace('pub_theme', $theme_dir)`
- **Anonymous Component Path**: `Blade::anonymousComponentPath($componentViewPath)`

### `roadmap/01-current-state.md` — Current State - Meetup

# Current State - Meetup

## Baseline

- Stato attuale documentato nei file `docs/` del Modulo.
- Presenza di roadmap strutturata in sotto-file.
- Necessita verifica periodica di coerenza tra codice e documentazione.

## Immediate checks

1. Coerenza tra regole architetturali e implementazione runtime.
2. Coerenza tra naming, namespace e percorsi view/traduzioni.
3. Copertura test minima per i flussi critici.

### `roadmap/03-workstreams.md` — Workstreams - Meetup

# Workstreams - Meetup

## WS1 Architecture

- Verifica confini e responsabilita dei componenti.
- Aggiornamento pattern e guardrail.

## WS2 Reliability

- Hardening dei flussi principali.
- Miglioramento fallback e recovery path.

## WS3 Documentation

- Consolidamento documenti canonici.
- Eliminazione drift documentale.

## WS4 Testing

- Test funzionali mirati sui percorsi ad alto rischio.

### `routing-no-business-logic.md` — Routing File: NO Business Logic - Critical Rule

# Routing File: NO Business Logic - Critical Rule

## 🚨 REGOLA CRITICA: Nessuna Logica di Business nel Routing

Il file `[container0]/[slug0]/index.blade.php` **NON DEVE MAI** contenere logica di business, query al database, o decisioni su quale componente renderizzare.

## ❌ SBAGLIATO: Logica nel Routing

**NON fare MAI questo:**

```php
<?php
// ❌ VIETATO ASSOLUTAMENTE
use Modules\Cms\Models\Page as PageModel;
use Modules\Meetup\Models\Event;

new class extends Component {
    public function mount(): void
    {
        // ❌ VIETATO: Query al database nel routing

### `rules-testing-no-migrate-fresh.md` — CRITICAL ARCHITECTURE RULE: NO MIGRATE:FRESH

# CRITICAL ARCHITECTURE RULE: NO MIGRATE:FRESH

## Rule
**NEVER** use `migrate:fresh` or the `RefreshDatabase` trait in any test or setup script within this modular architecture (Laraxot).

## Why?
1. **Destructive**: It destroys all tables across the default database connection.
2. **Tenant/Module Coupling**: In a modular application, tables are meant to be isolated. Wiping the entire database crashes other concurrently running tests or removes shared look-up tables that are not seeded correctly per-module.
3. **Data Loss**: Running tests with `RefreshDatabase` against a shared testing database will indiscriminately destroy other modules' data.

## Correct Approach
- Only use `DatabaseTransactions` to rollback state after tests.
- Maintain strict database boundaries.

### `service-provider-architectural-violation.md` — Violazione Architetturale: MeetupServiceProvider

# Violazione Architetturale: MeetupServiceProvider

## Data
[DATE]

## ❌ Problema Identificato

Il `MeetupServiceProvider` viola la filosofia Laraxot perché:

1. **Non estende XotBaseServiceProvider**
   - Estende direttamente `Illuminate\Support\ServiceProvider`
   - Mancano funzionalità standardizzate Laraxot

2. **Logica duplicata**
   - Implementa manualmente funzionalità già presenti in XotBaseServiceProvider
   - Violazione principio DRY

3. **Mancanza pattern standard**
   - Non segue pattern architetturale degli altri moduli
   - Incoerenza con resto del codebase

### `stack-upstream-deep-study-folio-volt-livewire4-filament5.md` — Stack Upstream Deep Study: Folio, Volt, Livewire 4, Filament 5

# Stack Upstream Deep Study: Folio, Volt, Livewire 4, Filament 5

## Fonti ufficiali studiate

- `https://github.com/laravel/folio`
- `https://github.com/livewire/volt`
- `https://livewire.laravel.com/docs/4.x/components`
- `https://github.com/filamentphp/filament/tree/5.x`
- `https://github.com/filamentphp/spatie-laravel-google-fonts-plugin`

## Sintesi tecnica applicabile a LaravelPizza

### Folio

- Router page-based per file in `resources/views/pages`.
- Helper inline ufficiali:
  - `name(string)`
  - `middleware(Closure|string|array)`
  - `render(callable)`
  - `withTrashed(bool)`

### `suggestions-doubts-solutions.md` — Laravel Pizza Meetups - Suggestions, Doubts & Solutions

# Laravel Pizza Meetups - Suggestions, Doubts & Solutions

## Executive Summary

This document outlines key suggestions, potential doubts, and proposed solutions for the Laravel Pizza Meetups project. These insights are based on the project's current state and architectural decisions.

## Suggestions for Improvement

### 1. Architecture & Structure

**Suggestion**: Implement a more granular event categorization system
- **Benefit**: Better event discovery and user experience
- **Implementation**: Create hierarchical categories (e.g., Laravel → Advanced Topics → Eloquent) using Laravel Folio + Volt approach

**Suggestion**: Add event series functionality
- **Benefit**: Allow recurring events with variations
- **Implementation**: Create Series model that can contain multiple Event instances,

### `svg-icons-no-hardcoded-blade.md` — SVG: file .svg e icone Meetup (no inline nelle Blade)

# SVG: file .svg e icone Meetup (no inline nelle Blade)

## Filosofia

- **Un’icona = un file** in `Modules/Meetup/resources/svg/`.
- **Nessun SVG inline** nelle Blade: si inquina il template e si duplica il markup. Tutte le icone del modulo/tema Meetup (logo, nav, social) vivono in file `.svg` e si richiamano con `<x-filament::icon icon="meetup-{nome}" />`.

## Dove sono i file

- **Path**: `laravel/Modules/Meetup/resources/svg/`.
- **Registrazione**: il set è registrato da `XotBaseServiceProvider` (Xot) con prefix `meetup`; il path è risolto da `GetModulePathByGeneratorAction` (assets) + `../svg`. Ogni file `nome.svg` diventa icona `meetup-nome`.

## Convenzione nomi

- **Logo**: `logo.svg` → `meetup-logo`.
- **Nav**: `icon-calendar.svg`, `icon-community.svg`, `icon-sponsors.svg`, `icon-

### `svg-icons-system-complete.md` — SVG Icon System - Complete Implementation Guide

# SVG Icon System - Complete Implementation Guide

## 🎯 **SUMMARY ESECUTIVO**

Ho analizzato a fondo il problema del logo e creato un sistema SVG professionale che rispetta tutti gli standard del progetto:

- ✅ **SVG Files Esterni** - Non più hardcoded in Blade
- ✅ **Logo Premium** - Dettagliato con 15+ elementi grafici  
- ✅ **Icon System** - Nomenclatura standard per riutilizzo
- ✅ **Filament Integration** - `<x-filament::icon>` con prefissi registrati
- ✅ **Designer Autonomy** - Separazione design/sviluppo
- ✅ **Performance** - Asset caching e ottimizzazione

---

## 📁 **STRUTTURA FILES CREATA**

```
Modules/Meetup/resources/svg/
├── logo-header.svg          # Logo principale header (100x100)

### `tailwind-best-practices.md` — Best Practices Tailwind CSS - Modulo Meetup

# Best Practices Tailwind CSS - Modulo Meetup

## 📋 Panoramica

Questo documento descrive le best practices per l'utilizzo di Tailwind CSS nel tema Meetup e nel modulo.

## 🎯 Principi Fondamentali

### 1. Utility-First
Usa sempre le utility class di Tailwind invece di CSS custom quando possibile.

```blade
{{-- ✅ Buono --}}
<div class="flex items-center justify-between p-6 bg-white rounded-lg shadow-md">

{{-- ❌ Evitare --}}
<div class="custom-card">
```

### 2. Responsive Design

### `tailwind-error-unknown-utility-px6.md` — Tailwind Error: `Cannot apply unknown utility class `px-6``

# Tailwind Error: `Cannot apply unknown utility class `px-6``

## Contesto

- Modulo: **Meetup**
- Tema: **Themes/Meetup** (HTML statici con Vite 7 + Tailwind 4 via `@tailwindcss/vite`)
- Ambiente: dev server Vite avviato in `laravel/Themes/Meetup/resources/html`
- File coinvolti:
  - `laravel/Themes/Meetup/resources/html/events.html`
  - `laravel/Themes/Meetup/resources/html/css/app.css`

## Sintomo

In console Vite, durante `npm run dev`:

```text
[plugin:@tailwindcss/vite:generate:serve] Cannot apply unknown utility class `px-6`. Are you using CSS modules or similar and missing `@reference`?
/var/www/_bases/base_laravelpizza/laravel/Themes/Meetup/resources/html/events.html
```


### `task-creare-test-suite.md` — Task: Creare Test Suite Completa - Meetup

# Task: Creare Test Suite Completa - Meetup

**Modulo**: Meetup
**Priorita'**: Critica
**Completamento**: 0%

---

## Descrizione

Il modulo Meetup ha ZERO file di test. Essendo il modulo core business, e' critico avere copertura test.

## Test da Creare

### Unit Tests
- [ ] Event model: creazione, validazione, stati
- [ ] Registration model: RSVP, capacita', waitlist
- [ ] Speaker model: profilo, eventi associati

### Feature Tests

### `task-education-events.md` — Task: Implement Education Events

# Task: Implement Education Events

**Priority**: MEDIUM
**Status**: TODO
**Estimated Effort**: 1 day
**Reference**: [Schema.org EducationEvent](https://schema.org/EducationEvent)

---

## Objective

Support EducationEvent type for workshops, training sessions, and hackathons with proper Schema.org structured data.

---

## Key Properties

| Property | Type | Description |
|----------|------|-------------|
| `teaches` | DefinedTerm/Text | Competencies taught |

### `task-food-establishments.md` — Task: Implement Food Establishment Integration

# Task: Implement Food Establishment Integration

**Priority**: MEDIUM
**Status**: TODO
**Estimated Effort**: 2 days
**Reference**: [Schema.org FoodEstablishment](https://schema.org/FoodEstablishment)

---

## Objective

Create a `FoodEstablishment` model to manage partner venues (pizzerias, restaurants) that host meetups, with proper Schema.org structured data for local SEO.

---

## Key Schema.org Properties

| Property | Type | Description |
|----------|------|-------------|
| `servesCuisine` | Text | Types of cuisine served |

### `task-geo-service-areas.md` — Task: Implement GeoCircle for Service Areas

# Task: Implement GeoCircle for Service Areas

**Priority**: LOW
**Status**: TODO
**Estimated Effort**: 1 day
**Reference**: [Schema.org GeoCircle](https://schema.org/GeoCircle)

---

## Objective

Implement `GeoCircle` support for defining circular geographic areas used for:
- Delivery zones for food establishments
- Event catchment areas
- Service coverage areas

---

## Key Properties


### `task-implementation-from-research.md` — Task di Implementazione da Ricerca Schema.org e Analisi Visiva

# Task di Implementazione da Ricerca Schema.org e Analisi Visiva

**Origine**: Studio approfondito di schema.org (Event, EventSeries, eventSchedule, JoinAction, LeaveAction, EventReservation, EducationEvent, FoodEstablishment, Offer, PriceSpecification, GeoCircle, Person, address) e confronto visivo con laravelpizza.com.

---

## Task Priorita' CRITICA (Bloccanti)

### TASK-C1: Creare componente events/list.blade.php

**Stato**: La pagina `/it/events` e' rotta ("View not found: pub_theme::components.blocks.events.list")

**File da creare**:
- `Themes/Meetup/resources/views/components/blocks/events/list.blade.php`
- `Themes/Meetup/resources/views/components/blocks/events/card.blade.php`

**Requisiti**:
- Titolo sezione + subtitle
- Filtri pill (All / Upcoming / Past) con Alpine.js
- Grid re

### `task-integrazione-calendario.md` — Task: Integrazione Calendario - Meetup

# Task: Integrazione Calendario - Meetup

**Modulo**: Meetup
**Priorita'**: Media
**Completamento**: 0%

---

## Funzionalita'

- [ ] Vista calendario eventi (Alpine.js component)
- [ ] Export .ics per singolo evento
- [ ] Feed iCalendar per tutti gli eventi
- [ ] Integrazione Google Calendar (add to calendar button)
- [ ] Vista mese/settimana/lista

## Criteri di Completamento

- [ ] Componente calendario funzionante
- [ ] Export .ics implementato

### `task-person-profile-enhancement.md` — Task: Enhance User Profile with Schema.org Person

# Task: Enhance User Profile with Schema.org Person

**Priority**: LOW
**Status**: TODO
**Estimated Effort**: 1 day
**Reference**: [Schema.org Person](https://schema.org/Person)

---

## Objective

Enhance the User/Profile model with Schema.org Person properties for:
- Better speaker/attendee profiles
- Author attribution in content
- Social profile linking
- Knowledge graph presence

---

## Key Properties to Add

### `task-registrazione-rsvp.md` — Task: Implementare Registrazione RSVP - Meetup

# Task: Implementare Registrazione RSVP - Meetup

**Modulo**: Meetup
**Priorita'**: Alta
**Completamento**: 20%

---

## Descrizione

Sistema di registrazione eventi con RSVP, gestione posti e waitlist.

## Funzionalita'

- [ ] Form registrazione evento (Volt component)
- [ ] Gestione posti disponibili con contatore
- [ ] Waitlist automatica quando pieno
- [ ] Conferma via email (integrazione Notify)
- [ ] Cancellazione con promozione da waitlist
- [ ] QR code per check-in

### `task-schema-org-research-future.md` — Task: Schema.org Research and Implementation - [DATE]

# Task: Schema.org Research and Implementation - [DATE]

**Module**: Meetup  
**Status**: Pending  
**Priority**: High  

## Research Summary

Based on comprehensive research of Schema.org documentation, I've identified key areas for enhancement in the Meetup module:

### 1. Event Scheduling & Recurrence
- **URL**: https://schema.org/eventSchedule
- **Implementation**: Add schedule support for recurring events
- **Files to modify**: 
  - `laravel/Modules/Meetup/app/Models/Event.php`
  - `laravel/Modules/Meetup/database/migrations/*_add_schedule_fields_to_events_table.php`

### 2. Event Series & Super Events
- **URL**: https://schema.org/EventSeries
- **Implementation**: Create EventSeries model and relationships

### `tasks-schema-org-event-series-actions.md` — Task: Schema.org Event, EventSeries, azioni e partecipanti

# Task: Schema.org Event, EventSeries, azioni e partecipanti

**Obiettivo:** utilizzare i tipi Schema.org studiati (Event, EventSchedule, EventSeries, JoinAction, LeaveAction, EventReservation, EducationEvent, attendee/attendees, participant) per arricchire dati strutturati e modelli del modulo Meetup.

**Riferimento:** [schema-org-enhancement-recommendations](schema-org-enhancement-recommendations.md) (sezione "Reference: Schema.org types studiati") · [event-schema-org-implementation](event-schema-org-implementation.md)

---

## Task 1: Event – completare toSchemaOrg() e campi

- [ ] Verificare che `Event::toSchemaOrg()` esponga almeno: `name`, `startDate`, `endDate`, `eventStatus`, `eventAttendanceMode`, `location`, `organizer`, `offers`, `maximumAttendeeCapacity`, `isAccessibleForFree`,

### `tasks-schema-org-offer-price.md` — Task: Schema.org Offer, PriceSpecification e contesto food

# Task: Schema.org Offer, PriceSpecification e contesto food

**Obiettivo:** utilizzare Offer, PriceSpecification e DeliveryChargeSpecification (e opzionalmente FoodEstablishment) per prezzo, biglietti e contesto "pizza/venue" negli eventi Meetup.

**Riferimento:** [schema-org-enhancement-recommendations](schema-org-enhancement-recommendations.md) (sezione "Reference: Schema.org types studiati")

---

## Task 1: Offer in Event.offers

- [ ] In `Event::toSchemaOrg()`: popolare `offers` con almeno un oggetto **Offer**: `@type: Offer`, `price`, `priceCurrency`, `availability` (es. InStock / SoldOut), `url` (pagina registrazione/dettaglio), `validFrom`/`validUntil` se applicabile.
- [ ] Per eventi gratuiti: `price: "0"` o `isAccessibleForFree: true` e comunque includere un Offer con `price: "0

### `testing-quality-assurance.md` — Laravel Pizza Testing Strategy & Quality Assurance

# Laravel Pizza Testing Strategy & Quality Assurance

## Testing Philosophy

The Laravel Pizza project follows a comprehensive testing strategy based on the testing pyramid approach with emphasis on quality, reliability, and maintainability. The testing strategy ensures code quality across all modules and maintains the integrity of the modular architecture.

## Testing Types & Levels

### 1. Unit Tests
Unit tests focus on individual components and functions within the application.

#### Location
```
tests/Unit/
Modules/{Module}/tests/Unit/
```

#### Coverage Areas
- **Actions**: Test business logic in isolation
- **Models**: Verify relationships, accessors, mutators

### `theme-differences-analysis.md` — Differenze tra versione attuale e laravelpizza.com

# Differenze tra versione attuale e laravelpizza.com

## Analisi delle differenze tra la versione dinamica e la versione statica HTML

### 1. Struttura principale
- Versione statica: Usa direttamente HTML con classi Tailwind specifiche
- Versione dinamica: Usa componenti Blade che devono corrispondere alla struttura HTML

### 2. Hero Section
Differenze chiave identificate:
- Logo pizza: La versione statica ha un'icona SVG specifica con design preciso
- Testi: La versione statica ha "Laravel Developers. Pizza. Community." in modo specifico
- CTA buttons: Diversa struttura HTML e classi Tailwind

### 3. Feature Cards
Differenze chiave:
- Versione statica: Usa classi specifiche come `bg-slate-800/50 backdrop-blur-sm border border-slate-700`
- Versione dinamica: Le classi attuali potrebbero no

### `theme-documentation-gaps.md` — Theme Documentation Structure

# Theme Documentation Structure

## Overview
The themes directory contains frontend implementations for the Laravel Pizza project. Currently, the Meetup theme is the primary theme with comprehensive HTML/CSS/JS implementation.

## Meetup Theme Structure

### Resources
- `resources/html/` - Complete HTML implementation with components
- `resources/css/` - Tailwind CSS configuration and custom styles
- `resources/js/` - JavaScript functionality including MCP integration
- `tailwind.config.js` - Tailwind CSS configuration with pizza-themed colors
- `vite.config.js` - Vite build configuration for asset compilation

### HTML Components
- Complete responsive design implementation
- Pizza-themed color palette (red, gold, green)
- MCP-integrated functionality
- Mobile-first approach
- Component-ba

### `theme-styling-implementation.md` — Implementazione Styling Tema Meetup

# Implementazione Styling Tema Meetup

## Data
[DATE]

## Obiettivo

Replicare il design di `laravelpizza.com` nel tema Meetup utilizzando gli stili e gli script dalla versione statica HTML già implementata in `resources/html/`.

## Modifiche Implementate

### 1. CSS (`resources/css/app.css`)

**Prima**: Solo import base di Tailwind
```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```


### `ui-ux-language-switcher-standard.md` — UI/UX Standards: Language Switcher

# UI/UX Standards: Language Switcher

Questo documento definisce gli standard UI/UX per il selettore di lingua nel progetto Laravel Pizza, basandosi sulle best practice del 2025.

## 🎯 Principi Fondamentali

### 1. Nomi Nativi (Autonimi)
Utilizzare sempre il nome della lingua come viene chiamato dai suoi parlanti nativi.
- ✅ `Deutsch` (non German)
- ✅ `Español` (non Spanish)
- ✅ `English`
- ✅ `Italiano`

### 2. Il Dilemma delle Bandiere
Le bandiere rappresentano nazioni, non lingue. 
- **Problema**: Lo spagnolo è parlato in Spagna, Messico, Argentina, ecc. Usare la bandiera spagnola può confondere o offendere utenti di altre nazioni.
- **Standard**: Preferire icone universali come il **Mondo (Globe)** o l'icona **Translate**. Le bandiere possono essere usate come "decorazione" secondaria s

### `ui-ux-mcp-configuration.md` — Configurazione MCP per UI/UX e Tailwind CSS

# Configurazione MCP per UI/UX e Tailwind CSS

## 📋 Panoramica

Questo documento descrive la configurazione dei server MCP specifici per migliorare lo sviluppo UI/UX e l'utilizzo di Tailwind CSS nel progetto Laravel Pizza.

## 🎨 Server MCP per Design e UI/UX

### Server Essenziali

#### 1. **puppeteer**
**Scopo**: Automazione browser per testing visuale e screenshot.

**Utilizzo**:
- Screenshot automatici delle pagine
- Test responsive design
- Validazione layout
- Generazione mockup visuali
- Test end-to-end UI


### `view-not-found-pub-theme-hero-analysis.md` — Analisi Errore: view not found: pub_theme::components.blocks.hero.main

# Analisi Errore: view not found: pub_theme::components.blocks.hero.main

## Data
[DATE]

## Problema Identificato

### Errore
```
view not found: pub_theme::components.blocks.hero.main
```

### Stack Trace
- `Modules/Cms/app/Datas/BlockData.php:30` - `BlockData::__construct()` lancia l'eccezione
- `Themes/Meetup/resources/views/pages/index.blade.php:22` - Pagina che usa `<x-page>`
- `config/local/laravelpizza/database/content/pages/home.json` - JSON che definisce i blocchi

## Analisi Dettagliata

### 1. Flusso di Esecuzione

### `view-not-found-pub-theme-hero-solution.md` — Soluzione: view not found: pub_theme::components.blocks.hero.main

# Soluzione: view not found: pub_theme::components.blocks.hero.main

## Data
[DATE]

## Problema Risolto

### Errore Originale
```
view not found: pub_theme::components.blocks.hero.main
```

### Causa Identificata
Il problema era legato al timing di esecuzione durante le richieste HTTP. Anche se:
1. ✅ Il file `main.blade.php` esiste in `Themes/Meetup/resources/views/components/blocks/hero/`
2. ✅ Il namespace `pub_theme` è registrato correttamente in `CmsServiceProvider::boot()`
3. ✅ La view può essere trovata quando eseguita in CLI

Durante le richieste HTTP, `BlockData::__construct()` veniva chiamato prima che `view()->exists()` potesse risolvere correttamente le view con namespace, causando un falso negativo.


### `vite-build-output-directory.md` — Vite Build Output Directory - Tema Meetup

# Vite Build Output Directory - Tema Meetup

## Data
[DATE]

## ⚠️ IMPORTANTE - Configurazione Vite

Il tema Meetup usa `laravel-vite-plugin` che compila gli asset nella directory `./public/` del tema, **NON** in `resources/html/dist/`.

## Configurazione Vite

### vite.config.js

```javascript
import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin'

export default defineConfig({
    plugins: [
        laravel({

### `vite-theme-asset-loading.md` — Vite Asset Loading per Temi - Guida Completa

# Vite Asset Loading per Temi - Guida Completa

## Data
[DATE]

## Problema Identificato

Quando si usa `@vite()` in un layout Blade di un tema, è necessario specificare il **build name** come secondo parametro per indicare a Vite dove cercare gli asset.

### ❌ Errore Comune

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

**Problema**: Vite cerca gli asset in `laravel/resources/` invece di `laravel/Themes/Meetup/resources/`.

### ✅ Soluzione Corretta

```blade

### `volt-automatic-route-binding.md` — Volt Automatic Route Parameter Binding

# Volt Automatic Route Parameter Binding

## 🎯 Principio: Volt Gestisce Automaticamente i Parametri della Route

**Volt/Livewire popola automaticamente le proprietà pubbliche del componente con i parametri della route Folio.**

## ❌ SBAGLIATO: Estrazione Manuale dei Parametri

**NON fare MAI questo:**

```php
<?php
new class extends Component {
    public string $container0;
    public string $slug0;

    public function mount(): void
    {
        // ❌ VIETATO: Estrazione manuale - Volt si arrangia da solo con quei parametri!
        $this->container0 = $this->container0 ?? request()->route('container0') ?? '';

### `volt-data-property-indispensable.md` — Volt Component: `public array $data = []` è INDISPENSABILE

# Volt Component: `public array $data = []` è INDISPENSABILE

## 🎯 Principio: `$data` è Necessario per Passare Variabili ai Componenti Inclusi

**La proprietà `public array $data = []` nel componente Volt è INDISPENSABILE** per far arrivare le variabili ai componenti inclusi tramite il sistema CMS.

## ❌ SBAGLIATO: Omettere `public array $data = []`

**NON fare MAI questo:**

```php
<?php
new class extends Component {
    public string $container0;
    public string $slug0;
    // ❌ MANCA: public array $data = [];
};
?>

@volt('container0.view')

### `volt-event-detail-component.md` — Volt Component per Block CMS - Pattern Corretto

# Volt Component per Block CMS - Pattern Corretto

## ⚠️ REGOLA CRITICA: Volt Inline nei Block CMS

**Il frontend CMS-driven usa componenti Volt inline, NON classi PHP separate!**

## Struttura File

```
Themes/Meetup/resources/views/livewire/blocks/events/
└── detail.blade.php    # ✅ Componente Volt inline
```

## Pattern Corretto: Volt Inline

Il file DEVE iniziare con `<?php` - NULLUNO output (neanche commenti) prima!

```php
<?php
declare(strict_types=1);

### `volt-mount-vs-php-block.md` — Volt Component: `mount()` vs Blocco `@php` - Best Practice

# Volt Component: `mount()` vs Blocco `@php` - Best Practice

## 🎯 Principio: Usare `mount()` per Logica di Inizializzazione

**La logica per popolare `$this->data` e calcolare valori derivati dovrebbe essere nel metodo `mount()` invece che nel blocco `@php`.**

## ❌ SBAGLIATO: Logica nel Blocco `@php`

**NON fare MAI questo:**

```blade
@volt('container0.view')
@php
// ❌ SBAGLIATO: Logica nel blocco @php invece che in mount()
$fullSlug = $this->container0 . '.' . $this->slug0;
$this->data = [
    'container0' => $this->container0,
    'slug0' => $this->slug0,
];
@endphp

### `warriorfolio-analysis.md` — WarriorFolio - Analisi Architettura Avanzata

# WarriorFolio - Analisi Architettura Avanzata

## Data: [DATE]

## Panoramica

**WarriorFolio** è una piattaforma portfolio e blog modulare costruita su Laravel 11.x che combina **Filament** per l'admin panel con un'architettura component-based moderna. Rappresenta un esempio avanzato di come integrare Filament con un frontend modulare.

**⚠️ IMPORTANTE**: Questo progetto **NON usa Folio + Volt**. Usa Livewire tradizionale, Filament e routing tradizionale (`routes/web.php`). È comunque utile per vedere pattern di organizzazione componenti e architettura modulare.

**Repository**: [mviniciusca/warriorfolio](https://github.com/mviniciusca/warriorfolio)

### Stack vs Folio + Volt

| Aspetto | WarriorFolio | Folio + Volt |
|---------|--------------|--------------|
| **Routing** | `routes/web.
