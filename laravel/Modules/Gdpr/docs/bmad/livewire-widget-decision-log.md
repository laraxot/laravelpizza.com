---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget decision log"
issues: []
discussions: []
title: "Decision log — Gdpr"
type: decision-log
module: Gdpr
related:
  - ./livewire-inventory.md
---

# Decision log

## [2026-09-21] Legal in Gdpr come pagine, non widget KPI

Docs only. Dipende da User 10.4.

## [audit] Zero componenti Http/Livewire verificati

`app/Http/Livewire` contiene solo `_components.json` (`[]`). I due widget `Auth/` (`RegisterWidget`, `GdprConsentForm`) sono già Filament widget, montati solo nei test. Il commento "moved into Gdpr" in `Modules/User/.../AdminPanelProvider.php:34-39` non è implementato: `TermsOfService`/`PrivacyPolicy` HTTP sono ancora in User. Dettagli e citazioni: [livewire-inventory.md](./livewire-inventory.md).
