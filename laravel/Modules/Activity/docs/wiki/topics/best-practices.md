---
title: "Topic best-practices"
type: digest
status: active
qmd: "digest ceiling 100 best-practices"
---

# Topic best-practices

Sintesi automatica di 3 documenti (chiave `best-practices`).

## Best Practices – Activity

_Fonte: `best-practices.md`_

# Best Practices – Activity

## Principi DRY/KISS
- **DRY**: Centralizza logica di orchestrazione in `ActivityService`. Usa repository pattern per entità.
- **KISS**: Usa ID semplici per identificatori esterni, non UUID complessi in interfacce.
- **Clean Code**: Applica `Spatie Color` per icone tematiche senza duplicare codice.

## Componenti
- Usa `ActivityLog` per registrare eventi critici.
- Usa progetti con `status` calcolato (`active`, `paused`, `completed`).

## Test
- Implementa test di integrazione per flussi di lavoro complessi.
- Copri casi limite come transizioni di stato non valide.

## Documentazione
- Aggiorna `docs/INDEX.md` con nuovi modelli e relazioni.
- Collega a `Projects` e `Tasks` per contesto operativo.
---
title: "Best Practices – Activity"
type: note
status: draft
updated: 2026-10-08
tags: [docs, activity]
qmd: "best practices   activity activity"
---
See canonical documentation: ../../../Themes/docs/shared-components/best_practices.md

# Best Practices – Activity

## Best Practices per un <nome progetto>ion Market

_Fonte: `use_cases/prediction_market/best-practices.md`_

# Best Practices per un <nome progetto>ion Market

Questa sezione raccoglie le migliori pratiche per progettare e gestire un <nome progetto>ion market nel modulo `Activity`, basandosi su analisi di piattaforme reali e sull'approccio Event Sourcing.

## 1. Trasparenza e Fiducia

- **Lezione da Piattaforme Reali**: Polymarket e Augur utilizzano blockchain per garantire che tutte le transazioni e i risultati siano verificabili su un ledger pubblico.
- **Applicazione**: Implementare un sistema di registrazione eventi immutabile, anche senza blockchain, per assicurare trasparenza. Ogni evento (`MarketCreated`, `BetPlaced`, ecc.) deve essere tracciabile con timestamp e dettagli verificabili.

## 2. Accessibilità e User Experience

- **Lezione da Piattaforme Reali**: Kalshi e Manifold Markets offrono interfacce intuitive e opzioni a basso rischio (es. denaro virtuale) per ridurre la barriera d'ingresso.
- **Applicazione**: Creare un'interfaccia utente semplice con guide interattive. Offrire mercati di prova con token virtuali per permettere agli utenti di familiarizzare senza rischi finanziari.

## 3. Liquidità del Mercato

- **Lezione da Piattaforme Reali**: Ruckus Market e Projection Finance utilizzano Automated Market Makers (AMM) e incentivi per fornitori di liquidità.
- **Applicazione**: Garantire che i mercati abbiano sempre liquidità sufficiente implementando meccanismi AMM, come la Logarithmic Market Scoring Rule (LMSR), che garantisce prezzi dinamici e liquidità automatica 

## Best Practices – Activity

_Fonte: `wiki/rules/best-practices.md`_

# Best Practices – Activity

## Principi DRY/KISS
- **DRY**: Centralizza logica di orchestrazione in `ActivityService`. Usa repository pattern per entità.
- **KISS**: Usa ID semplici per identificatori esterni, non UUID complessi in interfacce.
- **Clean Code**: Applica `Spatie Color` per icone tematiche senza duplicare codice.

## Componenti
- Usa `ActivityLog` per registrare eventi critici.
- Usa progetti con `status` calcolato (`active`, `paused`, `completed`).

## Test
- Implementa test di integrazione per flussi di lavoro complessi.
- Copri casi limite come transizioni di stato non valide.

## Documentazione
- Aggiorna `docs/index.md` con nuovi modelli e relazioni.
- Collega a `Projects` e `Tasks` per contesto operativo.
