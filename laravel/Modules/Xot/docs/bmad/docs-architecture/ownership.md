---
title: "Documentation ownership"
type: architecture
status: active
updated: 2026-10-13
tags: [documentation, ownership, modules, themes, cms, sixteen]
qmd: "documentation ownership module theme CMS Sixteen Fixcity"
---

# Ownership

| Area | Owner | Fonte primaria |
|---|---|---|
| CMS, Page, Section, Block, Folio contract | `Modules/Cms` | `laravel/Modules/Cms/docs/` |
| business ticket e workflow civico | `Modules/Fixcity` | `laravel/Modules/Fixcity/docs/` |
| routing, tenant, base conventions | modulo proprietario | relativo `docs/` |
| markup, layout, CSS e JS pubblico | tema attivo | `laravel/Themes/<Theme>/docs/` |
| Design Comuni visual parity | Sixteen | `Themes/Sixteen/docs/design-comuni/` |
| iniziative cross-module | Planning | `bmad-output/` |

Il modulo documenta il contratto dati e il comportamento applicativo; il tema
documenta la resa. Non duplicare nel tema la logica del modulo e non mettere
nei moduli decisioni esclusivamente visuali.

Per Design Comuni, Cms e Sixteen devono avere collegamenti bidirezionali:
fixture/page/block nel Cms, component/layout/parity nel tema.
