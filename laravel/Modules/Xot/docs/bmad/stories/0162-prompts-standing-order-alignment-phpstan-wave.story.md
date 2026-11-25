---
title: "Prompt bashscripts — allineamento standing order (wave PHPStan)"
type: story
module: Xot
status: review
created: 2026-11-16
updated: 2026-11-25
tags: [bmad, prompts, standing-order, phpstan, pest, public_html, second-brain]
qmd: "prompts standing order alignment phpstan wave BMAD second brain swarm pest public_html mixed anti-thrashing"
related:
  - ./0063-docs-prompts-reorganization.story.md
  - ./0060-docs-md-filename-date-debt.story.md
  - ./0161-prompts-boy-scout-standing-order.story.md
---
# prompts-standing-order-alignment-phpstan-wave

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Scopo

Rimuovere residui di merge nei prompt e allinearli allo standing order (BMAD, second brain, swarm random, Pest gate, mixed ultima spiaggia, docs kebab senza date, public_html, dati sacri, anti-thrashing PHPStan) senza ridondanza.

## Fase

`review`

## Lock

`prompts-standing`

## File toccati (canonici attuali)

| File | Azione |
|---|---|
| `bashscripts/docs/prompts/agent-workflow.md` | Anti-thrashing PHPStan; path story `docs/bmad/stories/` esplicito |
| `bashscripts/docs/prompts/agent-workflow.md` | Pest gate in lane; standing order; anti-thrashing; mixed non silenziatore |
| `bashscripts/docs/prompts/agent-workflow.md` | Standing order one-liner; diario/debito in story |
| `bashscripts/docs/prompts/quality-gates.md` | Path story canonico `docs/bmad/stories/` (legacy `docs/stories/`); pest/mixed/public_html |
| `bashscripts/docs/prompts/quality-gates.md` | Sezione anti-thrashing; Pest gate in wave; qmd aggiornato |

Nota numerazione: i vecchi alias `00-start` / `11-phpstan` / `15-bmad` sono `01-start` / `37-phpstan` / `03-bmad` (vedi README prompts).

## Criteri

- [x] Un corpo per i prompt prioritari
- [x] Master espone Pest / public_html / mixed / dati sacri / swarm / anti-thrashing
- [x] `36-quality-gates` non contraddice `03-bmad` sul path story
- [x] Pest: skip — solo markdown prompts (nessun PHP toccato)
- [x] `qmd update`: eseguito (`llm-wiki-qmd.sh update`); indice `ptvx-fila5` senza collection locale ("No collections found") — embeddings OK su cache; search via collezioni globali qmd

## Contraddizioni residuali (fuori priorita' wave)

**Chiuso 2026-11-24 (docs-guardian):** `10`, `15`, `17`, `44`, `98` (+ `11`, `16`, `51`, `53`, `54`, `56`) allineati a `docs/bmad/stories/` primario; `docs/stories/` solo come legacy esplicito. Dettaglio: [0161-prompts-boy-scout-standing-order.story.md](0161-prompts-boy-scout-standing-order.story.md).

## Spot-check docs moduli

Vedi [0060-docs-md-filename-date-debt.story.md](0060-docs-md-filename-date-debt.story.md). Nessuna rinomina di massa in questa wave.

## Coordinamento

| Quando | Agente | Scope | Nota |
|---|---|---|---|
| 2026-11-16 | fila5-lane-B | prompts 00/11/15/17/19 | lock `prompts-standing` |
| 2026-11-23 | docs-guardian | prompts 00/04/05/36/37 + story debt | allineamento standing order; AI assente; Notify/Xot debito documentato |
| 2026-11-25 | composer-docs | prompts DRY residuals | lock `prompts-audit-20261125-composer`; vedi boy-scout story |

## Diario

### 2026-11-25

- Audit composer-docs (lock `prompts-audit-20261125-composer`): residui DRY su README/`replaces`, lessico report, path BMAD in one-liner quality-gates. Dettaglio: [0161-prompts-boy-scout-standing-order.story.md](0161-prompts-boy-scout-standing-order.story.md). Marker merge rimossi da questa story (working tree).

### 2026-11-24

- Lane docs-guardian boy-scout: vedi [0161-prompts-boy-scout-standing-order.story.md](0161-prompts-boy-scout-standing-order.story.md). Flock path unificato; Filament 5 Schema; `wiki-hygiene.py` rimosso dai prompt.
- Seconda wave: debito `docs/stories/` su 10/15/17/44/98 chiuso; 51/54/56 + 11/16/53 allineati a master (flock max-3, Pest/host, public_html, mixed last resort).

### 2026-11-23

- Audit prioritario: `00`, `04`, `05`, `36`, `37`. Gap: path story legacy in `36`; pest/anti-thrashing/mixed/public_html incompleti in swarm/second-brain/phpstan.
- Fix applicati sui cinque prompt; spot-check AI (assente), Notify (indici broken + naming), Xot (consolidated `-N` + link dated).
- Moratoria rename di massa confermata.
---


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
