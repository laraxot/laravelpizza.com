---
title: "Topic introduzione"
type: digest
status: active
qmd: "digest ceiling 100 introduzione"
---

# Topic introduzione

Sintesi automatica di 3 documenti (chiave `introduzione`).

## Introduzione al Use Case Bank (Event Sourcing)

_Fonte: `use_cases/bank/introduzione.md`_

# Introduzione al Use Case Bank (Event Sourcing)

Questo use case documenta la realizzazione di un sistema bancario ispirato a [larabank-aggregates](https://github.com/spatie/larabank-aggregates) di Spatie, che utilizza i pattern di event sourcing, aggregate root e proiettori per la gestione di conti correnti, transazioni e regole di business bancarie.

## Contesto
L'obiettivo è mostrare come implementare logiche bancarie robuste (limiti di saldo, notifiche, proposte di prestito) tramite eventi immutabili e aggregate che prendono decisioni in base allo storico degli eventi.

## Vantaggi
- Tracciabilità completa delle operazioni
- Facilità di audit e rollback
- Separazione tra logica di business (aggregate) e viste di lettura (proiezioni)
- Estendibilità tramite nuovi eventi e reattori

## Regole di Business Principali
- Un conto non può andare sotto -5000
- Se il limite viene raggiunto 3 volte di seguito, viene proposta un'offerta di prestito

La documentazione seguente dettaglia architettura, flussi, best practice e test per questo scenario.

## Introduzione al <nome progetto>ion Market

_Fonte: `use_cases/prediction_market/introduzione.md`_

# Introduzione al <nome progetto>ion Market

Un **<nome progetto>ion market** è una piattaforma dove gli utenti possono scommettere sull'esito di eventi futuri (politica, sport, economia, ecc.), aggregando la "saggezza della folla" per produrre previsioni statisticamente rilevanti. I <nome progetto>ion market moderni sono spesso decentralizzati (Web3), basati su blockchain e smart contract.

## Vantaggi
- Aggregazione della conoscenza collettiva
- Trasparenza e auditabilità
- Incentivi economici per la veridicità delle previsioni
- Applicazioni in politica, sport, economia, scienza

## Contesto
Questa documentazione descrive come progettare e realizzare un <nome progetto>ion market moderno, ispirato alle migliori piattaforme internazionali, utilizzando Laravel e i pattern di event sourcing.

## Novità: LMSR (Logarithmic Market Scoring Rule)
Il modulo integra ora la regola LMSR per garantire liquidità automatica e prezzi dinamici nei mercati predittivi. Per dettagli matematici e implementativi vedi il file `lmsr.md`.

## Introduzione: Lo Shop Event Sourced Definitivo

_Fonte: `use_cases/shop/introduzione.md`_

# Introduzione: Lo Shop Event Sourced Definitivo

## Visione e Filosofia

Costruire uno shop moderno non significa solo gestire prodotti e ordini, ma progettare un sistema che sia:
- **Auditabile**: ogni azione è tracciata, ogni stato è ricostruibile.
- **Estendibile**: ogni dominio (carrello, ordine, pagamento, inventario) è modulare e isolato.
- **Zen**: il codice è semplice, leggibile, ogni modulo fa una cosa sola e bene.
- **Politica della Trasparenza**: nessun dato viene perso, ogni cambiamento è un evento.
- **Religione della Separazione**: scrittura e lettura sono mondi separati (CQRS), la logica di business è nel dominio, la persistenza è un dettaglio.

## Perché Event Sourcing?
- **Storia completa**: puoi rispondere a "perché questo ordine è stato cancellato?".
- **Rollback e replay**: puoi correggere bug senza perdere dati.
- **Nuove proiezioni**: puoi aggiungere report, dashboard, viste senza cambiare la logica di business.

## Perché CQRS?
- **Performance**: letture ottimizzate, scritture atomiche.
- **Scalabilità**: puoi scalare lettura e scrittura separatamente.
- **Chiarezza**: ogni comando è un'intenzione esplicita, ogni query è una domanda chiara.

## Perché DDD?
- **Ubiquitous Language**: il codice parla il linguaggio del business.
- **Bounded Context**: ogni sottodominio (Order, Cart, Product, Payment) è autonomo.
- **Testabilità**: ogni regola è isolata e testabile.

## Obiettivo di questa documentazione
Questa guida non si limita a confrontare due progett
