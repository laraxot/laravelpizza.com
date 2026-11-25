---
title: "Topic events"
type: digest
status: active
qmd: "digest ceiling 100 events"
---

# Topic events

Sintesi automatica di 3 documenti (chiave `events`).

## Eventi in Larabank

_Fonte: `use_cases/bank/events.md`_

# Eventi in Larabank

## Introduzione

Gli eventi sono il nucleo dell'approccio Event Sourcing in Larabank. Ogni azione significativa che modifica lo stato di un conto bancario viene registrata come un evento. Questi eventi sono poi utilizzati per ricostruire lo stato del conto e per innescare azioni automatizzate.

## Eventi Principali in Larabank

Basandoci sul repository `larabank-aggregates` di Spatie, possiamo dedurre i seguenti eventi principali utilizzati per gestire i conti bancari:

1. **AccountOpened**:
   - **Descrizione**: Registra l'apertura di un nuovo conto bancario.
   - **Dati**: `uuid` (identificativo unico del conto), `userId` (identificativo dell'utente).
   - **Esempio**: Un nuovo utente apre un conto con ID univoco.

2. **DepositMade**:
   - **Descrizione**: Registra un deposito sul conto.
   - **Dati**: `uuid`, `amount` (importo depositato).
   - **Esempio**: Un utente deposita 1000 sul proprio conto.

3. **WithdrawalMade**:
   - **Descrizione**: Registra un prelievo dal conto.
   - **Dati**: `uuid`, `amount` (importo prelevato).
   - **Esempio**: Un utente preleva 500 dal proprio conto.

4. **LimitHit**:
   - **Descrizione**: Registra un tentativo di superare il limite di saldo negativo (-5000).
   - **Dati**: `uuid`, `attemptedBalance` (saldo tentato).
   - **Esempio**: Un prelievo porterebbe il saldo a -6000, quindi viene registrato un `LimitHit`.

## Eventi del <nome progetto>ion Market

_Fonte: `use_cases/prediction_market/events.md`_

# Eventi del <nome progetto>ion Market

Gli eventi sono il cuore del sistema di Event Sourcing per un <nome progetto>ion market. Di seguito sono elencati gli eventi principali che dovrebbero essere implementati nel modulo `Activity`.

## Eventi Principali

1. **MarketCreated**
   - **Descrizione**: Registra la creazione di un nuovo mercato di previsione.
   - **Dati**: `marketId`, `title`, `description`, `endDate`, `creatorId`.
   - **Esempio**: Un mercato viene creato per prevedere l'esito di una campagna sanitaria.

2. **BetPlaced**
   - **Descrizione**: Registra una scommessa effettuata da un utente su un'opzione del mercato.
   - **Dati**: `marketId`, `userId`, `optionId`, `amount`, `timestamp`.
   - **Esempio**: Un utente scommette 100 token sull'opzione "successo" di una campagna.

3. **MarketUpdated**
   - **Descrizione**: Registra un aggiornamento delle probabilità o dello stato del mercato.
   - **Dati**: `marketId`, `newProbabilities`, `timestamp`.
   - **Esempio**: Le probabilità di un'opzione cambiano in base alle scommesse ricevute.

4. **MarketResolved**
   - **Descrizione**: Registra la risoluzione del mercato con il risultato finale.
   - **Dati**: `marketId`, `winningOptionId`, `timestamp`.
   - **Esempio**: Il mercato si chiude e l'opzione "successo" è dichiarata vincitrice.

5. **PayoutDistributed**
   - **Descrizione**: Registra la distribuzione dei pagamenti agli utenti vincitori.
   - **Dati**: `marketId`, `userId`, `amount`, `timestamp`.

## Eventi del Carrello della Spesa

_Fonte: `use_cases/shop/events.md`_

# Eventi del Carrello della Spesa

## Introduzione

Gli eventi sono il cuore dell'Event Sourcing, rappresentando ogni modifica significativa allo stato del carrello della spesa. Questa sezione descrive gli eventi principali utilizzati nei progetti di Spatie.

## Eventi Principali

### Carrello

- **CartItemAdded**: Generato quando un articolo viene aggiunto al carrello. Contiene dettagli come ID articolo, quantità e prezzo.
- **CartItemRemoved**: Registra la rimozione di un articolo dal carrello.
- **CartCheckedOut**: Indica che il carrello è stato completato e pronto per diventare un ordine.

### Ordine

- **OrderPlaced**: Generato quando un carrello completato diventa un ordine.
- **OrderPaid**: Registra il pagamento di un ordine.
- **OrderShipped**: Indica che l'ordine è stato spedito.

### Pagamento

- **PaymentReceived**: Registra un pagamento ricevuto per un ordine.
- **PaymentFailed**: Indica il fallimento di un tentativo di pagamento.

## Ruolo degli Eventi

Gli eventi non solo tracciano le modifiche, ma guidano anche la logica di business. Ad esempio, un evento `CartCheckedOut` può triggerare la creazione di un ordine e la verifica dell'inventario. Questo approccio consente di mantenere un registro storico completo e di reagire a specifici cambiamenti di stato.
