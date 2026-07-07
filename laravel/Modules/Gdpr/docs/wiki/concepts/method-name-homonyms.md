---
title: "censimento omonimi metodi — modulo Gdpr"
type: analysis
module: Gdpr
updated: 2026-06-15
related:
  - ../../../../../../docs/wiki/method-name-homonym-census.md
  - ../../../../../../bashscripts/docs/method-homonym-census.json
---

# Censimento omonimi metodi — Gdpr

> **25** nomi metodo omonimi coinvolgono questo modulo (su 689 totali progetto).

## Riepilogo categoria (solo Gdpr)

| Categoria | Metodi |
|-----------|--------|
| `A_filament_framework` | 17 |
| `E_scheda_stack` | 2 |
| `G_module_local` | 1 |
| `H_cross_module_homonym` | 5 |

## Dettaglio

### `A_filament_framework` (17 metodi)

Hook Filament/Laravel ripetuti — **non** debito. Elenco omesso.

### `E_scheda_stack`

#### `before` — 14 classi

- `Gdpr` · `GdprBasePolicy` · `Modules/Gdpr/app/Models/Policies/GdprBasePolicy.php`

#### `getView` — 11 classi

- `Gdpr` · `GdprConsentForm` · `Modules/Gdpr/app/Filament/Widgets/Auth/GdprConsentForm.php`
- `Gdpr` · `RegisterWidget` · `Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php`

### `G_module_local`

#### `logRegistrationAttempt` — 2 classi

- `Gdpr` · `GdprConsentForm` · `Modules/Gdpr/app/Filament/Widgets/Auth/GdprConsentForm.php`
- `Gdpr` · `RegisterWidget` · `Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php`

### `H_cross_module_homonym`

#### `canView` — 6 classi

- `Gdpr` · `GdprConsentForm` · `Modules/Gdpr/app/Filament/Widgets/Auth/GdprConsentForm.php`
- `Gdpr` · `RegisterWidget` · `Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php`

#### `panel` — 4 classi

- `Gdpr` · `AdminPanelProvider` · `Modules/Gdpr/app/Providers/Filament/AdminPanelProvider.php`

#### `submit` — 4 classi

- `Gdpr` · `GdprConsentForm` · `Modules/Gdpr/app/Filament/Widgets/Auth/GdprConsentForm.php`
- `Gdpr` · `RegisterWidget` · `Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php`

#### `configureEmailVerification` — 2 classi

- `Gdpr` · `EventServiceProvider` · `Modules/Gdpr/app/Providers/EventServiceProvider.php`

#### `registerMyMiddleware` — 2 classi

- `Gdpr` · `GdprServiceProvider` · `Modules/Gdpr/app/Providers/GdprServiceProvider.php`




## Rigenerazione

```bash
python3 bashscripts/tools/census-method-homonyms.py
```
