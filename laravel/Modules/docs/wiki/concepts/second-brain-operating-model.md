---
title: "Second Brain Operating Model (Modules)"
type: concept
tags: [second-brain, modules, para, llm-wiki, bmad]
created: 2026-05-19
updated: 2026-06-05
qmd: "second brain operating model modules para capture organize distill express bmad"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/272"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ./ai-harness-module-discipline.md
  - ../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md
  - ../../Xot/docs/wiki/concepts/second-brain-local-discipline.md
---

# Second Brain Operating Model (Modules)

## Perché

Il second brain dei moduli trasforma documentazione in **memoria operativa**: meno rework, decisioni coerenti, agenti successivi allineati (Tip 020).

## Modello pratico (CODE + PARA)

- **Capture**: ogni bugfix/decisione → wiki modulo owner + `log.md`
- **Organize**: cartelle semantiche (`concepts`, `troubleshooting`, `decisions`)
- **Distill**: scopo, rischio, trade-off — non solo «come»
- **Express**: `index.md` + cross-link + frontmatter con issue/discussion pertinenti

## AI harness (Tips integrati)

| Fase | Tip | Azione modulo |
|------|-----|----------------|
| Prima del prompt | 001 | `git status`; forward-only — no stash/reset impliciti |
| Piano | 003 | Story/dev-story prima di edit; poi act |
| Contesto | 009 | QMD `-n 5`, no dump |
| Chiusura | 016 | Issue owner modulo in frontmatter |
| Qualità | 006/021 | PHPStan, no workslop |

Dettaglio: [ai-harness-module-discipline.md](./ai-harness-module-discipline.md) · [mappa HackerNoon](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md)

## Struttura PARA

- **Projects**: story/incident in corso
- **Areas**: regole stabili (XotBase, migrate, quality gates)
- **Resources**: riferimenti Laravel/Filament
- **Archive**: storico non attivo

## Best practices

- Aggiornare `index.md` e `log.md` con nuova conoscenza
- Modulo owner documenta; consumer **linkano**, non duplicano
- File `.md` minuscolo; frontmatter validator prima di commit doc
- Link ufficiali framework quando la regola dipende da versione

## Bad practices

- Duplicare corpo policy root in ogni modulo
- Frontmatter con `.../issues/` senza numero o issue non pertinenti
- Log senza impatto su codice/workflow

## Stack ricerca

QMD primario; Redis (cache/lock) ed Elasticsearch solo se pain misurato — [second-brain-search-stack.md](../../../../../docs/wiki/concepts/second-brain-search-stack.md).

## Collegamenti

- [ai-harness-module-discipline.md](./ai-harness-module-discipline.md)
- [bmad architecture](../../../../../docs/wiki/bmad/architecture.md)
