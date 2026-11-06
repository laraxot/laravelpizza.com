---
title: "Decision log — Geo"
type: decision-log
module: Geo
status: active
created: 2026-10-16
updated: 2026-10-20
tags: [bmad, decision-log, geo]
qmd: "decision log geo"
related:
  - ../bmad-planning.md
  - ../bmad-brainstorming.md
  - ./project-context.md
---

# Decision log — Geo

## 2026-10-20 — No-Services + PHPStan (docs allineate, non ricreare Services)

- **Decisione:** `app/Services/` e trait zombie (`GeographicalScopes`, ecc.) restano assenti; la logica e' in `app/Actions/`. I documenti che li citavano come "da risolvere" sono corretti verso [decisions/services-retirement.md](../decisions/services-retirement.md) e [services-to-actions-geo.story.md](../stories/services-to-actions-geo.story.md). PHPStan sul modulo segue l'[ordine permanente](../../../../../bashscripts/docs/prompts/00-start.md#ordine-permanente-dellutente) (fix sorgente, neon unico).
- **Perche:** ricreare Service per far sparire errori viola la religione Actions e reintroduce merge-zombie; la memoria Hindsight va corretta quando il codice e' gia' migrato.
- **Track:** [CORRECTION-NoServices-Geo-2026-10-20.md](../CORRECTION-NoServices-Geo.md) (correzione record); memoria Xot [phpstan-modules-zero-standing-order](../../../Xot/docs/wiki/memories/phpstan-modules-zero-standing-order.md).

## 2026-10-16 — Kit BMAD owner

- **Decisione:** adottare `docs/bmad-planning.md` + `docs/bmad-brainstorming.md` + `docs/bmad/filament-blueprint.md` come SSoT di planning per questo owner.
- **Perche:** rimuovere stub copiati "Ticket Timeline" non pertinenti; allineare second brain e Filament blueprint allo scopo reale.
- **Track:** `quick-flow`
