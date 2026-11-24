---
title: "Rimosso InteractiveMap — violava regola "UI non importa Geo""
type: concept
tags: [geo, dependency, violation, interactive]
created: 2026-07-14
updated: 2026-07-21
qmd: "geo-dependency-violation-interactive-map rimosso interactivemap — violava regola "ui non importa geo""
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
updated: 2026-08-18
qmd: "geo-dependency-violation-interactive-map rimosso interactivemap — violava regola "ui non importa geo""
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index-1.md"
  - "./00-index.md"
  - "./04-datas.md"
  - "./advanced-form-components-1.md"
  - "./advanced-form-components.md"
  - "./agent-confidence-discipline.md"
  - "./agent-confidence-protocol.md"
  - "./agent-edit-discipline.md"
---

# Rimosso InteractiveMap — violava regola "UI non importa Geo"

## Problema

`Modules/UI/app/Livewire/Components/Map/InteractiveMap.php` importava 5 classi di `Modules\Geo\Actions\{Map,Geocoding}\*` che **non esistevano** (`class.notFound` in PHPStan), e violava comunque la regola architetturale non negoziabile: `Modules/UI` non deve dipendere da `Modules/Geo` (la direzione corretta è Geo → UI).

## Analisi prima di intervenire

- Nessun file nel monorepo referenzia `InteractiveMap` (né tag Livewire, né route/page, né altro componente): `grep -rln "InteractiveMap" Modules` non trova nulla fuori dal componente stesso.
- Le 5 Action Geo richieste (`GetMapMarkersAction`, `GetMapStatsAction`, `ExportMapDataAction`, `GeocodeAddressAction`, `GetGeocodingSuggestionsAction`) non esistono in `Modules/Geo/app/Actions/` — non è un import rotto da refactor, è una feature mai completata.

## Decisione

Componente completamente inutilizzato + dipendenze mai implementate + violazione di dipendenza = non ha senso costruire 5 Action speculative per una feature che nessuno chiama (YAGNI/ponytail). Archiviato forward-only, non cancellato:
- `Modules/UI/app/Livewire/Components/Map/` → `Modules/UI/docs/archive/Livewire/Map.old/`
- `Modules/UI/resources/views/livewire/components/map/interactive-map.blade.php{,.old}` → `Modules/UI/docs/archive/views/livewire/components/map/`
## Se in futuro serve una mappa interattiva
Costruirla **dentro `Modules/Geo`** (dominio corretto), con le Action reali (`Spatie\QueueableAction`, `execute()`), e semmai esporre un Blade component/Livewire consumabile da `UI` o dai temi — mai il contrario.
Componente inutilizzato + dipendenze Geo + violazione di direzione = **cancellare**, non archiviare in `docs/archive/` e non inventare Action Geo in UI.

2026-08-18: `InteractiveMap.php`, `.old` e Blade non sono più sotto `app/` / `resources/views`. `git grep Modules\\Geo -- app` è vuoto.

Se in futuro serve una mappa: **dentro `Modules/Geo`**, con Action reali (`Spatie\QueueableAction`, `execute()`), eventualmente consumate da un tema. Mai il contrario.

Canon: [geo-boundary.md](./geo-boundary.md).
