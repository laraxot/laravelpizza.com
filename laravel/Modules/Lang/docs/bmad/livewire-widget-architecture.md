---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget architecture"
issues: []
discussions: []
title: "Architecture — Lang"
type: architecture
module: Lang
related:
  - ./livewire-inventory.md
  - ./livewire-widget-prd.md
---

# Architecture Lang

```
UI components/headernav/simple.blade.php:60 → <livewire:lang.change> (HTTP, ancora attivo)
Http/Livewire/Lang/Switcher → file ritirato (21/09), alias stale in _components.json
Http/Livewire/Lang/Change → ancora presente: swap tag → poi delete (ordine in story 12.1)
Filament/Widgets/LanguageSwitcherWidget → pronto (LaravelLocalization, righe 70-128), non montato
View\Components\LanguageSwitcher → wrapper inerte (registrazione commentata, LangServiceProvider.php:42)
```

ADR: non creare `LangChangeWidget`. Dettaglio e citazioni: [livewire-inventory.md](./livewire-inventory.md) — stato volatile, rieseguire i grep prima di agire.
