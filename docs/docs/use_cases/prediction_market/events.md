# Eventi del Prediction Market

Gli eventi sono il cuore del sistema di Event Sourcing per un prediction market. Di seguito sono elencati gli eventi principali che dovrebbero essere implementati nel modulo `Activity`.

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
   - **Esempio**: Un utente riceve 150 token per aver scommesso sull'opzione corretta.

## Implementazione degli Eventi

**Esempio di Evento `BetPlaced` in Laravel**:
```php
namespace Modules\Activity\Events\PredictionMarket;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class BetPlaced extends ShouldBeStored
{
    public function __construct(
        public string $marketId,
        public string $userId,
        public string $optionId,
        public float $amount,
        public string $timestamp
    ) {}
}
```

Questi eventi devono essere registrati da una radice aggregate come `PredictionMarketAggregateRoot` per garantire la coerenza dello stato.
