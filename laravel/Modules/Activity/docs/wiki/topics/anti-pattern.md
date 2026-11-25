---
title: "Topic anti-pattern"
type: digest
status: active
qmd: "digest ceiling 100 anti-pattern"
---

# Topic anti-pattern

Sintesi automatica di 3 documenti (chiave `anti-pattern`).

## Anti-Pattern: Environment-Specific Logic in Models

_Fonte: `anti-pattern-model-env-hack.md`_

# Anti-Pattern: Environment-Specific Logic in Models

## Il Problema

```php
// ❌ ERRATO - MAI FARE QUESTO
class Activity extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        // HACK: Anti-pattern!
        if (app()->environment('testing')) {
            $this->connection = config('database.default');
        }
    }
}
```

## Perché è una Cagata

1. **Violazione Single Responsibility Principle**
   - Il modello gestisce dati, non configurazione ambientale
   - Mescola logica di business con logica di deployment

2. **Mascheramento del Problema Reale**
   - Il problema è la configurazione DB di test, non il modello
   - Invece di fixare `.env.testing` o `TestCase`, si bypassa

## Anti-Pattern: Environment-Specific Logic in Models

_Fonte: `wiki/concepts/anti-pattern-model-env-hack.md`_

# Anti-Pattern: Environment-Specific Logic in Models

## Il Problema

```php
// ❌ ERRATO - MAI FARE QUESTO
class Activity extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        // HACK: Anti-pattern!
        if (app()->environment('testing')) {
            $this->connection = config('database.default');
        }
    }
}
```

## Perché è una Cagata

1. **Violazione Single Responsibility Principle**
   - Il modello gestisce dati, non configurazione ambientale
   - Mescola logica di business con logica di deployment

2. **Mascheramento del Problema Reale**
   - Il problema è la configurazione DB di test, non il modello
   - Invece di fixare `.env.testing` o `TestCase`, si bypassa

## Anti-Pattern: Redundant Property Override in Extended Models

_Fonte: `wiki/concepts/anti-pattern-redundant-property-override.md`_

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
