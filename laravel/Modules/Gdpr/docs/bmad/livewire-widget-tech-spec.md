---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget tech spec"
issues: []
discussions: []
title: "Tech spec — Gdpr"
type: tech-spec
module: Gdpr
related:
  - ./livewire-inventory.md
  - ./livewire-widget-prd.md
---

# Tech spec Gdpr

Gate: `find Modules/Gdpr/app/Http/Livewire -name '*.php'` = 0 file (solo `_components.json` con `[]`).

Prima di User 10.4: grep viste/route legal in Gdpr. Se mancano, story Gdpr **prima** del delete User. Nota: il commento "moved into Gdpr" in `Modules/User/.../AdminPanelProvider.php:34-39` non corrisponde ad alcun codice Gdpr — verificato in [livewire-inventory.md](./livewire-inventory.md). Nessun PHP ora.
