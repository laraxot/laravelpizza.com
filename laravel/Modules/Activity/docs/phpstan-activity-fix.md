# PHPStan Activity Module Fix

## Problema

PHPStan non riconosce i metodi della classe padre `SpatieActivity` nel modello `Activity`. Questo causa errori come:

- `Call to an undefined static method Modules\Activity\Models\Activity::create()`
- `Call to an undefined method Illuminate\Database\Eloquent\Builder::count()`
- `Call to an undefined method Illuminate\Database\Eloquent\Builder::clone()`

## Soluzione Applicata

### 1. Metodi Statici nel Modello Activity

Ho aggiunto i metodi statici essenziali nel modello `Activity`:

```php
/**
 * Begin querying the model.
 */
public static function query(): \Illuminate\Database\Eloquent\Builder
{
    return parent::query();
}

/**
 * Add a basic where clause to the query.
 */
public static function where($column, $operator = null, $value = null, $boolean = 'and'): \Illuminate\Database\Eloquent\Builder
{
    return static::query()->where($column, $operator, $value, $boolean);
}
```

### 2. Type Hints Corretti in ActivityLogger

Ho corretto i type hints in `ActivityLogger.php` per gestire correttamente i tipi restituiti:

```php
/** @var Collection<int, Activity> $activities */
$activities = Activity::with('subject')
    ->where('causer_id', $user->getKey())
    ->where('causer_type', $user::class)
    ->latest()
    ->limit($limit)
    ->get();
```

### 3. Gestione dei Valori Misti

Nel metodo `cleanOld()` ho aggiunto gestione per i valori misti:

```php
$deletedCount = Activity::where('created_at', '<', now()->subDays($days))
    ->delete();

$deleted = is_int($deletedCount) ? $deletedCount : 0;
```

## Alternative Considerate

### 1. PHPStan Stub File

Si potrebbe creare un file stub per SpatieActivity:

```php
// phpstan-stubs/SpatieActivityStub.php
<?php

namespace Spatie\Activitylog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static static create(array $attributes)
 * @method static Builder|static where($column, $operator = null, $value = null)
 * @method static Builder|static query()
 */
abstract class Activity extends Model
{
    // Metodi stub per PHPStan
}
```

### 2. PHPStan Baseline

Aggiungere gli errori al baseline di PHPStan per ignorare temporaneamente questi problemi:

```neon
# phpstan.neon
parameters:
    ignoreErrors:
        - '#Call to an undefined static method Modules\\Activity\\Models\\Activity::create\(\)#'
        - '#Call to an undefined method Illuminate\\Database\\Eloquent\\Builder.*::count\(\)#'
```

## Raccomandazione Finale

La soluzione implementata è un buon compromesso tra completezza e manutenibilità. Per una soluzione a lungo termine, si raccomanda:

1. Creare stub file completi per tutte le classi esterne
2. Mantenere il baseline aggiornato
3. Considerare l'uso di generics PHPDoc per migliorare il type checking

## Politica Laraxot

Secondo la filosofia Laraxot:
- **Logic**: Type safety è fondamentale per prevenire errori runtime
- **Philosophy**: DRY - evitare duplicazione delle correzioni
- **Politics**: Standardizzare l'approccio PHPStan in tutti i moduli
- **Religion**: Strong typing attraverso PHPDoc e type hints
- **Zen**: Accettare le limitazioni degli strumenti esterni e trovare soluzioni eleganti