---
title: "Topic architettura"
type: digest
status: active
qmd: "digest ceiling 100 architettura"
---

# Topic architettura

Sintesi automatica di 3 documenti (chiave `architettura`).

## Architettura Bank (Event Sourcing)

_Fonte: `use_cases/bank/architettura.md`_

# Architettura Bank (Event Sourcing)

## Pattern Principali
- **Event Sourcing**: ogni operazione bancaria (apertura conto, deposito, prelievo, limite raggiunto) è registrata come evento immutabile.
- **Aggregate Root**: la logica di business (es. calcolo saldo, verifica limiti) è centralizzata nell'aggregate del conto.
- **Proiettori**: generano viste di lettura (es. saldo attuale, storico movimenti) a partire dagli eventi.
- **Reattori**: gestiscono effetti collaterali (es. invio email per proposta prestito).

## Struttura Consigliata
- Modulo Bank con:
  - Aggregate per il conto
  - Eventi: AccountCreated, MoneyAdded, MoneySubtracted, AccountLimitHit, LoanProposed
  - Proiettori per saldo e storico movimenti
  - Reattori per notifiche e automazioni
- Database solo per eventi e proiezioni (nessun dato "di stato" mutabile)
- Test automatici su regole di business e proiezioni

## Tecnologie
- Laravel
- spatie/laravel-event-sourcing

Questa architettura garantisce coerenza, auditabilità e facilità di estensione.

## Architettura di un <nome progetto>ion Market

_Fonte: `use_cases/prediction_market/architettura.md`_

# Architettura di un <nome progetto>ion Market

## Pattern Principali
- **Event Sourcing**: ogni cambiamento di stato è registrato come evento immutabile.
- **Proiezioni**: viste di lettura generate dagli eventi (es. saldo, classifica, storico scommesse).
- **Reattori**: gestiscono effetti collaterali (notifiche, pagamenti, aggiornamento quote).
- **Aggregate Root**: incapsula la logica di business e garantisce la coerenza dello stato.
- **CQRS**: separa le operazioni di scrittura (comandi) da quelle di lettura (query).
- **Bus dei Comandi**: instrada i comandi verso le aggregate root.
- **Oracoli**: servizi che forniscono dati reali (esito eventi) agli smart contract.
- **Microservizi**: ogni dominio (mercato, utente, pagamento) può essere un servizio separato.

## Struttura Consigliata
- Moduli separati per Activity (mercati), User (utenti), Wallet (pagamenti), Oracle (esiti)
- Event sourcing tramite `spatie/laravel-event-sourcing`
- CQRS e bus dei comandi
- Integrazione con oracoli esterni per la chiusura dei mercati
- Proiezioni ottimizzate per query rapide
- Snapshotting per aggregati con molti eventi

## Approccio Minimalista e Pragmatico (ispirato a cnastasi/event-sourcing-with-laravel)
- Per PoC/demo, una struttura semplice con pochi context e comandi console è efficace e facilmente testabile.
- **Context**: separare la logica in MarketContext, UserContext, WalletContext, OracleContext.
- **Console Commands**: entrypoint principale per interagire con il dominio (es. `

## Architettura di uno Shop Event Sourced

_Fonte: `use_cases/shop/architettura.md`_

# Architettura di uno Shop Event Sourced

## 1. Modularità e Bounded Context
- Ogni dominio (Order, Cart, Product, Payment, Inventory, Customer) è una cartella autonoma.
- Ogni dominio contiene: AggregateRoot, Events, Projectors, Projections, Actions, DTO, State, Exceptions.

## 2. Event Sourcing
- Ogni cambiamento di stato è un evento immutabile (es. `OrderCreated`, `ProductAddedToCart`).
- Gli eventi sono l'unica fonte di verità: lo stato si ricostruisce dal log eventi.
- **Esempio**:
```php
class OrderCreated extends ShouldBeStored {
    public function __construct(public string $orderUuid, public OrderData $orderData, public Carbon $createdAt) {}
}
```

## 3. CQRS (Command Query Responsibility Segregation)
- **Comandi**: mutano lo stato (es. `CreateOrder`, `AddProductToCart`).
- **Query**: leggono lo stato (es. `GetOrderDetails`).
- **Pro**: performance, chiarezza, scalabilità.
- **Contro**: maggiore complessità iniziale.

## 4. Aggregate Root
- Incapsula la logica di business e decide se un evento può essere registrato.
- Garantisce la coerenza delle regole di dominio.
- **Esempio**:
```php
class OrderAggregateRoot extends AggregateRoot {
    public function create(Cart $cart) { ... }
    public function complete(string $invoicePath) { ... }
