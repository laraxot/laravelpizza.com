---
title: "Decision log: UI Livewire"
type: decision-log
module: UI
related:
  - ./livewire-inventory.md
status: draft
updated: 2026-10-07
tags: [docs, ui, bmad]
qmd: "decision log ui"
---

# Decision log

## [2026-09-21] Ritiro, non rewrite

DarkModeSwitcherWidget è SSoT. HTTP `DarkModeSwitcher` esce. Docs only.

## [2026-09-21] Toast non è orfano: rimosso dallo scope del ritiro

Diversi documenti satelliti (architecture, tech-spec, epics, product-brief) e la storia 12.1 includevano `Toast` fra le classi da ritirare, basandosi su un grep che verificava solo il nome della vista (`ui::livewire.toast`) e non il tag di montaggio. Verifica ripetuta con `grep -rn "<livewire:toast" --include="*.blade.php" .`: `Toast` è montato in `Modules/UI/resources/views/components/layouts/main.blade.php:28`, layout radice del front-office del modulo, ereditato da `guest`/`marketing`/`auth-split`/`app` e da pagine Folio/altri moduli: più un secondo mount in `Modules/User/resources/views/components/layouts/main.blade.php:49`. Non è candidabile a widget (non è chrome di un panel Filament) e non va ritirato (romperebbe le notifiche toast del front-office). Tutti i documenti citati sono stati corretti per riflettere questo; la SSoT resta [livewire-inventory.md](./livewire-inventory.md).

## [2026-09-21] InteractiveMap classificata: orfano, Cluster C, fuori campagna

`Modules/UI/app/Livewire/Components/Map/InteractiveMap.php` non era coperta dall'inventario perché sta sotto `app/Livewire`, non `Http/Livewire`: quindi non viene auto-registrata da `RegisterLivewireComponentsAction`. Verifica repo-wide: zero montaggi, nessun `Livewire::component`, dipendenze `Modules\Geo\Services\{MapService,GeocodingService}` inesistenti (story 7.15). Esclusa dalla campagna widget; eventuale rimozione è pulizia dead-code separata.
