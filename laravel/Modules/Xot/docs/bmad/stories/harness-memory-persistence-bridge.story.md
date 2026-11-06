---
title: "Allineare l'audit ECC alla memoria durevole PTVX"
type: story
module: Xot
status: analysis-and-design
created: 2026-10-28
updated: 2026-10-28
tags: [ecc, memory, qmd, second-brain]
qmd: "ECC memory persistence durable memory QMD Graphify second brain bridge Codex"
related:
  - codex-harness-audit-readiness.story.md
  - ../../ecc/ptvx-integration.md
---
# Allineare l'audit ECC alla memoria durevole PTVX

## Contesto

L'audit harness assegna 0/10 alla persistenza della memoria. PTVX ha già un second brain basato su QMD, Graphify, wiki e memorie indicizzate. Il punteggio va interpretato verificando quali meccanismi il tool ECC riconosce, senza duplicare la memoria né dichiarare equivalenti sistemi con semantiche diverse.

## User story

Come agente che lavora sul repository, voglio che l'harness riconosca i puntatori alla memoria PTVX, mantenendo una sola fonte di verità e la precedenza di `AGENTS.md`.

## Criteri di accettazione

- [ ] Mappare il requisito ECC alle memorie e ai meccanismi PTVX già esistenti.
- [ ] Stabilire se basta un puntatore/integration note nel punto di ingresso Codex.
- [ ] Non creare file di memoria paralleli né copiare contenuti esistenti.
- [ ] Documentare limiti di persistenza tra sessioni e indicizzazione QMD.
- [ ] Rieseguire l'audit dopo una modifica approvata e confrontare il punteggio.

## Task

- [ ] Esaminare i dettagli della failing check ECC e il suo criterio automatico.
- [ ] Consultare `AGENTS.md`, `00-TRIGGER_MAP.md` e le memorie second brain pertinenti.
- [ ] Proporre la modifica minima ai puntatori, quindi aggiornare QMD.

## Riferimenti

- `AGENTS.md`
- `bashscripts/ai/wiki/memories/agent-standing-order.md`
- `bashscripts/ai/wiki/rules/00-TRIGGER_MAP.md`
- `laravel/Modules/Xot/docs/ecc/ptvx-integration.md`
