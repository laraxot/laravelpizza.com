---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget prd"
issues: []
discussions: []
title: "PRD — Gdpr legal da User"
type: prd
module: Gdpr
related:
  - ./livewire-inventory.md
status: draft
---

# PRD Gdpr

### FR-D001 [MUST] Privacy/Terms non rinascono come widget dashboard.
### FR-D002 [SHOULD] Se User 10.4 cancella HTTP, Gdpr ha già (o riceve) le route/viste legal.
### FR-D003 [MUST] `RegisterWidget` / `GdprConsentForm` restano widget, non HTTP.

Il form pubblico monta `RegisterWidget` da `Themes/Sixteen/resources/views/components/pages/auth-register.blade.php`. Vedi [livewire-inventory.md](./livewire-inventory.md).
