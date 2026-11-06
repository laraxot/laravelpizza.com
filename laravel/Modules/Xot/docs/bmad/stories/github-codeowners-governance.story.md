---
title: "Definire ownership prima di introdurre CODEOWNERS"
type: story
module: Xot
status: analysis-and-design
created: 2026-10-28
updated: 2026-10-28
tags: [ecc, github, codeowners, governance]
qmd: "ECC GitHub CODEOWNERS ownership review governance teams"
related:
  - codex-harness-audit-readiness.story.md
  - ../../ecc/ptvx-integration.md
---
# Definire ownership prima di introdurre CODEOWNERS

## Contesto

L'audit ECC raccomanda CODEOWNERS. Un file di ownership è utile solo se gli owner sono verificati, attivi e hanno accesso ai repository interessati. La struttura PTVX include repository annidati e non va assunta come un singolo repository GitHub.

## User story

Come maintainer, voglio definire ownership reale per percorsi e repository prima di configurare CODEOWNERS così che le revisioni automatiche raggiungano persone o team validi.

## Criteri di accettazione

- [ ] Rilevare root Git e remote GitHub attivi per i repository in scope.
- [ ] Identificare owner individuali o team GitHub verificabili per ciascuna area.
- [ ] Verificare permessi, disponibilità e copertura delle aree critiche.
- [ ] Proporre una mappa minima senza inventare username o team.
- [ ] Creare una story d'implementazione solo dopo aver risolto le ownership mancanti.

## Task

- [ ] Raccogliere remote e confini dei repository interessati.
- [ ] Validare gli owner tramite fonti repository/organizzazione attendibili.
- [ ] Documentare mappa, lacune e decisione di procedere o rinviare.

## Riferimenti

- `AGENTS.md`
- `laravel/Modules/Xot/docs/ecc/00-index.md`
- `laravel/Modules/Xot/docs/ecc/ptvx-integration.md`
