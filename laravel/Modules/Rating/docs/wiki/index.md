---
title: "Rating Module Wiki Index"
type: index
module: Rating
tags: [rating, wiki, index]
created: 2026-04-15
updated: 2026-09-24
qmd: "rating module wiki index second brain harness"
issues:
  - "https://github.com/laraxot/platform/issues/272"
discussions:
  - "https://github.com/laraxot/platform/discussions/273"
related:
  - ../../../../../bashscripts/ai/wiki/concepts/agents-harness-tooling.md#hackernoon-ai-coding-tips-map
  - ../../../../../docs/wiki/bmad/architecture.md
  - ../../../../../docs/wiki/rules/wiki-markdown-frontmatter-mandatory.md
  - ../../docs/wiki/concepts/ai-harness-module-discipline.md
status: draft
---

# Rating Module LLM Wiki

## AI / second brain

- [hackernoon-ai-coding-tips-map](../../../../../bashscripts/ai/wiki/concepts/agents-harness-tooling.md#hackernoon-ai-coding-tips-map)
- [bmad/architecture](../../../../../docs/wiki/bmad/architecture.md)
- [frontmatter + GitHub](../../../../../docs/wiki/rules/wiki-markdown-frontmatter-mandatory.md)
- ai-harness-module-discipline _(riferimento non presente nel repository, verificato 2026-10-14)_
- [second-brain-local-discipline](./concepts/second-brain-local-discipline.md) → canon Xot


Indice operativo del wiki Rating.

## Struttura canonica (sacred)

- [concepts/](./concepts/): Pattern architetturali e metodologie rating.
- [entities/](./entities/): Modelli e componenti chiave.
- sources/ _(riferimento non presente nel repository, verificato 2026-10-14)_: Dati di ricerca e link esterni.
- [comparisons/](./comparisons/): Implementazioni alternative.
- [decisions/](./decisions/): ADL (Architectural Decision Log).
- [troubleshooting/](./troubleshooting/): Problemi noti e soluzioni.
- _archive/ _(riferimento non presente nel repository, verificato 2026-10-14)_: Documentazione legacy.
- [_templates/](./_templates/): Template standard.

## Regole collegate

- [forbidden-folders-rule](../../../../../bashscripts/ai/wiki/concepts/modules-structure-rules.md#forbidden-folders): Vincoli strutturali strict.
- [llm-wiki-standard](../../../../../docs/project/karpathy-llm-wiki-adoption.md): Mapping repository e ciclo di vita conoscenza.

## On-Demand Entry Points

- [rules/INDEX](./rules/index.md) (case-duplicate anche `rules/index.md`): regole locali e root per Rating/XotBase/Filament.
- [skills/INDEX](./skills/index.md) (case-duplicate anche `skills/index.md`): skill locali e condivise da caricare on-demand.

## Scopo Rating Module

Gestione valutazioni, recensioni, rating polimorfici e moderazione.

## Compiled Pages

| Pagina | Tipo | Argomento | Data |
|--------|------|-----------|------|
| [.gitkeep](./concepts/.gitkeep) | Concept | - | 2026-04-21 |
| [filament-resource-zen-pattern](./concepts/filament-resource-zen-pattern.md) | Concept | Resource Filament senza override `form()`/`table()` | 2026-05-06 |
| [xotbase-table-columns-enforcement](./concepts/xotbase-table-columns-enforcement.md) | Concept | 4 Table files: RatingMorph and Rating populated | 2026-05-07 |

## Best Practices

- Usare Actions per rating logic (vedi [actions-over-services-governance](https://github.com/laraxot/platform/blob/main/.opencode/skills/actions-over-services-governance/SKILL.md))
- Implementare `casts()` method non `$casts` property (vedi model-casts-phpstan _(riferimento non presente nel repository, verificato 2026-10-14)_)
- Usare Eloquent polymorphic relations per rating (vedi eloquent-best-practices _(riferimento non presente nel repository, verificato 2026-10-14)_)

## Bad Practices

- NON creare Service classes - usare Actions (vedi [actions-over-services-governance](https://github.com/laraxot/platform/blob/main/.opencode/skills/actions-over-services-governance/SKILL.md))
- NON usare `dehydrated(false)` nei trait - blocca salvataggio (vedi Geo CoordinatePicker fix)
- NON hardcodare rating scale - usare Enums (vedi laravel-enums _(riferimento non presente nel repository, verificato 2026-10-14)_)

## False Friends

- `dehydrated(false)` sembra mantenere il campo nei dati ma blocca il salvataggio (vedi [coordinate-picker-filament5-save-pattern](../../../Geo/docs/wiki/concepts/coordinate-picker-filament5-save-pattern.md))
- `live()` in Filament non rende il campo sempre live - serve `$applyStateBindingModifiers()` (vedi [coordinate-picker-state-binding-rule](../../../Geo/docs/wiki/concepts/coordinate-picker-state-binding-rule.md))

## Troubleshooting

| Pagina | Tipo | Argomento |
|--------|------|-----------|
| [.gitkeep](./concepts/.gitkeep) | Concept | Template iniziale |

Aggiornato: 2026-05-12

## Contenuto fuso da `index.md`

- [hackernoon-ai-coding-tips-map](../../../../../bashscripts/ai/wiki/concepts/agents-harness-tooling.md#hackernoon-ai-coding-tips-map)
- [bmad/architecture](../../../../../docs/wiki/bmad/architecture.md)
- [frontmatter + GitHub](../../../../../docs/wiki/rules/wiki-markdown-frontmatter-mandatory.md)
- [ai-harness-module-discipline](../../docs/wiki/concepts/ai-harness-module-discipline.md)
- [second-brain-local-discipline](./concepts/second-brain-local-discipline.md) → canon Xot

- [concepts/](./concepts/): Pattern architetturali e metodologie rating.
- [entities/](./entities/): Modelli e componenti chiave.
- [sources/](./sources/): Dati di ricerca e link esterni.
- [comparisons/](./comparisons/): Implementazioni alternative.
- [decisions/](./decisions/): ADL (Architectural Decision Log).
- [troubleshooting/](./troubleshooting/): Problemi noti e soluzioni.
- [_archive/](./_archive/): Documentazione legacy.
- [_templates/](./_templates/): Template standard.

| Pagina | Tipo | Argomento | Data |
|--------|------|-----------|------|
| [.gitkeep](./concepts/.gitkeep) | Concept | - | 2026-04-21 |
| [filament-resource-zen-pattern](./concepts/filament-resource-zen-pattern.md) | Concept | Resource Filament senza override `form()`/`table()` | 2026-05-06 |
| [xotbase-table-columns-enforcement](./concepts/xotbase-table-columns-enforcement.md) | Concept | 4 Table files — RatingMorph and Rating populated | 2026-05-07 |

- Usare Actions per rating logic (vedi [actions-over-services-governance](https://github.com/laraxot/platform/blob/main/.opencode/skills/actions-over-services-governance/SKILL.md))
- Implementare `casts()` method non `$casts` property (vedi [model-casts-phpstan](../../../../../docs/wiki/concepts/model-casts-phpstan.md))
- Usare Eloquent polymorphic relations per rating (vedi [eloquent-best-practices](../../../../../docs/wiki/concepts/eloquent-best-practices.md))

- NON creare Service classes - usare Actions (vedi [actions-over-services-governance](https://github.com/laraxot/platform/blob/main/.opencode/skills/actions-over-services-governance/SKILL.md))
- NON usare `dehydrated(false)` nei trait - blocca salvataggio (vedi Geo CoordinatePicker fix)
- NON hardcodare rating scale - usare Enums (vedi [laravel-enums](../../../../../docs/wiki/concepts/laravel-enums.md))
