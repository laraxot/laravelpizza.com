---
title: "Decision log — Seo"
type: decision-log
module: Seo
status: active
created: 2026-10-16
updated: 2026-10-20
tags: [bmad, decision-log, seo, no-services]
qmd: "decision log seo"
related:
  - ../bmad-planning.md
  - ../bmad-brainstorming.md
  - ./project-context.md
---

# Decision log — Seo

## 2026-10-20 — MetatagService: già Action (adapter), niente `app/Services/`

- **Stato:** `Modules/Seo/app/Services/` **assente**. L'API storica del monolite vive in `MetatagFacadeAdapter` (delega a QueueableActions). Non reintrodurre `MetatagService`.
- **Zombie:** `tests/Unit/Services/MetatagServiceExtendedTest.php.old` puntava a `Modules\Seo\Services\MetatagService` (classe inesistente) → rimosso in boy scout post-PHPStan-zero.
- **Track:** [services-to-actions-seo.story.md](../stories/services-to-actions-seo.story.md), census Xot [decision-log](../../../Xot/docs/bmad/decision-log.md#2026-10-20--boy-scout-post-zero-census-modulesappservices).

## 2026-10-16 — Kit BMAD owner

- **Decisione:** adottare `docs/bmad-planning.md` + `docs/bmad-brainstorming.md` + `docs/bmad/filament-blueprint.md` come SSoT di planning per questo owner.
- **Perche:** rimuovere stub copiati "Ticket Timeline" non pertinenti; allineare second brain e Filament blueprint allo scopo reale.
- **Track:** `quick-flow`
