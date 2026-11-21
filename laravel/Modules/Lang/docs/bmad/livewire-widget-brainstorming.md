---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget brainstorming"
issues: []
discussions: []
title: "Brainstorming — due HTTP identici"
type: brainstorming
module: Lang
related:
  - ./livewire-inventory.md
---

# Brainstorming

Change e Switcher erano copy-paste (stesso `mount()`, stessa vista `lang::livewire.lang.change`). Tenerne uno HTTP sarebbe comunque un gemello del widget.

**Stato (21/09, verificato):** `Switcher.php` ritirato; `Change.php` ancora montato in `UI headernav:60`; `LanguageSwitcherWidget` corretto ma senza consumatori. Ritiro di `Change` subordinato allo swap del tag — ordine e AC in story 12.1 (`blocked`).
