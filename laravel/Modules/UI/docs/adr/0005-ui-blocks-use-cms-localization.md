---
title: "ADR — Blocchi UI localizzati dal CMS"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-23
issues: []
module: UI
qmd: "ui blocks use cms localization blocchi"
---

# ADR — Blocchi UI localizzati dal CMS

## Contesto

Un blocco può ricevere dati localizzati dal CMS oppure funzionare con default autonomi.

## Driver della decisione

- Riutilizzare i componenti senza rendere obbligatorio il CMS.

## Decisione

UI delega al CMS la localizzazione quando disponibile e mantiene fallback validi per i componenti indipendenti.

## Alternative scartate

- Hardcodare i testi nei componenti.

## Conseguenze

I blocchi restano data-driven e riusabili; il CMS non diventa una dipendenza implicita non dichiarata.

## Conferma

Verificare Action di risoluzione, fallback e test dei blocchi.

## Verifica

- `Modules/UI/app/Actions/Block/GetLocalizedBlockDataAction.php`: delega al resolver di Cms solo se la classe esiste,
  altrimenti restituisce i dati invariati (fallback autonomo).
- `Modules/UI/tests/Unit/Actions/Block/GetLocalizedBlockDataActionTest.php`: delega, ritorno invariato senza resolver
  valido, rifiuto delle chiavi non stringa.
- Meccanismo e dipendenze: [delega opzionale a Cms per i dati dei blocchi](0004-optional-cms-delegation-for-block-data.md).
- Non esiste un test che provi che i testi dei componenti non siano scritti nel codice: resta revisione del codice.
