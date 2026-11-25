---
title: "Topic folio-volt"
type: digest
status: active
qmd: "digest ceiling 100 folio-volt"
---

# Topic folio-volt

Sintesi automatica di 3 documenti (chiave `folio-volt`).

## FolioVolt = unico owner del mount Folio

_Fonte: `bmad/folio-volt-sole-owner.md`_

# FolioVolt = unico owner del mount Folio

Sostituisce le doc stale che citavano `App\Providers\FolioServiceProvider`.
Link da: `folio-runtime-governance.md`, story Activity centralizzazione, prompt Activity 01.
Istruzione utente: scomodare `laravel/app/Providers/FolioServiceProvider.php` quando esiste
`FolioVoltServiceProvider` è sbagliato — basta Cms.

## Scopo e perché

In Laraxot il FO/API Folio non vive in `laravel/app/Providers`. L'unico owner è:

`Modules\Cms\Providers\FolioVoltServiceProvider`

(registrato da `Modules/Cms/module.json` / `composer.json` extra).

**Non** creare né registrare `App\Providers\FolioServiceProvider`.

## Cosa fa FolioVolt (KISS)

- tema `pub_theme` pages per ogni locale
- `resources/views/pages` di ogni modulo abilitato (`uri($locale)`)
- `pages/api` → `uri('/api')` + middleware `web`
- mount in `booted()`; Volt::mount sugli stessi path

## Anti-pattern

| Sbagliato | Perché |
|---|---|
| `laravel/app/Providers/FolioServiceProvider.php` | Secondo cervello di routing; Cms basta |

## Laravel Folio + Volt - Best Practices and Patterns Analysis

_Fonte: `folio-volt-best-practices.md`_

# Laravel Folio + Volt - Best Practices and Patterns Analysis

## Overview

Based on research of multiple Laravel Folio + Volt repositories and official documentation, this document outlines the best practices and patterns for implementing Folio + Volt in applications.

## Key Patterns Identified

### 1. File Structure
- **Pages Directory**: Folio automatically maps files in `resources/views/pages/` to routes
  - Example: `resources/views/pages/events.blade.php` → `/events`
  - Example: `resources/views/pages/events/[event].blade.php` → `/events/{event}`
- **Subdirectories**: Organize related pages in subdirectories (e.g., `resources/views/pages/auth/`)
- **Blade Components**: Store reusable UI components in `resources/views/components/`

### 2. Volt Component Structure
- Volt components can exist within Folio pages using the `@volt` directive
- Components can also be standalone files in `resources/views/livewire/` or custom mounted directories
- Single-file components combine PHP logic and Blade template

Example of a Volt component in a Folio page:
```blade
<?php
use App\Models\Event;
use function Livewire\Volt\{computed, mount};

$events = computed(fn () => Event::upcoming()->get());
?>

## Folio + Volt — `mount()` e `@volt` statico

_Fonte: `wiki/concepts/folio-volt-static-mount-contract.md`_

# Folio + Volt — `mount()` e `@volt` statico

## Scopo (business)

Il modulo Cms non conosce i segmenti URL del tema: riceve solo `:slug` e `:data` da `<x-page>`. Il tema Folio traduce path → stato tipizzato in `mount()`.

## Contratto tema → CMS

```
URL /{locale}/{container0}/{slug0}/{container1}
  → mount(string $container0, string $slug0, string $container1)
  → $pageSlug (slug CMS, es. services.view)
  → $data = ['container0' => …, 'slug0' => …, 'container1' => …]
  → <x-page side="content" :slug="$pageSlug" :data="$data" />
```

## Volt nel tema (non nel modulo)

- `new class extends Component` + `@volt('…')` **statico** = `name('…')`
- **Vietato:** `@volt($pageSlug)` — confonde slug CMS con nome componente Livewire

## Responsabilità

| Layer | Owner | Ruolo |
|-------|-------|-------|
| Folio filename + `mount()` | Theme Sixteen | Params URL, `$data` |
| `@volt` statico | Theme Sixteen | SFC Livewire |
| `<x-page>` | Modulo Cms | Blocchi JSON, widget Filament |
| Business logic | Moduli dominio | Actions, modelli |
