---
title: "Docs moduli/temi ≤100 .md (ceiling)"
type: story
status: done
date: 2026-11-25
module: Xot
epic: docs-second-brain
decision-makers:
  - Xot
qmd: "docs ceiling 100 md modules themes consolidate synthesize swarm BMAD"
related:
  - ./0065-docs-topic-synthesis-swarm.story.md
  - ./0054-docs-100-fleet-merge-xot-story-md.story.md
  - ./0056-docs-consolidate-redundant-md.story.md
  - ../../../../../bashscripts/ai/wiki/memories/docs-consolidation-swarm.md
---

# Docs moduli/temi ≤100 .md (ceiling)

## Context and Problem Statement

Ogni cartella `docs/` di modulo/tema deve restare navigabile per umani e LLM.
Oggi 19/21 owner superano 100 file `.md` (Notify ~2400, User ~2100). Come
rientrare a ≤100 senza perdere decisioni attive, con unione e sintesi (non stub
redirect)?

## Decision Drivers

- Ordine utente: max 100 `.md` per `docs/` di modulo/tema; unire, compattare, sintetizzare
- BMAD + second brain + swarm parallelo + lock
- Conservare story `in-progress`/`review` e ADR/contracts essenziali
- History in git; niente commit da questa lane

## Considered Options

- Solo exact-dup (~288 rimozioni) — insufficiente
- Stub superseded ovunque — gonfia il conteggio
- **Ceiling script + topic synthesis fino a ≤100** — scelta

## Decision Outcome

Chosen: **tool `bashscripts/tools/docs/docs-ceiling-100.py` + esecuzione fleet**,
perché scala e rispetta il canone di sintesi (memoria `docs-consolidation-swarm`).

Fasi tool: (1) archive/raw digests + rm, (2) alias/superseded rm + indice,
(3) exact body dedupe, (4) cluster topic → wiki/topics, (5) overflow force-cap
con digest HISTORY.

### Consequences

- Good, because limite misurabile e ripetibile.
- Bad, because sintesi aggressiva può perdere nuance (mitigato: git history + skip active stories).

### Confirmation

- Conteggio per owner ≤100
- PHPStan N/A (solo md); Pest docs gate se tocca test
- Sprint `Xot/docs-ceiling-100` → done

## Acceptance Criteria

- [x] Tutti i `Modules/*/docs` e `Themes/*/docs` ≤100 `.md`
- [x] Story aperte stale digerate in overflow dove il keep-set (ADR+story) superava 100 (Xot); `0174` conservata
- [x] Tool in `bashscripts/tools/docs/docs-ceiling-100.py`
- [x] Memoria + sprint aggiornati

## Esito

Fleet apply `docs-ceiling-100.py --all --apply` + Xot surgical cap.
Tutti i 21 owner `docs/` ≤100 `.md` (Xot 99; Pdnd 70; Three 15; resto 100).
Tool: `bashscripts/tools/docs/docs-ceiling-100.py`.
Sprint: `Xot/docs-ceiling-100` → done.
