# Pattern State in Laravel

Questa documentazione descrive l'implementazione del pattern State in Laravel, basata sulla serie "Laravel Beyond CRUD" e adattata alle esigenze del progetto il progetto.

## Introduzione

Il pattern State è uno dei modi migliori per aggiungere comportamenti specifici agli stati dei modelli, mantenendo il codice pulito e organizzato. È particolarmente utile quando si ha a che fare con modelli che possono trovarsi in diversi stati e devono comportarsi in modo diverso in base al loro stato corrente.

## Implementazione Base

### 1. Classe State Astratta

```php
<?php

namespace Domain\Invoices\States;

abstract class InvoiceState
{
    protected Invoice $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    abstract public function label(): string;
    
    abstract public function color(): string;
    
    public function canTransitionTo(InvoiceState $state): bool
    {
        return true;
    }
}
```

### 2. Stati Concreti

```php
<?php

namespace Domain\Invoices\States;

class PendingState extends InvoiceState
{
    public function label(): string
    {
        return 'In Attesa';
    }
    
    public function color(): string
    {
        return 'yellow';
    }
    
    public function canTransitionTo(InvoiceState $state): bool
    {
        return $state instanceof PaidState || 
               $state instanceof CancelledState;
    }
}

class PaidState extends InvoiceState
{
    public function label(): string
    {
        return 'Pagata';
    }
    
    public function color(): string
    {
        return 'green';
    }
}
```

### 3. Integrazione nel Modello

```php
<?php

namespace Domain\Invoices\Models;

use Domain\Invoices\States\InvoiceState;
use Domain\Invoices\States\PendingState;

class Invoice extends Model
{
    protected $casts = [
        'state' => InvoiceState::class
    ];
    
    public function state(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => new ($value)($this),
            set: fn (InvoiceState $state) => get_class($state)
        );
    }
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function (Invoice $invoice) {
            $invoice->state = new PendingState($invoice);
        });
    }
}
```

## Transizioni di Stato

### 1. Classe Base per Transizioni

```php
<?php

namespace Domain\Invoices\Transitions;

abstract class InvoiceStateTransition
{
    protected Invoice $invoice;
    
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }
    
    abstract public function handle(): Invoice;
    
    protected function transitionTo(InvoiceState $state): Invoice
    {
        if (! $this->invoice->state->canTransitionTo($state)) {
            throw new InvalidStateTransition($this->invoice->state, $state);
        }
        
        $this->invoice->state = $state;
        $this->invoice->save();
        
        return $this->invoice;
    }
}
```

### 2. Transizione Specifica

```php
<?php

namespace Domain\Invoices\Transitions;

class PendingToPaidTransition extends InvoiceStateTransition
{
    public function handle(): Invoice
    {
        // Logica pre-transizione
        $this->validatePayment();
        
        // Esegui la transizione
        $invoice = $this->transitionTo(new PaidState($this->invoice));
        
        // Logica post-transizione
        event(new InvoicePaid($invoice));
        
        return $invoice;
    }
    
    private function validatePayment(): void
    {
        // Validazione del pagamento
    }
}
```

## Utilizzo

### 1. Transizione Base

```php
$invoice->state = new PaidState($invoice);
$invoice->save();
```

### 2. Transizione con Classe Dedicata

```php
$transition = new PendingToPaidTransition($invoice);
$transition->handle();
```

### 3. Query Builder Personalizzato

```php
<?php

namespace Domain\Invoices\QueryBuilders;

use Domain\Invoices\States\PaidState;
use Illuminate\Database\Eloquent\Builder;

class InvoiceQueryBuilder extends Builder
{
    public function wherePaid(): self
    {
        return $this->whereState('state', PaidState::class);
    }
}
```

## Best Practices

1. **Separazione delle Responsabilità**
   - Ogni stato dovrebbe essere una classe separata
   - Le transizioni dovrebbero essere classi dedicate
   - Utilizzare eventi per effetti collaterali

2. **Validazione delle Transizioni**
   - Implementare `canTransitionTo()` per ogni stato
   - Validare le condizioni prima della transizione
   - Lanciare eccezioni specifiche per transizioni invalide

3. **Testing**
   - Testare ogni possibile transizione
   - Verificare gli stati invalidi
   - Testare gli eventi correlati

```php
class InvoiceStateTest extends TestCase
{
    /** @test */
    public function it_can_transition_from_pending_to_paid()
    {
        $invoice = Invoice::factory()->create([
            'state' => new PendingState($invoice)
        ]);
        
        $transition = new PendingToPaidTransition($invoice);
        $invoice = $transition->handle();
        
        $this->assertInstanceOf(PaidState::class, $invoice->state);
    }
    
    /** @test */
    public function it_cannot_transition_from_paid_to_pending()
    {
        $this->expectException(InvalidStateTransition::class);
        
        $invoice = Invoice::factory()->create([
            'state' => new PaidState($invoice)
        ]);
        
        $invoice->state = new PendingState($invoice);
    }
}
```

## Vantaggi del Pattern State

1. **Manutenibilità**
   - Codice più organizzato e facile da mantenere
   - Separazione chiara delle responsabilità
   - Facile aggiunta di nuovi stati

2. **Type Safety**
   - Controllo dei tipi a livello di compilazione
   - Autocompletamento IDE
   - Refactoring più sicuro

3. **Business Logic**
   - Rappresentazione chiara del dominio
   - Regole di business esplicite
   - Facile da testare

## Casi d'Uso in il progetto

1. **Gestione Appuntamenti**
   ```php
   // Stati possibili
   - PrenotationPendingState
   - PrenotationConfirmedState
   - PrenotationCompletedState
   - PrenotationCancelledState
   ```

2. **Gestione Pagamenti**
   ```php
   // Stati possibili
   - PaymentPendingState
   - PaymentAuthorizedState
   - PaymentCompletedState
   - PaymentFailedState
   - PaymentRefundedState
   ```

3. **Gestione Documenti**
   ```php
   // Stati possibili
   - DocumentDraftState
   - DocumentPendingApprovalState
   - DocumentApprovedState
   - DocumentRejectedState
   ```

## Riferimenti

- [Laravel Beyond CRUD: States](https://stitcher.io/blog/laravel-beyond-crud-05-states)
- [Spatie State Package](https://github.com/spatie/laravel-model-states)
- [Laravel Documentation](https://laravel.com/docs) 
