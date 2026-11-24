---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget ux"
issues: []
discussions: []
title: "UX — language switcher"
type: ux-design
module: Lang
related:
  - ./livewire-inventory.md
---

# UX

Stesso dropdown, stesso punto dell'header FO (`headernav/simple.blade.php:60`): lo swap da `<livewire:lang.change>` al widget FQCN non deve cambiare markup né interazione. Nessun secondo controllo nel panel.
