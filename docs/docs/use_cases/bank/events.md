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

5. **LoanProposalNeeded**:
   - **Descrizione**: Registra la necessità di inviare una proposta di prestito dopo tre tentativi consecutivi di superare il limite.
   - **Dati**: `uuid`.
   - **Esempio**: Dopo il terzo `LimitHit`, viene generato questo evento per innescare un'email.

## Implementazione degli Eventi

Gli eventi in Larabank sono probabilmente implementati come classi PHP che estendono una classe base fornita dal pacchetto `laravel-event-sourcing` di Spatie. Un esempio concettuale di un evento potrebbe essere:

```php
namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class DepositMade extends ShouldBeStored
{
    public function __construct(
        public string $uuid,
        public float $amount
    ) {}
}
```

## Flusso degli Eventi

1. Un'azione viene richiesta (es. prelievo).
2. L'aggregate verifica se l'azione è valida secondo le regole di business.
3. Se valida, viene generato un evento (es. `WithdrawalMade`) e applicato allo stato dell'aggregate.
4. Se non valida (es. saldo sotto il limite), viene generato un evento alternativo (es. `LimitHit`) e si accumula il conteggio dei tentativi.
5. Quando il conteggio raggiunge una soglia (tre `LimitHit`), viene generato un evento di follow-up (es. `LoanProposalNeeded`).

## Applicazione al Modulo Activity

Nel modulo `Activity`, eventi simili potrebbero essere utilizzati per tracciare attività finanziarie o di budget:
- **BudgetAllocated**: Registra l'assegnazione di un budget a un progetto o attività.
- **ExpenseRecorded**: Registra una spesa effettuata.
- **BudgetLimitHit**: Registra un tentativo di superare il budget assegnato.
- **BudgetWarningSent**: Innesca un avviso agli stakeholder dopo ripetuti tentativi di superare il limite.

Questo approccio garantisce una tracciabilità completa delle operazioni e permette di automatizzare notifiche o azioni correttive basate su eventi.
