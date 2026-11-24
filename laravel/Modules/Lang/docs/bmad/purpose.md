---
title: "Scopo BMAD — Lang"
type: concept
status: active
updated: 2026-11-16
module: Lang
qmd: "purpose bmad Lang scopo traduzioni etichette fuori dal codice file di lingua chiavi mancanti stato del codice"
related:
  - ../purpose.md
  - ./audits/lang-audit.md
  - ./architecture.md
  - ./epics.md
---

# Scopo BMAD — Lang

## Lo scopo in una frase

**Lang tiene fuori dal codice ogni parola che un utente legge: nessuna etichetta si scrive dentro una classe, si dichiara in un file di lingua.**

Il perché esteso (regola «niente `->label()`», chiave come ponte, direzioni di miglioramento) è nella SSoT del modulo: [../purpose.md](../purpose.md). Qui solo la sintesi BMAD e il confronto con il codice.

## Perché conta in una PA

I testi di un'applicazione pubblica li rivede chi non programma. Se l'etichetta vive nella classe, ogni correzione di una parola è una modifica di codice; se vive in un file di lingua, è una modifica di contenuto.

## Confini

- Lang **risolve e custodisce** le chiavi; il significato del testo è del modulo che lo usa.
- La scrittura dei file di lingua passa da `SaveTransAction`/`SaveArrayAction` (Xot), mai da codice di dominio.

## Stato del codice rispetto allo scopo (verificato 2026-11-16)

| Promessa | Stato | Evidenza |
|---|---|---|
| Etichette risolte da chiave | **mantenuta** | `LangServiceProvider.php:48-125` (`configureUsing` su Field, Entry, Section, Column, Action, Filter, Step) → `AutoLabelAction` |
| Testi modificabili senza toccare il codice | **mantenuta** | `TranslationFileResource` + `EditTranslationFile` → `SaveTransAction::persist` |
| Il salvataggio non rompe le pagine | **mantenuta** | `SaveTransAction.php:68-75`: file illeggibile non riscritto; scrittura automatica solo in `local` (`:33`) |
| Chiave mancante visibile e non persa | **parziale** — nel file solo in `local`; su DB non cablato | `LangServiceProvider.php:43` ([P1-1](./audits/lang-audit.md#p1-1--il-tracker-chiavi-mancanti-su-db-non-è-cablato)) |
| Il modulo rispetta la propria regola | **violata in 2 punti** | `LocaleSwitcherRefresh.php:34,45` |
| Confini chiari | **da definire** | `Post` (CMS) dentro Lang, nessun consumatore esterno |

## Riferimenti

[Audit](./audit.md) · [Architettura](./architecture.md) · [Decision log](./decision-log.md) · [Epics](./epics.md)
