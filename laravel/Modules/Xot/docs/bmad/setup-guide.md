---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "setup guide"
issues: []
discussions: []
title: "Xot — BMAD Setup Guide"
description: "Setup e configurazione BMAD per il modulo Xot"
module: "Xot"
alias: "xot"
documentation_date: "2026-05-27"
bmad_version: "6.2.0"
---

# Xot — BMAD Setup Guide

## Scopo

Rendere ripetibile e verificabile l'uso del BMAD Method per il modulo Xot.

## Cosa è "BMAD" qui (Business Logic)

In questo modulo, BMAD serve a:
- **Stabilire le regole architetturali**: le classi base, le convenzioni, i pattern
- **Abilitare l'audit trail**: ogni modulo che estende Xot deve seguire le regole
- **Supportare la qualità**: PHPStan level 10, Pest, code review garantiscono qualità
- **Facilitare la manutenzione**: un fix in Xot si propaga a tutti i 46 moduli

## Struttura Directory (Canonical)

- **`docs/bmad/`**: questa documentazione
- **`_bmad-output/`**: artefatti generati (repo root: `_bmad-output/implementation-artifacts/`)
- **`_bmad/`**: framework BMAD esterno (non incluso nel repo; installato via BMAD CLI)

## Configurazione Lingua e Output

- **`_bmad/config.yaml`**: lingua output documenti + cartella output (esterno al repo)
- **`_bmad/config.user.yaml`**: preferenze utente (lingua comunicazione, nome) (esterno al repo)

## Verifica Minima ("Funziona")

La verifica pratica è: gli artefatti vanno dove devono andare, e le skill risultano invocabili.

- **skills disponibili**: BMAD CLI installato e configurato (`_bmad/` esterno al repo)
- **output**: la cartella `_bmad-output/` (repo root) contiene `implementation-artifacts/`
- **lingua**: le config utente/progetto non si resettano dopo update

## Check Post-Update (Anti-Regressione)

Dopo un update, ricontrollare che non si sia "spaccata" la coerenza tra moduli:
- PHPStan level 10 passa per tutti i moduli che estendono Xot
- Test suite passa per tutti i moduli
- `XotBaseServiceProvider` boot() funziona per tutti i moduli

## Manutenzione (DRY + KISS)

- mantenere **un'unica fonte** per:
  - setup: questo file
  - comandi rapidi: `quick-reference.md`
- evitare duplicati in altre cartelle docs: negli altri indici usare link relativi a questi due file

## Vedi Anche

- [quick-reference](quick-reference.md)

---

*Xot · BMAD Setup Guide · data 2026-05-27*