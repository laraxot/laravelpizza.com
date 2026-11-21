---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget tech spec"
issues: []
discussions: []
title: "Tech spec — Lang ritiro"
type: tech-spec
module: Lang
related:
  - ./livewire-inventory.md
  - ./livewire-widget-prd.md
---

# Tech spec Lang

Stato verificato 21/09 (story 12.1 `blocked`, ordine obbligato):

1. Swap `Modules/UI/.../headernav/simple.blade.php:60`: `<livewire:lang.change>` → `@livewire(\Modules\Lang\Filament\Widgets\LanguageSwitcherWidget::class)`.
2. Delete `app/Http/Livewire/Lang/Change.php` (+ vista orfana `livewire/lang/change.blade.php` a valle).
3. `_components.json` → `[]` (oggi elenca `lang.change` + `lang.switcher` stale su classe cancellata).
4. Migrare i test che importano `Switcher` (`LangHundredPercentCoverageTest`, `LangFinalGapsTest`, `LangCoverageGaps`) — oggi rotti per class-not-found.

Parità già nel codice widget: `getSupportedLocales()` riga 73, `getLocalizedURL()` riga 118, redirect 303 righe 101-108. Grep di verifica: `grep -rn "lang\.change\|lang\.switcher\|livewire:lang" .` deve dare zero hit attivi.
