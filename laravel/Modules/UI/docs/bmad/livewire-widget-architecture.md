---
title: "Architecture: UI widget"
type: architecture
module: UI
related:
  - ./livewire-inventory.md
  - ./livewire-widget-prd.md
status: draft
updated: 2026-10-07
tags: [docs, ui, bmad]
qmd: "architecture ui ui"
---

# Architecture UI

```
Tema Blade DarkModeSwitcher → DarkModeSwitcherWidget
Http/Livewire/DarkModeSwitcher → delete
Toast HTTP → resta: montato in components/layouts/main.blade.php:28 (+ User main.blade.php:49), non è orfano
Livewire/Components/Map/InteractiveMap → orfano: fuori Http/Livewire (non auto-registrato), zero montaggi, deps Geo\Services assenti
filament/widgets/group|row → già FQCN
```

ADR: gemello esistente batte classe nuova (stesso di User SocialLogin).

**Correzione 2026-09-21:** la riga "Toast HTTP → delete (orfano)" era sbagliata. `Toast` è montato con `<livewire:toast />` in `Modules/UI/resources/views/components/layouts/main.blade.php:28`, layout radice ereditato da tutti i layout front-office del modulo e da pagine fuori modulo. Dettaglio e citazioni complete: [livewire-inventory.md](./livewire-inventory.md).
