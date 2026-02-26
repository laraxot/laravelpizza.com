# Laravel Model States

## Panoramica

Laravel Model States è una libreria che permette di gestire gli stati dei modelli Eloquent in modo type-safe e orientato agli oggetti.

## Vantaggi

- **Type Safety**: Gli stati sono classi PHP con type hinting
- **Transizioni**: Logica di transizione incapsulata
- **Validazione**: Validazione degli stati e delle transizioni
- **Eventi**: Eventi per le transizioni di stato
- **Query Builder**: Query builder per filtrare per stato

## Implementazione Base

### Definizione degli Stati

```php
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class DoctorRegistrationState extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Draft::class)
            ->allowTransition(Draft::class, PendingModeration::class)
            ->allowTransition(PendingModeration::class, [Approved::class, Rejected::class])
            ->allowTransition(Approved::class, Completed::class);
    }
}

class Draft extends DoctorRegistrationState {}
class PendingModeration extends DoctorRegistrationState {}
class Approved extends DoctorRegistrationState {}
class Rejected extends DoctorRegistrationState {}
class Completed extends DoctorRegistrationState {}
```

### Modello

```php
use Spatie\ModelStates\HasStates;

class DoctorRegistrationWorkflow extends Model
{
    use HasStates;

    protected $casts = [
        'status' => DoctorRegistrationState::class
    ];
}
```

## Utilizzo

### Controllo dello Stato

```php
$workflow->status instanceof PendingModeration; // true/false
$workflow->status->equals(PendingModeration::class); // true/false
```

### Transizioni

```php
class ApproveDoctorRegistration extends Transition
{
    private string $moderatorId;
    
    public function __construct(string $moderatorId)
    {
        $this->moderatorId = $moderatorId;
    }
    
    public function handle(DoctorRegistrationWorkflow $workflow): DoctorRegistrationState
    {
        $workflow->moderated_by = $this->moderatorId;
        $workflow->moderated_at = now();
        $workflow->save();
        
        return new Approved($workflow);
    }
}

$workflow->status->transition(new ApproveDoctorRegistration($moderatorId));
```

### Query Builder

```php
DoctorRegistrationWorkflow::whereState('status', PendingModeration::class)->get();
```

## Validazione

```php
class PendingModeration extends DoctorRegistrationState
{
    public function canTransitionTo(DoctorRegistrationState $state): bool
    {
        if ($state instanceof Approved) {
            return $this->model->hasValidDocuments();
        }
        
        return parent::canTransitionTo($state);
    }
}
```

## Eventi

```php
class DoctorRegistrationWorkflow extends Model
{
    protected static function registerStateEvents(): void
    {
        static::stateUpdated(function ($model, $oldState, $newState) {
            if ($newState instanceof Approved) {
                event(new DoctorRegistrationApproved($model));
            }
        });
    }
}
```

## Esempio Completo

```php
// Stati
abstract class DoctorRegistrationState extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Draft::class)
            ->allowTransition(Draft::class, PendingModeration::class)
            ->allowTransition(PendingModeration::class, [Approved::class, Rejected::class])
            ->allowTransition(Approved::class, Completed::class)
            ->registerState([
                Draft::class,
                PendingModeration::class,
                Approved::class,
                Rejected::class,
                Completed::class,
            ]);
    }
}

// Transizioni
class SubmitForModeration extends Transition
{
    public function __construct(
        private array $data
    ) {}

    public function handle(DoctorRegistrationWorkflow $workflow): DoctorRegistrationState
    {
        $workflow->update([
            'data' => $this->data,
            'submitted_at' => now()
        ]);

        return new PendingModeration($workflow);
    }
}

class ApproveDoctorRegistration extends Transition
{
    public function __construct(
        private string $moderatorId,
        private ?string $notes = null
    ) {}

    public function handle(DoctorRegistrationWorkflow $workflow): DoctorRegistrationState
    {
        $workflow->update([
            'moderated_by' => $this->moderatorId,
            'moderation_notes' => $this->notes,
            'moderated_at' => now()
        ]);

        return new Approved($workflow);
    }
}

// Modello
class DoctorRegistrationWorkflow extends Model
{
    use HasStates;

    protected $casts = [
        'status' => DoctorRegistrationState::class,
        'data' => 'array',
        'submitted_at' => 'datetime',
        'moderated_at' => 'datetime'
    ];

    protected static function registerStateEvents(): void
    {
        static::stateUpdated(function ($model, $oldState, $newState) {
            match (get_class($newState)) {
                PendingModeration::class => event(new DoctorRegistrationSubmitted($model)),
                Approved::class => event(new DoctorRegistrationApproved($model)),
                Rejected::class => event(new DoctorRegistrationRejected($model)),
                Completed::class => event(new DoctorRegistrationCompleted($model)),
                default => null
            };
        });
    }
}

// Utilizzo
$workflow = DoctorRegistrationWorkflow::create([
    'doctor_id' => $doctorId
]);

// Sottomissione
$workflow->status->transition(new SubmitForModeration($data));

// Approvazione
$workflow->status->transition(new ApproveDoctorRegistration($moderatorId, $notes));

// Query
$pendingWorkflows = DoctorRegistrationWorkflow::whereState('status', PendingModeration::class)
    ->orderBy('submitted_at')
    ->get();
```

## Best Practices

1. **Stati Immutabili**: Gli stati dovrebbero essere immutabili
   ```php
   class Approved extends DoctorRegistrationState
   {
       private function __construct(Model $model)
       {
           parent::__construct($model);
       }
   }
   ```

2. **Validazione nelle Transizioni**: La logica di validazione va nelle transizioni
   ```php
   class ApproveDoctorRegistration extends Transition
   {
       public function handle(DoctorRegistrationWorkflow $workflow): DoctorRegistrationState
       {
           if (!$workflow->hasValidDocuments()) {
               throw new InvalidTransitionException('Documents not valid');
           }
           
           return new Approved($workflow);
       }
   }
   ```

3. **Eventi per Side Effects**: Usare gli eventi per gestire side effects
   ```php
   protected static function registerStateEvents(): void
   {
       static::stateUpdated(function ($model, $oldState, $newState) {
           if ($newState instanceof Approved) {
               Mail::to($model->doctor->email)
                   ->queue(new DoctorRegistrationApproved($model));
           }
       });
   }
   ```

## Vedi Anche

- [Spatie Laravel Model States](https://spatie.be/docs/laravel-model-states)
- [Laravel Events](https://laravel.com/docs/events)
- [Queueable Actions](queueable-actions.md) 