---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget architecture"
issues: []
discussions: []
title: "Architecture — Gdpr"
type: architecture
module: Gdpr
related:
  - ./livewire-inventory.md
  - ./livewire-widget-prd.md
---

# Architecture Gdpr

```
User 10.4: delete Privacy/Terms HTTP (ancora in User, non in Gdpr)
Gdpr: pagine legal / consenso come viste-modulo, mai widget dashboard
Gdpr Filament/Widgets/Auth: RegisterWidget + GdprConsentForm (già widget, canView guest-only)
User AdminPanelProvider:34-39: hook "moved into Gdpr" commentato — spostamento NON avvenuto
```

Verdetto verificato: [livewire-inventory.md](./livewire-inventory.md).
