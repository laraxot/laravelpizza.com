# Risoluzione Conflitto in ModelWithPosContract

## Panoramica

Questo documento descrive la risoluzione del conflitto git nel file `Modules/Xot/app/Contracts/ModelWithPosContract.php`, che definisce un'interfaccia fondamentale per i modelli con attributo di posizione.

## Analisi del Conflitto

Il file presenta diversi conflitti nei blocchi di annotazioni PHPDoc e nella definizione dell'interfaccia:

### 1. Conflitto nelle annotazioni delle proprietà
- Duplicazione delle proprietà `tennant_name`, `user` e `status`
- Differenze nella formattazione degli spazi e nell'allineamento delle tipizzazioni

### 2. Conflitto nei metodi della classe
- Differenze nella definizione del metodo `treeSonsCount()`
- Alcuni blocchi lo includono, altri no

### 3. Conflitto nella dichiarazione dell'interfaccia
- Una versione definisce l'interfaccia vuota: `interface ModelWithPosContract {}`
- Un'altra versione la definisce con parentesi graffe su righe separate:
  ```php
  interface ModelWithPosContract
  {
  }
  ```



## Approccio alla Risoluzione

La risoluzione seguirà questi principi:

1. **Completezza**: Includiamo tutte le proprietà e i metodi definiti in qualsiasi versione per garantire la compatibilità.
2. **Tipizzazione forte**: Manteniamo tutte le tipizzazioni delle proprietà per garantire la type safety.
3. **Stile coerente**: Adottiamo uno stile di formattazione coerente per allineamento e spaziatura, seguendo PSR-12.
4. **Eliminazione delle duplicazioni**: Rimuoviamo proprietà o metodi duplicati.

## Soluzione Implementata

La soluzione che adotteremo include:

1. Mantenere tutte le annotazioni di proprietà, rimuovendo le duplicazioni.
2. Includere il metodo `treeSonsCount()` presente in alcune versioni.
3. Adottare lo stile di dichiarazione dell'interfaccia con parentesi graffe su righe separate per migliore leggibilità.
4. Allineare le tipizzazioni con spazi per mantenere un formato coerente.

### Codice Risolto

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\ModelStatus\Status;

/**
 * Modules\Xot\Contracts\ModelWithPosContract.
 *
 * @property int                      $id
 * @property int|null                 $user_id
 * @property string|null              $post_type
 * @property Carbon|null              $created_at
 * @property Carbon|null              $updated_at
 * @property string|null              $created_by
 * @property string|null              $updated_by
 * @property string|null              $title
 * @property PivotContract|null       $pivot
 * @property string                   $tennant_name
 * @property UserContract|null        $user
 * @property string                   $status
 * @property Collection|array<Status> $statuses
 * @property int|null                 $statuses_count
 * @property int|null                 $pos
 *
 * @method mixed     getKey()
 * @method string    getRouteKey()
 * @method string    getRouteKeyName()
 * @method string    getTable()
 * @method mixed     with($array)
 * @method array     getFillable()
 * @method mixed     fill($array)
 * @method mixed     getConnection()
 * @method mixed     update($params)
 * @method mixed     delete()
 * @method mixed     detach($params)
 * @method mixed     attach($params)
 * @method mixed     save($params)
 * @method array     treeLabel()
 * @method array     treeSons()
 * @method int       treeSonsCount()
 * @method array     toArray()
 * @method BelongsTo user()
 *
 * @phpstan-require-extends Model
 *
 * @mixin \Eloquent
 */
interface ModelWithPosContract
{
}
```

## Impatto della Modifica

Questa risoluzione garantisce:

1. **Compatibilità**: Tutti i modelli che implementano questa interfaccia continueranno a funzionare.
2. **Completezza**: Tutte le proprietà e i metodi sono documentati.
3. **Coerenza**: Lo stile del codice è coerente con le convenzioni del progetto.

## Collegamento con la Documentazione Principale

Per una panoramica di tutti i conflitti risolti, vedere il documento principale sulla [risoluzione dei conflitti nel progetto](../../../../docs/logs/conflict_resolution_progress.md). 