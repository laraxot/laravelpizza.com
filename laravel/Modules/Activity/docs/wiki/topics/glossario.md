---
title: "Topic glossario"
type: digest
status: active
qmd: "digest ceiling 100 glossario"
---

# Topic glossario

Sintesi automatica di 3 documenti (chiave `glossario`).

## Glossario Bank (Event Sourcing)

_Fonte: `use_cases/bank/glossario.md`_

# Glossario Bank (Event Sourcing)

- **Event Sourcing**: Pattern di persistenza basato su eventi immutabili.
- **Aggregate Root**: Oggetto che incapsula la logica di business e gestisce gli eventi di un'entità (es. conto bancario).
- **Proiettore**: Componente che genera viste di lettura dagli eventi.
- **Reattore**: Componente che gestisce effetti collaterali (es. invio email).
- **AccountCreated**: Evento di apertura conto.
- **MoneyAdded**: Evento di deposito fondi.
- **MoneySubtracted**: Evento di prelievo fondi.
- **AccountLimitHit**: Evento di superamento limite saldo.
- **LoanProposed**: Evento di proposta prestito.
- **Snapshotting**: Salvataggio dello stato corrente per ottimizzare la ricostruzione degli aggregate.

## Glossario <nome progetto>ion Market

_Fonte: `use_cases/prediction_market/glossario.md`_

# Glossario <nome progetto>ion Market

- **<nome progetto>ion Market**: Mercato di previsione, piattaforma per scommettere su eventi futuri.
- **Oracolo**: Servizio che fornisce dati reali a smart contract.
- **Smart Contract**: Contratto auto-eseguente su blockchain.
- **AMM**: Automated Market Maker, algoritmo per la liquidità automatica.
- **LMSR**: Logarithmic Market Scoring Rule, algoritmo per market making che garantisce liquidità automatica e prezzi dinamici nei <nome progetto>ion market.
- **Event Sourcing**: Pattern di persistenza basato su eventi immutabili.
- **Proiezione**: Vista di lettura generata dagli eventi.
- **Reattore**: Componente che gestisce effetti collaterali.
- **Aggregate Root**: Oggetto che incapsula la logica di business e gestisce gli eventi.
- **CQRS**: Separazione tra comandi (scrittura) e query (lettura).
- **Tokenizzazione**: Rappresentazione digitale di asset o quote tramite token.

## Glossario Shop Event Sourced

_Fonte: `use_cases/shop/glossario.md`_

# Glossario Shop Event Sourced

- **Event Sourcing**: pattern in cui ogni cambiamento di stato è registrato come evento immutabile. Esempio: `OrderCreated`.
- **CQRS**: separazione tra comandi (scrittura) e query (lettura).
- **Aggregate Root**: oggetto che incapsula la logica di business e gestisce gli eventi di un'entità (es. ordine).
- **Projector**: componente che aggiorna le proiezioni (tabelle di lettura) in risposta agli eventi.
- **Proiezione**: tabella o vista ottimizzata per la lettura, aggiornata dai projectors.
- **Reactor**: componente che gestisce effetti collaterali (es. invio email) in risposta agli eventi.
- **DTO (Data Transfer Object)**: oggetto immutabile per trasferire dati tra livelli.
- **State Machine**: gestione esplicita degli stati e delle transizioni di un'entità.
- **Comando**: azione che muta lo stato del sistema (es. `AddProductToCart`).
- **Query**: richiesta di dati senza effetti collaterali (es. `GetOrderDetails`).
- **Domain Exception**: eccezione lanciata quando una regola di business viene violata.
- **Replay**: ricostruzione dello stato tramite la riproduzione degli eventi.
- **Bounded Context**: area del dominio con regole e modelli propri (es. Order, Cart).
- **Zen**: filosofia di semplicità, chiarezza, single responsibility.
- **Command Bus**: pattern per disaccoppiare l'invio e la gestione dei comandi.
- **CRUD**: Create, Read, Update, Delete; approccio tradizionale senza event sourcing.
