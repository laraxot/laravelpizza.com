---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget decision log"
issues: []
discussions: []
title: "Decision log — Livewire → widget"
type: decision-log
module: Xot
status: active
related:
  - ./livewire-widget-project-context.md
  - ./livewire-inventory.md
  - ./livewire-widget-advantages.md
---

# Decision log

## [2026-09-21] Religione in Xot, inventario nei foglia

**Decision:** Xot possiede la legge (`XotBaseWidget`). Ogni modulo scrive il proprio `docs/bmad/livewire-inventory.md`. User resta il pilota identità (Epic 9–10).

## [2026-09-21] Docs only

Nessun PHP in questa sessione.

## [sessione audit successiva] Inventario approfondito + doc canonico vantaggi

**Decision:** il "perché solo widget" vive in un documento canonico piattaforma
([livewire-widget-advantages.md](./livewire-widget-advantages.md)); i doc di modulo
(`advantages-filament-only.md` in User) restano evidenze locali e non vengono duplicati.

**Findings nuovi nell'inventario:** `LivewireComponentsListCommand` (`xot:livewire-list`)
registrato ma `handle()` no-op; `tableto_formx`/`Tableto_formx` file PHP senza estensione
(dead code a tre livelli: autoload, `GetComponentsAction.php:72`, nessun mount); zero
sottoclassi di `XotBaseComponent` repo-wide; `_components.json` di Xot = `[]`; percorso di
deprecation di `RegisterLivewireComponentsAction` subordinato al ritiro degli
`Http/Livewire` dei moduli foglia (rimozione chiamata da `XotBaseServiceProvider::boot()`
riga 44, non svuotamento directory — `GetComponentsAction.php:41-45` la ricreerebbe).
