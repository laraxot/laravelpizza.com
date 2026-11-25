---
title: "Topic livewire-widget"
type: digest
status: active
qmd: "digest ceiling 100 livewire-widget"
---

# Topic livewire-widget

Sintesi automatica di 9 documenti (chiave `livewire-widget`).

## Architecture Gdpr

_Fonte: `bmad/livewire-widget-architecture.md`_

# Architecture Gdpr

```
User 10.4: delete Privacy/Terms HTTP (ancora in User, non in Gdpr)
Gdpr: pagine legal / consenso come viste-modulo, mai widget dashboard
Gdpr Filament/Widgets/Auth: RegisterWidget + GdprConsentForm (già widget, canView guest-only)
User AdminPanelProvider:34-39: hook "moved into Gdpr" commentato — spostamento NON avvenuto
```

Verdetto verificato: [livewire-inventory.md](./livewire-inventory.md).

## Brainstorming

_Fonte: `bmad/livewire-widget-brainstorming.md`_

# Brainstorming

Scartato: `PrivacyPolicyWidget`/`TermsOfServiceWidget` in Gdpr (i gemelli esistono già in User; i testi legal sono pagine, non card). Scartato: inventare HTTP "per completezza". Tenuto: inventory come gate — vedi [livewire-inventory.md](./livewire-inventory.md).

## Decision log

_Fonte: `bmad/livewire-widget-decision-log.md`_

# Decision log

## [2026-09-21] Legal in Gdpr come pagine, non widget KPI

Docs only. Dipende da User 10.4.

## [audit] Zero componenti Http/Livewire verificati

`app/Http/Livewire` contiene solo `_components.json` (`[]`). I due widget `Auth/` (`RegisterWidget`, `GdprConsentForm`) sono già Filament widget, montati solo nei test. Il commento "moved into Gdpr" in `Modules/User/.../AdminPanelProvider.php:34-39` non è implementato: `TermsOfService`/`PrivacyPolicy` HTTP sono ancora in User. Dettagli e citazioni: [livewire-inventory.md](./livewire-inventory.md).

## Epic 12

_Fonte: `bmad/livewire-widget-epics.md`_

# Epic 12

| ID | Intent | Status |
|----|--------|--------|
| 12.1 | Confermare ownership legal; no widget KPI | ready-for-dev (docs) |

Blocked-by User 10.4 sul delete HTTP. Nessun epic di conversione: zero candidati A/B/C — vedi [livewire-inventory.md](./livewire-inventory.md).

## PRD Gdpr

_Fonte: `bmad/livewire-widget-prd.md`_

# PRD Gdpr

### FR-D001 [MUST] Privacy/Terms non rinascono come widget dashboard.
### FR-D002 [SHOULD] Se User 10.4 cancella HTTP, Gdpr ha già (o riceve) le route/viste legal.
### FR-D003 [MUST] `RegisterWidget` / `GdprConsentForm` restano widget, non HTTP.

Nota verificata: la pagina Folio `Modules/User/resources/views/pages/auth/register.blade.php:70` monta `\Modules\Gdpr\Filament\Widgets\Auth\UserForm::class`, classe inesistente — riferimento stantio documentato in [livewire-inventory.md](./livewire-inventory.md), fuori scope docs.

## Brief

_Fonte: `bmad/livewire-widget-product-brief.md`_

# Brief

Pagine legal in Gdpr come pagine/viste. Widget auth (`RegisterWidget`, `GdprConsentForm`) restano widget — già Filament, `canView` guest-only. Nessun HTTP nuovo. Verdetto verificato: [livewire-inventory.md](./livewire-inventory.md).

## Context Gdpr

_Fonte: `bmad/livewire-widget-project-context.md`_

# Context Gdpr

Costituzione piattaforma: [Xot](../../Xot/docs/bmad/livewire-widget-project-context.md). Gdpr possiede consenso e testi legali; User non deve tenere Privacy/Terms Livewire. Vincoli ereditati: estendere `XotBaseWidget`, mai `Filament\Widgets\Widget` diretto; chrome con `$isDiscovered = false` + FQCN; FO/legal ≠ widget forzato.

Stato verificato del modulo: [livewire-inventory.md](./livewire-inventory.md) (zero `Http\Livewire`, 2 widget auth già Filament).

## Tech spec Gdpr

_Fonte: `bmad/livewire-widget-tech-spec.md`_

# Tech spec Gdpr

Gate: `find Modules/Gdpr/app/Http/Livewire -name '*.php'` = 0 file (solo `_components.json` con `[]`).

Prima di User 10.4: grep viste/route legal in Gdpr. Se mancano, story Gdpr **prima** del delete User. Nota: il commento "moved into Gdpr" in `Modules/User/.../AdminPanelProvider.php:34-39` non corrisponde ad alcun codice Gdpr — verificato in [livewire-inventory.md](./livewire-inventory.md). Nessun PHP ora.

## UX

_Fonte: `bmad/livewire-widget-ux.md`_

# UX

Testi legal come pagine FO, non card dashboard. Nessuna superficie chrome da migrare: i due widget auth esistono già e si vedono solo da guest. Vedi [livewire-inventory.md](./livewire-inventory.md).
