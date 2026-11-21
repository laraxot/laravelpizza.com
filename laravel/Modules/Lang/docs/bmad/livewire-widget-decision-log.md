---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget decision log"
issues: []
discussions: []
title: "Decision log — Lang"
type: decision-log
module: Lang
related:
  - ./livewire-inventory.md
---

# Decision log

## [2026-09-21] Widget SSoT, HTTP duplicati fuori

Docs only.

## [2026-09-21] Stato intermedio verificato: story 12.1 a metà (`blocked`)

Una campagna concorrente ha: cancellato `Switcher.php`, riscritto `LanguageSwitcherWidget` su `LaravelLocalization` (righe 70-128), tipizzato i docblock di `Change.php`. Non fatto: swap del tag in `UI headernav:60` (ancora `<livewire:lang.change>`), delete di `Change.php`, pulizia `_components.json` (voce `lang.switcher` stale su classe mancante), migrazione dei 3 test che importano `Switcher` (ora rotti). Verdetto invariato (ritiro su gemello), esecuzione parziale. Citazioni: [livewire-inventory.md](./livewire-inventory.md) + story 12.1.
