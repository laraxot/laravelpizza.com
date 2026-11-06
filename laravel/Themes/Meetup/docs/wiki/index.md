---
title: "Meetup Theme Wiki Index"
type: index
tags: [meetup, theme, wiki, index]
created: 2026-04-15
updated: 2026-06-05
qmd: "meetup theme wiki index second brain harness"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/272"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:

  - ../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md
  - ../../../../../docs/wiki/bmad/architecture.md
  - ../../../../../docs/wiki/rules/wiki-markdown-frontmatter-mandatory.md
  - ../../../Barthelemy/docs/wiki/concepts/ai-harness-theme-discipline.md
status: stale
---

> Nota 2026-10-08 (docs-audit): elenca cartelle che non esistono (entities, sources, comparisons, decisions, _archive) e una tabella Compiled Pages con il solo .gitkeep; ultimo aggiornamento 2026-04-28. Contenuto non riscritto, verificare prima di usarlo.


  - ../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md
  - ../../../../docs/wiki/bmad/architecture.md
  - ../../../../docs/wiki/rules/wiki-markdown-frontmatter-mandatory.md
  - ../../docs/wiki/concepts/ai-harness-theme-discipline.md
---


# Meetup Theme LLM Wiki

## AI / second brain


- [hackernoon-ai-coding-tips-fixcity-map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md)
- [bmad/architecture](../../../../../docs/wiki/bmad/architecture.md)
- [ai-harness-theme-discipline](../../../Barthelemy/docs/wiki/concepts/ai-harness-theme-discipline.md)
- [second-brain-operating-model](../../../../../docs/wiki/concepts/second-brain-operating-model.md)
- [second-brain-local-discipline](./concepts/second-brain-local-discipline.md) — stub tema
- [llm-wiki prompt](../../../../bashscripts/tools/prompts/llm-wiki.txt) _(target mancante, verificato 2026-10-08)_

- [hackernoon-ai-coding-tips-fixcity-map](../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md)
- [bmad/architecture](../../../../docs/wiki/bmad/architecture.md)
- [ai-harness-theme-discipline](../../docs/wiki/concepts/ai-harness-theme-discipline.md)
- [second-brain-operating-model](../../docs/wiki/concepts/second-brain-operating-model.md)
- [second-brain-local-discipline](./concepts/second-brain-local-discipline.md) — stub tema
- [llm-wiki prompt](../../../../bashscripts/tools/prompts/llm-wiki.txt)



Indice operativo del wiki Meetup.

## Struttura canonica (sacra)

- [concepts/](./concepts/): Pattern architetturali e metodologie tema.

- [entities/](./entities/) _(target mancante, verificato 2026-10-08)_: Componenti e layout chiave.
- [sources/](./sources/) _(target mancante, verificato 2026-10-08)_: Dati di ricerca e link esterni.
- [comparisons/](./comparisons/) _(target mancante, verificato 2026-10-08)_: Implementazioni alternative.
- [decisions/](./decisions/) _(target mancante, verificato 2026-10-08)_: Decisioni design tema.
- [troubleshooting/](./troubleshooting/): Problemi noti e soluzioni.
- [_archive/](./_archive/) _(target mancante, verificato 2026-10-08)_: Documentazione legacy.

- [entities/](./entities/): Componenti e layout chiave.
- [sources/](./sources/): Dati di ricerca e link esterni.
- [comparisons/](./comparisons/): Implementazioni alternative.
- [decisions/](./decisions/): Decisioni design tema.
- [troubleshooting/](./troubleshooting/): Problemi noti e soluzioni.
- [_archive/](./_archive/): Documentazione legacy.

- [_templates/](./_templates/): Template standard.

## Regole collegate

- [forbidden-folders-rule](../../../../../docs/wiki/concepts/forbidden-folders.md): Vincoli strutturali strict.
- [llm-wiki-standard](../../../../../docs/project/karpathy-llm-wiki-adoption.md): Mapping repository e ciclo di vita conoscenza.
- [theme-css-only-parity-rule](../../../Sixteen/docs/wiki/concepts/theme-css-only-parity-rule.md): CSS solo in tema, non inline.

## Scopo Meetup Theme

Tema per eventi e meetup con layout dedicati, calendario e integrazione mappe.

## Compiled Pages

| Pagina | Tipo | Argomento | Data |
|--------|------|-----------|------|

| [.gitkeep](./concepts/.gitkeep) _(target mancante, verificato 2026-10-08)_ | Concept | - | 2026-04-21 |

## Best Practices

- Usare componenti Blade riutilizzabili (vedi [blade-component-extraction-governance](../../../../../docs/wiki/concepts/blade-component-extraction-governance.md))
- Estendere XotBase classes per Folio pages (vedi [xotbase-check](../../../../../bashscripts/ai/wiki/commands/xotbase-check.md))
- Usare Vite per build tema (vedi [theme-vite-build](../../../../docs/wiki/concepts/theme-vite-build.md) _(target mancante, verificato 2026-10-08)_)

| [.gitkeep](./concepts/.gitkeep) | Concept | - | 2026-04-21 |

## Best Practices

- Usare componenti Blade riutilizzabili (vedi [blade-component-extraction-governance](../../../../docs/wiki/concepts/blade-component-extraction-governance.md))
- Estendere XotBase classes per Folio pages (vedi [xotbase-check](../../../../docs/wiki/concepts/xotbase-check.md))
- Usare Vite per build tema (vedi [theme-vite-build](../../../../docs/wiki/concepts/theme-vite-build.md))


## Bad Practices

- NON creare Service classes - usare Actions (vedi [actions-over-services-governance](https://github.com/laraxot/base_fixcity_fila5/blob/main/.opencode/skills/actions-over-services-governance/SKILL.md))
- NON usare `dehydrated(false)` nei trait - blocca salvataggio (vedi Geo CoordinatePicker fix)
- NON hardcodare stili eventi - usare config tema

## False Friends

- `dehydrated(false)` sembra mantenere il campo nei dati ma blocca il salvataggio (vedi [coordinate-picker-filament5-save-pattern](../../Geo/docs/wiki/concepts/coordinate-picker-filament5-save-pattern.md) _(target mancante, verificato 2026-10-08)_)
- `live()` in Filament non rende il campo sempre live - serve `$applyStateBindingModifiers()` (vedi [coordinate-picker-state-binding-rule](../../../../Modules/Geo/docs/wiki/concepts/coordinate-picker-state-binding-rule.md))

## Troubleshooting

| Pagina | Tipo | Argomento |
|--------|------|-----------|
| [.gitkeep](./concepts/.gitkeep) _(target mancante, verificato 2026-10-08)_ | Concept | Template iniziale |

Aggiornato: 2026-04-28
