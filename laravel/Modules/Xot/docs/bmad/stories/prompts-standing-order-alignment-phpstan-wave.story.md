---
title: "Prompt bashscripts — allineamento standing order (wave PHPStan)"
type: story
module: Xot
status: review
created: 2026-11-16
updated: 2026-11-23
tags: [bmad, prompts, standing-order, phpstan, pest, public_html, second-brain]
qmd: "prompts standing order alignment phpstan wave BMAD second brain swarm pest public_html mixed anti-thrashing"
related:
  - ./docs-prompts-reorganization.story.md
  - ./docs-md-filename-date-debt.story.md
---

# prompts-standing-order-alignment-phpstan-wave

## Scopo

Rimuovere residui di merge nei prompt e allinearli allo standing order (BMAD, second brain, swarm random, Pest gate, mixed ultima spiaggia, docs kebab senza date, public_html, dati sacri, anti-thrashing PHPStan) senza ridondanza.

## Fase

`review`

## Lock

`prompts-standing`

## File toccati (canonici attuali)

| File | Azione |
|---|---|
| `bashscripts/docs/prompts/00-master-prompt.md` | Anti-thrashing PHPStan; path story `docs/bmad/stories/` esplicito |
| `bashscripts/docs/prompts/04-swarm-multi-agente.md` | Pest gate in lane; standing order; anti-thrashing; mixed non silenziatore |
| `bashscripts/docs/prompts/05-second-brain.md` | Standing order one-liner; diario/debito in story |
| `bashscripts/docs/prompts/36-quality-gates.md` | Path story canonico `docs/bmad/stories/` (legacy `docs/stories/`); pest/mixed/public_html |
| `bashscripts/docs/prompts/37-phpstan.md` | Sezione anti-thrashing; Pest gate in wave; qmd aggiornato |

Nota numerazione: i vecchi alias `00-start` / `11-phpstan` / `15-bmad` sono `01-start` / `37-phpstan` / `03-bmad` (vedi README prompts).

## Criteri

- [x] Un corpo per i prompt prioritari
- [x] Master espone Pest / public_html / mixed / dati sacri / swarm / anti-thrashing
- [x] `36-quality-gates` non contraddice `03-bmad` sul path story
- [x] Pest: skip — solo markdown prompts (nessun PHP toccato)
- [x] `qmd update`: eseguito (`llm-wiki-qmd.sh update`); indice `ptvx-fila5` senza collection locale ("No collections found") — embeddings OK su cache; search via collezioni globali qmd

## Contraddizioni residuali (fuori priorita' wave)

Prompt non prioritari ancora citano `docs/stories/` come path primario: `10-architettura.md`, `15-services-verso-actions.md`, `17-controller-verso-folio-actions.md`, `44-audit-autonomo.md`, `98-daily-report.md`. Canonico: `docs/bmad/stories/` (`99-closing-ritual.md` e `03-bmad.md` gia' allineati).

## Spot-check docs moduli

Vedi [docs-md-filename-date-debt.story.md](./docs-md-filename-date-debt.story.md). Nessuna rinomina di massa in questa wave.

## Coordinamento

| Quando | Agente | Scope | Nota |
|---|---|---|---|
| 2026-11-16 | fila5-lane-B | prompts 00/11/15/17/19 | lock `prompts-standing` |
| 2026-11-23 | docs-guardian | prompts 00/04/05/36/37 + story debt | allineamento standing order; AI assente; Notify/Xot debito documentato |

## Diario

### 2026-11-23

- Audit prioritario: `00`, `04`, `05`, `36`, `37`. Gap: path story legacy in `36`; pest/anti-thrashing/mixed/public_html incompleti in swarm/second-brain/phpstan.
- Fix applicati sui cinque prompt; spot-check AI (assente), Notify (indici broken + naming), Xot (consolidated `-N` + link dated).
- Moratoria rename di massa confermata.
---
