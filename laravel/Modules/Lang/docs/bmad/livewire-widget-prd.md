---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget prd"
issues: []
discussions: []
title: "PRD — Lang Livewire"
type: prd
module: Lang
related:
  - ./livewire-inventory.md
---

# PRD Lang

### FR-L001 [MUST] HTTP Switcher e Change assenti. — **parziale**: `Switcher.php` cancellato (alias `lang.switcher` stale in `_components.json`); `Change.php` presente e montato (`UI headernav:60`).
### FR-L002 [MUST] Widget + Blade wrapper restano. Nessuna terza classe. — soddisfatto; wrapper inerte (registrazione commentata).
### FR-L003 [SHOULD] Parità URL localizzati. — **chiuso nel codice**: widget usa `LaravelLocalization::getSupportedLocales()`/`getLocalizedURL()` (righe 73, 118) + redirect 303. Manca solo lo swap del mount.
