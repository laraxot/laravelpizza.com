# Spatie Laravel Model States in <nome progetto>

## Cos'è
[spatie/laravel-model-states](https://spatie.be/docs/laravel-model-states/v2/01-introduction) è un package che implementa il pattern State e le state machine su modelli Eloquent, permettendo di gestire in modo elegante e type-safe gli stati di un modello e le transizioni tra di essi.

## Caratteristiche principali
- **Tipizzazione forte**: Ogni stato è una classe PHP con type hinting
- **Transizioni configurabili e sicure**: Solo le transizioni definite sono permesse
- **Azioni custom sulle transizioni**: Logica personalizzata durante le transizioni
- **Eventi sulle transizioni**: Generazione automatica di eventi
- **Serializzazione automatica su DB**: Gestione trasparente della persistenza
- **Scope per query sugli stati**: Metodi dedicati per filtrare per stato
- **Validazione request**: Integrazione con il sistema di validazione di Laravel
- **Supporto per dependency injection**: Nelle classi di transizione

## Implementazione in <nome progetto>

Nel progetto <nome progetto>, utilizziamo spatie/laravel-model-states principalmente per gestire gli stati di registrazione dei Doctor (odontoiatri). Questo approccio ci permette di:

1. Avere un codice più leggibile e manutenibile
2. Garantire che le transizioni di stato seguano un flusso predefinito
3. Centralizzare la logica di business relativa ai cambi di stato
4. Facilitare l'aggiunta di nuovi stati o transizioni in futuro

### Struttura delle classi di stato

```php
// Modules/Patient/app/States/DoctorRegistrationState.php
namespace Modules\Patient\States;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;
use Modules\Patient\States\Transitions\ApproveDoctorTransition;
use Modules\Patient\States\Transitions\RejectDoctorTransition;
use Modules\Patient\States\Transitions\ActivateDoctorTransition;

abstract class DoctorRegistrationState extends State
{
    // Configurazione degli stati e delle transizioni permesse
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class) // Stato predefinito per nuovi Doctor
            ->allowTransition(Pending::class, Approved::class, ApproveDoctorTransition::class)
            ->allowTransition(Pending::class, Rejected::class, RejectDoctorTransition::class)
            ->allowTransition(Approved::class, Active::class, ActivateDoctorTransition::class)
            ->allowTransition(Rejected::class, Pending::class) // Possibilità di ripresentare dopo rifiuto
            ->stateChangedEvent(DoctorStateChanged::class); // Evento personalizzato
    }
    
    // Metodi comuni a tutti gli stati
    abstract public function getLabel(): string;
    abstract public function getBadgeColor(): string;
    
    // Helper per verificare lo stato attuale
    public function isPending(): bool
    {
        return $this instanceof Pending;
    }
    
    public function isApproved(): bool
    {
        return $this instanceof Approved;
    }
    
    public function isRejected(): bool
    {
        return $this instanceof Rejected;
    }
    
    public function isActive(): bool
    {
        return $this instanceof Active;
    }
}
```

### Implementazione degli stati concreti

Ogni stato è implementato come una classe concreta che estende la classe astratta di base:

```php
// Modules/Patient/app/States/Pending.php
namespace Modules\Patient\States;

class Pending extends DoctorRegistrationState
{
    public function getLabel(): string
    {
        return __('patient::doctor.states.pending');
    }
    
    public function getBadgeColor(): string
    {
        return 'warning';
    }
    
    // Metodi specifici per lo stato Pending
    public function canBeApproved(): bool
    {
        return true;
    }
    
    public function canBeRejected(): bool
    {
        return true;
    }
}

// Modules/Patient/app/States/Approved.php
namespace Modules\Patient\States;

class Approved extends DoctorRegistrationState
{
    public function getLabel(): string
    {
        return __('patient::doctor.states.approved');
    }
    
    public function getBadgeColor(): string
    {
        return 'success';
    }
    
    public function canBeActivated(): bool
    {
        return true;
    }
}
```

### Classi di transizione

Le transizioni tra stati sono gestite da classi dedicate che implementano la logica specifica:

```php
// Modules/Patient/app/States/Transitions/ApproveDoctorTransition.php
namespace Modules\Patient\States\Transitions;

use Modules\Patient\Models\Doctor;
use Modules\Patient\States\Approved;
use Modules\Notification\Actions\RecordNotificationAction;
use Spatie\ModelStates\Transition;
use Spatie\QueueableAction\QueueableAction;

class ApproveDoctorTransition extends Transition
{
    use QueueableAction; // Per eseguire la transizione in background se necessario
    
    private int $moderatorId;
    private ?string $notes;

    public function __construct(int $moderatorId, ?string $notes = null)
    {
        $this->moderatorId = $moderatorId;
        $this->notes = $notes;
    }

    public function handle(Doctor $doctor, Approved $state): Doctor
    {
        // Logica di approvazione
        $doctor->moderation_notes = $this->notes;
        $doctor->moderated_by = $this->moderatorId;
        $doctor->moderated_at = now();
        
        // Notifiche
        app(RecordNotificationAction::class)->execute(
            $doctor->user_id,
            Doctor::class,
            $doctor->id,
            'approved',
            ['email', 'database'],
            [
                'notes' => $this->notes,
            ]
        );
        
        return $doctor;
    }
}
```

### Configurazione del modello

Per utilizzare gli stati, il modello deve implementare l'interfaccia `HasStatesContract` e utilizzare il trait `HasStates`:

```php
// Modules/Patient/app/Models/Doctor.php
namespace Modules\Patient\Models;

use Spatie\ModelStates\HasStates;
use Spatie\ModelStates\HasStatesContract;
use Modules\Patient\States\DoctorRegistrationState;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\BelongsToTenant;

class Doctor extends User implements HasStatesContract
{
    use HasStates;
    use SoftDeletes, BelongsToTenant;
    
    // Importante: Doctor estende User del modulo Patient, NON BaseModel
    // Questo è il corretto utilizzo di Single Table Inheritance con tighten/parental

    protected $fillable = [
        // campi fillable
    ];

    /**
     * Definisce i cast degli attributi del modello.
     * 
     * In Laravel 12.x, il metodo casts() sostituisce la proprietà $casts deprecata.
     * @return array<string, string|class-string>
     */
    protected function casts(): array
    {
        return [
            'certifications' => 'array',
            'availability' => 'array',
            'state' => DoctorRegistrationState::class, // Casting per spatie/laravel-model-states
            'moderated_at' => 'datetime',
            'activated_at' => 'datetime'
        ];
    }
}
```

### Utilizzo nelle Actions

Le transizioni di stato vengono utilizzate nelle Actions per implementare la logica di business:

```php
// Modules/Patient/app/Actions/ProcessDoctorModerationAction.php
namespace Modules\Patient\Actions;

use Modules\Patient\Models\Doctor;
use Modules\Patient\States\Approved;
use Modules\Patient\States\Rejected;
use Modules\Patient\States\Transitions\ApproveDoctorTransition;
use Modules\Patient\States\Transitions\RejectDoctorTransition;
use Illuminate\Support\Facades\DB;
use Spatie\QueueableAction\QueueableAction;

class ProcessDoctorModerationAction
{
    use QueueableAction; // Per eseguire l'azione in background se necessario
    
    public function execute(Doctor $doctor, bool $approved, ?string $notes, int $moderatorId): bool
    {
        return DB::transaction(function () use ($doctor, $approved, $notes, $moderatorId) {
            if ($approved) {
                // Utilizzo della transizione con spatie/laravel-model-states
                $doctor->state->transitionTo(
                    Approved::class, 
                    new ApproveDoctorTransition($moderatorId, $notes)
                );
            } else {
                // Transizione a stato Rejected
                $doctor->state->transitionTo(
                    Rejected::class,
                    new RejectDoctorTransition($moderatorId, $notes)
                );
            }
            
            $doctor->save();
            return true;
        });
    }
}
```

### Query sugli stati

Il package offre metodi dedicati per filtrare i modelli in base al loro stato:

```php
// Recuperare tutti i Doctor in stato Pending
$pendingDoctors = Doctor::whereState('state', Pending::class)->get();

// Recuperare tutti i Doctor in stato Approved
$approvedDoctors = Doctor::whereState('state', Approved::class)->get();

// Recuperare tutti i Doctor in stato Rejected
$rejectedDoctors = Doctor::whereState('state', Rejected::class)->get();
```

## Vantaggi dell'utilizzo in <nome progetto>

1. **Codice più leggibile**: La struttura basata su classi rende il codice auto-documentante.
2. **Validazione robusta**: Le transizioni non permesse generano eccezioni, garantendo l'integrità dei dati.
3. **Estensibilità**: Aggiungere nuovi stati o transizioni richiede solo la creazione di nuove classi.
4. **Integrazione con il sistema di notifiche**: Le transizioni possono attivare automaticamente notifiche.
5. **Supporto per azioni in background**: L'uso di `QueueableAction` permette di eseguire transizioni complesse in background.

## Nota importante su Laravel 12.x e il sistema di cast

A partire da Laravel 12.x, la proprietà `$casts` è stata deprecata in favore del nuovo sistema di cast basato su attributi. È fondamentale utilizzare il metodo `casts()` invece della proprietà statica `$casts` in tutti i modelli Eloquent:

```php
// DEPRECATO in Laravel 12.x - NON USARE
protected $casts = [
    'state' => DoctorRegistrationState::class,
    'created_at' => 'datetime',
];

// APPROCCIO CORRETTO per Laravel 12.x
protected function casts(): array
{
    return [
        'state' => DoctorRegistrationState::class,
        'created_at' => 'datetime',
    ];
}
```

Questo cambiamento si applica a tutti i modelli che utilizzano spatie/laravel-model-states e in generale a tutti i modelli Eloquent nel progetto <nome progetto>.

Per maggiori informazioni, consultare la [documentazione ufficiale di Laravel 12.x sui mutator e i cast](https://laravel.com/docs/12.x/eloquent-mutators).

## Best Practices

1. **Definire metodi helper negli stati**: Aggiungere metodi come `getLabel()` o `getBadgeColor()` per semplificare l'uso degli stati nelle viste.
2. **Utilizzare eventi per azioni collaterali**: Utilizzare gli eventi generati dalle transizioni per attivare azioni collaterali come notifiche o logging.
3. **Centralizzare la logica di transizione**: Mantenere tutta la logica relativa a una transizione nella classe di transizione corrispondente.
4. **Utilizzare transaction DB**: Eseguire le transizioni all'interno di transaction DB per garantire l'atomicità delle operazioni.
5. **Documentare gli stati e le transizioni**: Mantenere una documentazione aggiornata degli stati e delle transizioni permesse.
6. **Utilizzare il metodo casts()**: Sempre utilizzare il metodo `casts()` invece della proprietà `$casts` deprecata in Laravel 12.x.

## Risorse

- [Documentazione ufficiale](https://spatie.be/docs/laravel-model-states/v2/01-introduction)
- [Repository GitHub](https://github.com/spatie/laravel-model-states)
- [Esempio di implementazione in <nome progetto>](../../laravel/Modules/Patient/app/States/DoctorRegistrationState.php)
```

## Quando usarlo
- Quando il modello ha uno stato ben definito e le transizioni sono semplici o medie
- Quando serve logica custom per ogni stato
- Quando serve validazione e query sugli stati

## Quando NON basta
- Quando il processo è un workflow articolato, multi-step, con ruoli, condizioni, azioni, audit, scadenze, ecc.
- In questi casi serve un workflow engine o una tabella dedicata al processo.

## Link utili
- [Introduzione](https://spatie.be/docs/laravel-model-states/v2/01-introduction)
- [Configurare stati](https://spatie.be/docs/laravel-model-states/v2/working-with-states/configuring-states)
- [Gestire transizioni](https://spatie.be/docs/laravel-model-states/v2/working-with-transitions/configuring-transitions)
- [Eventi sulle transizioni](https://spatie.be/docs/laravel-model-states/v2/working-with-transitions/transition-events)
- [Validazione request](https://spatie.be/docs/laravel-model-states/v2/request-validation/state-validation-rule)
- [Query sugli stati](https://spatie.be/docs/laravel-model-states/v2/querybuilder-support/state-scopes)

## Filosofia e Best Practice
- Lo stato è una fotografia, il workflow è un viaggio
- Usa lo strumento giusto per il problema giusto
- Documenta sempre la mappatura stato <-> classe
- Trasparenza nelle transizioni, audit trail, chiarezza per l'utente e per il team

## Best Practice di Ereditarietà nei Moduli
- Nei moduli, i modelli child (es. Doctor) **devono estendere il modello User del modulo**, che a sua volta estende BaseUser del modulo User.
- **Mai estendere direttamente Model o BaseModel nei modelli child.**
- Questo garantisce coerenza, riuso, centralizzazione delle policy e delle relazioni, e semplifica la gestione dei permessi e delle query.

Esempio:
```php
// Modules/User/app/Models/BaseUser.php
class BaseUser extends Authenticatable { /* ... */ }

// Modules/Patient/app/Models/User.php
namespace Modules\Patient\Models;
use Modules\User\Models\BaseUser;
class User extends BaseUser { /* ... */ }

// Modules/Patient/app/Models/Doctor.php
namespace Modules\Patient\Models;
class Doctor extends User { /* ... */ }
```
