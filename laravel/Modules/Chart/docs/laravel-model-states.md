# Spatie Laravel Model States

## Cos'è
- Package per aggiungere il pattern State e State Machine ai modelli Eloquent.
- Ogni stato è una classe PHP, con logica e metodi propri.

## Quando usarlo
- Processi semplici o mediamente complessi, con pochi stati e transizioni chiare.

## Quando NON usarlo
- Workflow articolati, con step, dati intermedi, storicizzazione, ruoli, logica avanzata.

## Esempio
```php
// Doctor.php
use Spatie\ModelStates\HasStates;

class Doctor extends BaseModel
{
    use HasStates;

    protected $casts = [
        'state' => DoctorState::class,
    ];
}

// DoctorState.php
abstract class DoctorState extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, Approved::class)
            ->allowTransition(Pending::class, Rejected::class);
    }
}

class Pending extends DoctorState {}
class Approved extends DoctorState {}
class Rejected extends DoctorState {}
```

## Link utili
- [Documentazione ufficiale](https://spatie.be/docs/laravel-model-states/v2/01-introduction)
- [Configurazione stati](https://spatie.be/docs/laravel-model-states/v2/working-with-states/01-configuring-states)
- [Transizioni](https://spatie.be/docs/laravel-model-states/v2/working-with-transitions/01-configuring-transitions)
- [Query](https://spatie.be/docs/laravel-model-states/v2/querybuilder-support/01-state-scopes)
- [Validazione](https://spatie.be/docs/laravel-model-states/v2/request-validation/01-state-validation-rule)

## Best practice
- Usa spatie/laravel-model-states solo per processi semplici (pubblicazione, validazione, pagamento).
- Per workflow complessi (registrazione moderata, onboarding multi-step, processi con dati intermedi e storicizzazione) usa un modello dedicato (es. DoctorRegistrationWorkflow).
- Documenta sempre la scelta architetturale nel modulo coinvolto. 
