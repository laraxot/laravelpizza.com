# Aggregate in Larabank

## Introduzione

In Larabank, l'aggregate (o radice aggregate) è il cuore della logica di business per la gestione dei conti bancari. Basandosi sull'approccio di Event Sourcing, l'aggregate incapsula lo stato di un conto e applica regole di business attraverso eventi.

## Funzionamento dell'Aggregate

L'aggregate in Larabank, probabilmente chiamato `AccountAggregateRoot`, è responsabile di:
- **Gestire lo Stato del Conto**: Mantiene il saldo corrente e la storia delle transazioni attraverso eventi come `DepositMade`, `WithdrawalMade`, ecc.
- **Applicare Regole di Business**: Controlla che il saldo non scenda sotto il limite di -5000. Se questo limite viene raggiunto, registra un evento per tracciare il superamento.
- **Automatizzare Azioni**: Se il limite di -5000 viene raggiunto tre volte consecutive, genera un evento che innesca l'invio di un'email di proposta di prestito.

## Esempio Concettuale di Aggregate

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

## Regole di Business

1. **Limite di Saldo**: L'aggregate impedisce prelievi che porterebbero il saldo sotto -5000, lanciando un'eccezione e registrando un evento `LimitHit`.
2. **Proposta di Prestito**: Dopo tre tentativi consecutivi di superare il limite, viene generato un evento `LoanProposalNeeded` che innesca l'invio di un'email.

## Applicazione al Modulo Activity

Nel contesto del modulo `Activity`, un aggregate simile potrebbe essere utilizzato per gestire budget o risorse allocate a progetti o attività:
- **Limiti di Budget**: Impedire spese che superano un budget definito, simile al limite di saldo.
- **Notifiche**: Inviare avvisi automatici agli stakeholder quando un budget sta per essere esaurito, simile alla proposta di prestito.

Questo approccio garantisce che tutte le operazioni siano tracciate come eventi, fornendo un audit trail completo e permettendo di ricostruire lo stato in qualsiasi momento.
