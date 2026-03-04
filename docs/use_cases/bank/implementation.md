# Implementazione di un Sistema Bancario con Event Sourcing

## Introduzione

Questo documento fornisce una guida pratica per implementare un sistema bancario ispirato a Larabank nel modulo `Activity`, utilizzando l'Event Sourcing. L'obiettivo è tracciare operazioni finanziarie o di budget con tracciabilità completa e regole di business automatizzate.

## Prerequisiti

- Laravel 11.x o 12.x
- Pacchetto `spatie/laravel-event-sourcing` per gestire aggregate, eventi e proiettori.
- Conoscenza di base di Event Sourcing e CQRS.

## Passo 1: Configurazione dell'Ambiente

Seguendo le istruzioni di Larabank, configuriamo l'ambiente di sviluppo:

1. Clona il repository o crea una nuova struttura di progetto.
2. Copia `.env.example` in `.env` e imposta le variabili di ambiente relative al database (`DB_*`).
3. Crea un database con il nome specificato in `DB_DATABASE`.
4. Esegui `composer install` per installare le dipendenze.
5. Esegui `yarn` e `yarn run dev` (o equivalenti npm) per compilare gli asset frontend.
6. Esegui `php artisan migrate:fresh --seed` per migrare e popolare il database.
7. Puoi ora accedere con l'utente di esempio (es. `user@larabank.com`, password `secret`).

## Passo 2: Definizione degli Eventi

Definisci gli eventi che rappresentano le azioni nel sistema bancario:

- `AccountOpened`: Per la creazione di un nuovo conto.
- `DepositMade`: Per registrare un deposito.
- `WithdrawalMade`: Per registrare un prelievo.
- `LimitHit`: Per registrare quando il saldo raggiunge il limite.
- `LoanProposalNeeded`: Per innescare una proposta di prestito.

Esempio di evento:

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

## Passo 3: Creazione della Radice Aggregate

Crea una radice aggregate per gestire la logica di business del conto:

```php
namespace App\Aggregates;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class AccountAggregateRoot extends AggregateRoot
{
    private $balance = 0;
    private $limitHits = 0;
    private $limit = -5000;

    public static function openAccount(string $uuid, string $userId): self
    {
        $aggregate = new self();
        $aggregate->recordThat(new AccountOpened($uuid, $userId));
        return $aggregate;
    }

    public function deposit(float $amount)
    {
        if ($amount <= 0) {
            throw new \Exception('Deposit amount must be positive');
        }
        $this->recordThat(new DepositMade($this->uuid, $amount));
    }

    public function withdraw(float $amount)
    {
        if ($amount <= 0) {
            throw new \Exception('Withdrawal amount must be positive');
        }
        $newBalance = $this->balance - $amount;
        if ($newBalance < $this->limit) {
            $this->recordThat(new LimitHit($this->uuid, $newBalance));
            throw new \Exception('Withdrawal would exceed limit of ' . $this->limit);
        }
        $this->recordThat(new WithdrawalMade($this->uuid, $amount));
    }

    protected function applyAccountOpened(AccountOpened $event)
    {
        $this->uuid = $event->uuid;
    }

    protected function applyDepositMade(DepositMade $event)
    {
        $this->balance += $event->amount;
        $this->limitHits = 0; // Reset limit hits on successful deposit
    }

    protected function applyWithdrawalMade(WithdrawalMade $event)
    {
        $this->balance -= $event->amount;
        $this->limitHits = 0; // Reset limit hits
    }

    protected function applyLimitHit(LimitHit $event)
    {
        $this->limitHits++;
        if ($this->limitHits >= 3) {
            $this->recordThat(new LoanProposalNeeded($this->uuid));
            $this->limitHits = 0; // Reset after triggering proposal
        }
    }
}
```

## Passo 4: Implementazione dei Proiettori

Crea proiettori per aggiornare i modelli di lettura basati sugli eventi:

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

## Passo 5: Integrazione con l'Interfaccia Utente

Crea un controller per gestire le richieste dell'utente:

```php
namespace App\Http\Controllers;

use App\Aggregates\AccountAggregateRoot;

class AccountController extends Controller
{
    public function deposit(Request $request, string $uuid)
    {
        $amount = $request->input('amount');
        AccountAggregateRoot::retrieve($uuid)->deposit($amount)->persist();
        return response()->json(['success' => true, 'message' => 'Deposit successful']);
    }

    public function withdraw(Request $request, string $uuid)
    {
        $amount = $request->input('amount');
        try {
            AccountAggregateRoot::retrieve($uuid)->withdraw($amount)->persist();
            return response()->json(['success' => true, 'message' => 'Withdrawal successful']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
```

## Passo 6: Test

Scrivi test per verificare il comportamento del sistema:

- Test per la radice aggregate per garantire che i depositi e i prelievi funzionino correttamente e che il limite di saldo venga rispettato.
- Test per i proiettori per verificare che il saldo venga aggiornato correttamente nei modelli di lettura.

## Considerazioni sulle Performance

- **Snapshot**: Implementa snapshot per salvare lo stato della radice aggregate periodicamente, riducendo il numero di eventi da rigiocare per conti con molte transazioni.
- **Code**: Usa code Laravel per processare proiezioni in background, migliorando la reattività dell'applicazione.

## Applicazione al Modulo Activity

Adatta questo approccio per tracciare budget o spese nel modulo `Activity`:

- **Budget Management**: Usa una radice aggregate per gestire l'allocazione e l'uso del budget per progetti o attività.
- **Expense Tracking**: Registra le spese come eventi e usa proiettori per creare report di spesa.
- **Alerts**: Implementa notifiche automatiche quando un budget sta per essere esaurito, simile alla proposta di prestito in Larabank.

Seguendo questi passaggi, puoi implementare un sistema robusto e tracciabile per operazioni finanziarie nel modulo `Activity`, sfruttando i principi di Event Sourcing dimostrati in Larabank.
