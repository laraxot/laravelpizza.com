---
title: "Geo Wiki Index"
type: index
module: Geo
tags: [geo, wiki, index, map-lit, leaflet]
created: 2026-04-15
updated: 2026-06-05
qmd: "geo module wiki index map-lit leaflet marker popup"
issues:
  - "https://github.com/laraxot/module_geo_fila5/issues/47"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ./concepts/ai-harness-geo-discipline.md
  - ../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md
---

# Geo Module Wiki

## AI / second brain

- [ai-harness-geo-discipline](./concepts/ai-harness-geo-discipline.md)
- [hackernoon-ai-coding-tips-fixcity-map](../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md)
- [bmad/architecture](../../../../docs/wiki/bmad/architecture.md)
- [ai-harness-module-discipline](../../docs/wiki/concepts/ai-harness-module-discipline.md)
- [second-brain-local-discipline](./concepts/second-brain-local-discipline.md) → canon Xot


## Indices
- [Rules](rules/INDEX.md)
- [Skills](skills/INDEX.md)
- [Commands](commands/INDEX.md)
- [Memories](memories/INDEX.md)
- [Concepts](concepts/INDEX.md)

## Nota frontoffice (tema Sixteen)

## Map-lit /it (2026-06)

**Ricostruzione:** [geo-map-lit-reconstruction-guide.md](concepts/geo-map-lit-reconstruction-guide.md) · [geo-map-fixes-registry.md](concepts/geo-map-fixes-registry.md) · hub root [map-lit-reconstruction-hub.md](../../../../../docs/wiki/memories/map-lit-reconstruction-hub.md)

- [map-lit-it-incidents-2026-06.md](troubleshooting/map-lit-it-incidents-2026-06.md) — STORY-121…129 runbook
- [map-popup-header-whitespace-fix.md](troubleshooting/map-popup-header-whitespace-fix.md) — vuoto popup header→Tipologia
- [farmshops-eu-applicability-fixcity.md](concepts/farmshops-eu-applicability-fixcity.md) — pattern cluster
- [farmshops-cluster-type-icons-study.md](concepts/farmshops-cluster-type-icons-study.md) — STORY-284 gap stato→icone tipo
- [map-lit-legend-types.md](concepts/map-lit-legend-types.md) — STORY-094 legenda tipologie
- [map-lit-cluster-type-icons.md](concepts/map-lit-cluster-type-icons.md) — icone tipo cluster 14px (non stato)
- [map-legend-status-semantics.md](concepts/map-legend-status-semantics.md) — STORY-125 stato vs tipologia
- [geo-map-popup-bem.md](concepts/geo-map-popup-bem.md) — block `popup`, `<div class="popup__header">`
- [geo-map-marker-status-background.md](concepts/geo-map-marker-status-background.md) — marker stato + pad bianco + punta
- [bem-modifier-dom-contract.md](rules/bem-modifier-dom-contract.md) — vietato `.popup--loading .popup__footer`


Il **guscio** delle pagine pub (Tailwind + [DaisyUI docs](https://daisyui.com/docs/) + parity classi Design Comuni) è di competenza del tema; i componenti **Lit** mappa (`coordinate-picker-lit`, `map-lit`, …) non dipendono da DaisyUI ma convivono nello stesso bundle Vite del tema. Indice stack: [design-comuni-class-mapping](../../../../Themes/Sixteen/docs/wiki/entities/design-comuni-class-mapping.md). **Valutazione DaisyUI** (pro/contro, percentuali): [daisyui-pro-contro-metriche](../../../../Modules/Cms/docs/daisyui-pro-contro-metriche.md).

## On-Demand Workflow

```bash
qmd search "Geo <topic>" --limit 5
```

---
*Updated: 2026-06-03 — ricostruzione map-lit, marker pin, popup header fix*

## Composer / nwidart

- [composer-root-minimal-nwidart](concepts/composer-root-minimal-nwidart.md) — root skeleton nwidart (modello fixcity)
