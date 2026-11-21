---
title: "User — BMAD Setup Guide"
description: "Setup e configurazione BMAD per il modulo User"
module: "User"
alias: "user"
documentation_date: "2026-05-27"
bmad_version: "6.2.0"
---

# User — BMAD Setup Guide

## Scopo

Rendere ripetibile e verificabile l'uso del BMAD Method per il modulo User.

## Cosa è "BMAD" qui (Business Logic)

In questo modulo, BMAD serve a:
- **Centralizzare le decisioni di identità**: provider auth, social, 2FA sono definiti in PRD
- **Abilitare l'audit trail**: ogni azione utente viene tracciata in AuthenticationLog
- **Supportare la sicurezza**: PHPStan level 10, code review, test coprono la sicurezza
- **Facilitare la multi-tenancy**: configurazioni tenant isolate

## Struttura Directory (Canonical)

- **`_bmad/`**: moduli/agent/skills + configurazione
- **`_bmad-output/`**: artefatti generati (contesto, prd, architettura, ui spec, ecc.)
- **`docs/bmad/`**: questa documentazione

## Configurazione Lingua e Output

- **`_bmad/config.yaml`**: lingua output documenti + cartella output
- **`_bmad/config.user.yaml`**: preferenze utente (lingua comunicazione, nome)

## Verifica Minima ("Funziona")

La verifica pratica è: gli artefatti vanno dove devono andare, e le skill risultano invocabili.

- **skills disponibili**: cartella `_bmad/` presente e popolata
- **output**: la cartella `_bmad-output/` contiene almeno `project-context.md`
- **lingua**: le config utente/progetto non si resettano dopo update

## Check Post-Update (Anti-Regressione)

Dopo un update, ricontrollare che non si sia "spaccata" la coerenza tra moduli:
- Configurazioni provider auth coerenti tra moduli
- PHPStan level 10 passa
- Test suite passa
- Database connection `user` configurato correttamente

## Manutenzione (DRY + KISS)

- mantenere **un'unica fonte** per:
  - setup: questo file
  - comandi rapidi: `quick-reference.md`
- evitare duplicati in altre cartelle docs: negli altri indici usare link relativi a questi due file

## Vedi Anche

- [quick-reference](quick-reference.md)
- [Project Context](../../_bmad-output/project-context.md)

---

*User · BMAD Setup Guide · data 2026-05-27*