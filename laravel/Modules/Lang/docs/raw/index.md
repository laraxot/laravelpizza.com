---
issues: []
discussions: []
title: "Raw Sources — Lang"
module: "Lang"
type: concept
tags: [guida, migrazione, step, by]
created: 2026-07-14
updated: 2026-07-14
qmd: "guida migrazione step by step"
related:
  - "./italian-text-refined-audit-report.md"
---
# Raw Sources — Lang

Questo layer contiene le fonti grezze: documenti immutabili che l'LLM legge ma non modifica.

## Cosa appartiene al layer raw

Il layer raw per questo modulo/tema è **l'intera cartella `docs/`** (esclusa `docs/wiki/`):

| Cartella / file | Tipo |
|----------------|------|
| `docs/*.md` | Documentazione operativa, regole, guide |
| `docs/stories/` | User stories e specifiche |
| `docs/archived/` | Documenti superati ma consultabili |
| `docs/raw/` | Dump HTML, JSON, asset di analisi (questa cartella) |
| `docs/prompts/` | Prompt e istruzioni agentiche |

## Regola

> **I file raw non vengono riscritti.**
> Se serve una sintesi, va in `docs/wiki/`, non nella fonte.

## Dove va la sintesi

→ `docs/wiki/index.md` — catalogo dei nodi di conoscenza
→ `docs/wiki/log.md` — log append-only degli ingest
→ `docs/wiki/concepts/`, `entities/`, `summaries/` — pagine wiki tematiche

## Schema di riferimento

→ `docs/.schema/wiki-schema.md` (root progetto)
→ `docs/project/llm-wiki-module-adoption.md` (guida per moduli/temi)

---

*Ultimo aggiornamento: 2026-04-15*
