---
title: "Topic folio-route"
type: digest
status: active
qmd: "digest ceiling 100 folio-route"
---

# Topic folio-route

Sintesi automatica di 3 documenti (chiave `folio-route`).

## Folio Route Analysis Plan

_Fonte: `folio-route-analysis-plan.md`_

# Folio Route Analysis Plan

## Objective

To ascertain the current usage and configuration of Laravel Folio within the project. This is crucial given the new architectural directive to use Folio, Volt, and Filament for front-office development, and to understand which routes are already handled by Folio's file-based routing.

## Method

Execute the Laravel Artisan command: `php artisan folio:list`

## Expected Output

The command is expected to display a list of all routes registered by Laravel Folio. This list will include the URI paths, the corresponding Blade files, and any associated middleware.

## Expected Learnings

1.  **Confirmation of Folio Usage:** Determine definitively if Laravel Folio is actively routing pages in the current project setup.
2.  **Identification of Existing Folio Pages:** Understand which current frontend pages (if any) are already being served via Folio. This will guide future development to maintain consistency.
3.  **Architectural Alignment:** Evaluate the current Folio routes against the project's overall structure and the goal of using Folio for all front-office routing.
4.  **Gaps Analysis:** Identify any missing Folio routes for planned pages (e.g., `dashboard`, `profile`, dynamic event pages) that would need to be created.

## Planned Next Steps (Post-Execution)

1.  Analyze the output of `php artisan folio:list`.
2.  Synthesize the findings, noting any existing Folio routes and their patterns.
3.  Update `Themes/Meetup/docs/project-compl

## Folio Route Naming Convention

_Fonte: `folio-route-naming-convention.md`_

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

| File | Route Name | Perché |
|------|------------|--------|
| `[slug].blade.php` | `name('pages.view')` | Vista generica per qualsiasi slug CMS |
| `[container0]/index.blade.php` | `name('container0')` | Index/lista per qualsiasi container0 |
| `[container0]/[slug0]/index.blade.php` | `name('container0.view')` | Vista generica per qualsiasi container0+slug0 |
| `auth/login.blade.php` | `name('login')` | Azione specifica login |
| `auth/password/reset.blade.php` | `name('password.reset')` | Azione specifica reset password |

## ❌ Anti-Pattern: Naming Legato ai Parametri

## Folio Route Precedence - Why the Wrong Blade is Matched

_Fonte: `folio-route-precedence.md`_

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
1. Can't find `/events/{slug}` route
2. Falls back to the catch-all `[slug].blade.php` at the root level

## Solution Applied

1. Created `pages/events/` directory
2. Created `pages/events/index.blade.php` for `/events` (list)
3. Created `pages/events/[slug].blade.php` for `/events/{slug}` (detail)

## Route Precedence for Same URL
