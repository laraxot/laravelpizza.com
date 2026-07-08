# Proiettori in Larabank

## Introduzione

I proiettori in Larabank sono utilizzati per trasformare gli eventi registrati dall'aggregate in viste di lettura ottimizzate per query e report. Questo approccio è tipico dell'Event Sourcing e del pattern CQRS (Command Query Responsibility Segregation), dove la logica di scrittura (comandi) è separata dalla logica di lettura (query).

## Funzione dei Proiettori

I proiettori ascoltano gli eventi generati dall'aggregate (es. `DepositMade`, `WithdrawalMade`) e aggiornano tabelle o modelli di lettura nel database. Queste viste di lettura sono progettate per essere efficienti per operazioni di lettura, come mostrare il saldo corrente o generare report.

## Esempi di Proiettori in Larabank

Basandoci sul repository `larabank-aggregates` di Spatie, possiamo dedurre i seguenti proiettori probabili:

1. **AccountBalanceProjector**:
   - **Eventi gestiti**: `AccountOpened`, `DepositMade`, `WithdrawalMade`.
   - **Descrizione**: Aggiorna il saldo corrente di un conto in una tabella di lettura.
   - **Tabella di destinazione**: `account_balances` (ipotetica).
   - **Esempio**: Quando un `DepositMade` viene registrato, il proiettore aumenta il saldo del conto corrispondente.

2. **LimitHitTrackerProjector**:
   - **Eventi gestiti**: `LimitHit`, `LoanProposalNeeded`.
   - **Descrizione**: Tiene traccia dei tentativi di superare il limite di saldo negativo e registra quando una proposta di prestito è necessaria.
   - **Tabella di destinazione**: `limit_hits` (ipotetica).
   - **Esempio**: Incrementa un contatore per ogni `LimitHit` e resetta il contatore quando viene generato un `LoanProposalNeeded`.

3. **EmailNotificationProjector**:
   - **Eventi gestiti**: `LoanProposalNeeded`.
   - **Descrizione**: Innesca l'invio di un'email di proposta di prestito quando il limite è stato raggiunto tre volte consecutive.
   - **Azione**: Non aggiorna una tabella, ma invia una notifica (es. tramite una coda di lavoro).
   - **Esempio**: Quando riceve un `LoanProposalNeeded`, invia un'email all'utente associato al conto.

## Esempio Concettuale di Proiettore

```php
namespace App\Projectors;

use App\Events\DepositMade;
use App\Events\WithdrawalMade;
use App\Models\AccountBalance;
use Spatie\EventSourcing\Projectionist\ShouldBeCalled;

class AccountBalanceProjector implements ShouldBeCalled
{
    public function onAccountOpened(AccountOpened $event, string $uuid)
    {
        $balance = new AccountBalance();
        $balance->uuid = $uuid;
        $balance->user_id = $event->userId;
        $balance->balance = 0;
        $balance->save();
    }

    public function onDepositMade(DepositMade $event, string $uuid)
    {
        $balance = AccountBalance::where('uuid', $uuid)->firstOrFail();
        $balance->balance += $event->amount;
        $balance->save();
    }

    public function onWithdrawalMade(WithdrawalMade $event, string $uuid)
    {
        $balance = AccountBalance::where('uuid', $uuid)->firstOrFail();
        $balance->balance -= $event->amount;
        $balance->save();
    }
}
```

## Idempotenza dei Proiettori

Un aspetto cruciale dei proiettori in Larabank è che devono essere idempotenti. Questo significa che rigiocare gli stessi eventi più volte non deve portare a risultati incoerenti (es. duplicare il saldo). Per questo, i proiettori usano metodi come `firstOrFail()` o meccanismi di aggiornamento incrementale.

## Applicazione al Modulo Activity

Nel modulo `Activity`, proiettori simili potrebbero essere utilizzati per creare viste di lettura utili:
- **BudgetSummaryProjector**: Aggiorna una tabella con il budget corrente per progetto o attività, basata su eventi come `BudgetAllocated` e `ExpenseRecorded`.
- **AlertTriggerProjector**: Innesca notifiche quando vengono registrati eventi come `BudgetLimitHit`, simile a `EmailNotificationProjector`.
- **ActivityReportProjector**: Crea report aggregati per mostrare trend di spesa o utilizzo risorse, utili per dashboard.

Questo approccio separa la logica di scrittura (gestita dall'aggregate) dalla logica di lettura (gestita dai proiettori), migliorando le performance e la scalabilità del sistema.
