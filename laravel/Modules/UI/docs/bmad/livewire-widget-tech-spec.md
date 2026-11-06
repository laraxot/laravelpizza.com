---
title: "Tech spec: UI ritiro HTTP"
type: tech-spec
module: UI
related:
  - ./livewire-inventory.md
  - ./livewire-widget-prd.md
status: draft
updated: 2026-10-07
tags: [docs, ui, bmad]
qmd: "tech spec ui ui"
---

# Tech spec UI

Grep prima del delete: `DarkModeSwitcher` HTTP vs Widget vs View Component. Tenere Widget + View\Components. Delete `app/Http/Livewire/DarkModeSwitcher.php` e vista `livewire/dark-mode/switcher`. Aggiornare `UiGapCloser100Test` al widget.

Toast: la condizione originale era "grep `ui::livewire.toast`; se solo self, delete classe+vista". Quel grep cercava solo il nome della vista, non il tag di montaggio. Ripetuto correttamente con `grep -rn "<livewire:toast" --include="*.blade.php" .`, il risultato non è "solo self": `Modules/UI/resources/views/components/layouts/main.blade.php:28` e `Modules/User/resources/views/components/layouts/main.blade.php:49` montano `<livewire:toast />`. La condizione di cancellazione non si verifica: **non cancellare** `Toast`, resta in scope.

`InteractiveMap`: fuori da `Http/Livewire` → non auto-registrato (`XotBaseServiceProvider.php:143-144` scansiona solo `Http/Livewire`); grep `InteractiveMap|interactive-map` → zero hit fuori da self/vista/meta; `Modules/Geo/app/Services` non esiste (deps `MapService`/`GeocodingService` mancanti). Escluso; non creare widget mappa.

Non toccare `phpstan.neon`.
