# Anti-Pattern: Redundant Property Override in Extended Models

## Il Problema

```php
// ❌ ERRATO - MAI FARE QUESTO
namespace Modules\Activity\Models;

use Spatie\Activitylog\Models\Activity as SpatieActivity;

class Activity extends SpatieActivity
{
    // VIOLAZIONE: Il parent già definisce questa proprietà!
    protected $table = 'activity_log';  // CAGATA!
    
    protected $fillable = [
        // ...
    ];
}
```

## Perché è una Cagata

1. **Violazione DRY** - La proprietà è già definita nel parent `Spatie\Activitylog\Models\Activity`
2. **Debito Tecnico** - Se Spatie cambia il nome tabella, il nostro override rompe l'aggiornamento
3. **Confusione** - Chi legge il codice pensa ci sia una ragione specifica per l'override
4. **Manutenzione** - Doppio punto di verità, aggiornamenti più complessi

## Regola d'Oro

> **MAI** sovrascrivere proprietà già definite nella classe base, **a meno che**:
> - La logica di business lo richieda esplicitamente
> - Si stia cambiando comportamento (non solo ripetendo)
> - Ci sia un commento che spiega il perché

## Esempio Corretto

```php
// ✅ CORRETTO
namespace Modules\Activity\Models;

use Spatie\Activitylog\Models\Activity as SpatieActivity;

class Activity extends SpatieActivity
{
    // NIENTE override di $table - ereditato dal parent
    
    // Aggiungiamo SOLO ciò che serve (campi fillable estesi)
    /** @var list<string> */
    protected $fillable = [
        'id',
        'log_name',
        'description',
        'subject_type',
        'event',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
    ];
}
```

## Quando è OK Sovrascrivere

```php
// ✅ OK - Cambio comportamento con motivazione
class CustomActivity extends SpatieActivity
{
    /**
     * Override necessario per multi-tenancy.
     * Ogni tenant ha il proprio schema activity_log.
     */
    public function getTable(): string
    {
        return Tenant::current()?->getActivityTable() ?? 'activity_log';
    }
}
```

## Collegamenti

- [Ereditarietà e Override](../../docs/inheritance-overrides.md)
- [DRY Principle](../../docs/dry-principle.md)
- [Spatie ActivityLog Docs](https://spatie.be/docs/laravel-activitylog/)

## Checklist Review

- [ ] Verificare che il parent non definisca già la proprietà
- [ ] Se override necessario, documentare il perché
- [ ] Preferire composition over inheritance quando possibile
- [ ] Review di codice: flaggare ridondanze
