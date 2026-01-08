# Risoluzione Conflitto nel Modello Translation

## Panoramica

Questo documento descrive la risoluzione del conflitto git nel file `app/Models/Translation.php` del modulo Lang, che implementa il modello per la gestione delle traduzioni nell'applicazione.

## Analisi del Conflitto

Il file presenta diversi conflitti che richiedono attenzione:

1. **Importazioni duplicate**:
   - `Illuminate\Support\Facades\DB` è importato due volte
   - Sia `DB` (alias globale) che `Illuminate\Support\Facades\DB` sono importati, creando ambiguità

2. **Proprietà duplicate nella documentazione PHPDoc**:
   - Le proprietà `namespace` e `group` sono duplicate tre volte ciascuna
   - Diverse formattazioni di spazi e allineamenti nelle proprietà

3. **Implementazione del metodo `scopeSelectDistinctGroup`**:
   - Tre implementazioni diverse usando:
     - `DB::getDriverName()` e `DB::raw`
     - `\DB::getDriverName()` e `\DB::raw`
     - Conflitto nelle istruzioni di return

## Soluzione Implementata

La soluzione consiste nell'eliminare le duplicazioni e standardizzare il codice secondo le convenzioni del progetto:

### Codice Corretto

```php
<?php

declare(strict_types=1);

/**
 * @see https://github.com/barryvdh/laravel-translation-manager/blob/master/src/Models/Translation.php
 */

namespace Modules\Lang\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Modules\Lang\Models\Translation.
 *
 * @property int         $id
 * @property string|null $lang
 * @property string|null $key
 * @property string|null $value
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string      $namespace
 * @property string      $group
 * @property string|null $item
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   ofTranslatedGroup(string $group)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   orderByGroupKeys(bool $ordered)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   query()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   selectDistinctGroup()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereNamespace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereValue($value)
 * @method static \Modules\Lang\Database\Factories\TranslationFactory factory($count = null, $state = [])
 *
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 *
 * @mixin \Eloquent
 */
class Translation extends BaseModel
{
    final public const STATUS_SAVED = 0;

    final public const STATUS_CHANGED = 1;

    protected $fillable = [
        'id',
        'lang',
        'value',
        'namespace',
        'group',
        'item',
    ];

    // protected $table = 'ltm_translations';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Undocumented function.
     */
    public function scopeOfTranslatedGroup(EloquentBuilder $query, string $group): QueryBuilder|EloquentBuilder
    {
        return $query->where('group', $group)->whereNotNull('value');
    }

    public function scopeOrderByGroupKeys(EloquentBuilder $query, bool $ordered): EloquentBuilder
    {
        if ($ordered) {
            $query->orderBy('group')->orderBy('key');
        }

        return $query;
    }

    public function scopeSelectDistinctGroup(EloquentBuilder $query): EloquentBuilder|QueryBuilder
    {
        $select = match (DB::getDriverName()) {
            'mysql' => 'DISTINCT `group`',
            default => 'DISTINCT "group"',
        };

        return $query->select(DB::raw($select));
    }

    /*
     * Get the current connection name for the model.
     *
     * @return string|null

    public function getConnectionName()
    {
        if ($connection = config('translation-manager.db_connection')) {
            return $connection;
        }

        return parent::getConnectionName();
    }
    */
}
```

## Dettagli delle Modifiche

1. **Correzione delle importazioni**:
   - Rimozione dell'importazione duplicata di `Illuminate\Support\Facades\DB`
   - Rimozione dell'uso diretto di `DB` come alias globale

2. **Pulizia della documentazione PHPDoc**:
   - Rimozione delle proprietà duplicate
   - Standardizzazione della formattazione delle annotazioni delle proprietà

3. **Correzione del metodo `scopeSelectDistinctGroup`**:
   - Utilizzo coerente di `DB::getDriverName()` (con il namespace importato)
   - Una singola istruzione return

## Impatto della Modifica

La correzione:

1. Migliora la leggibilità e la manutenibilità del codice
2. Elimina potenziali ambiguità e inconsistenze
3. Segue le best practice di Laravel riguardo all'uso delle Facades
4. Mantiene la funzionalità originale del modello

## Note sull'Implementazione

Per garantire la coerenza con il resto del progetto, abbiamo seguito queste linee guida:
- Utilizzo di import espliciti invece di alias globali
- Mantenimento della formattazione e dell'allineamento nel PHPDoc
- Utilizzo coerente del facade DB con il namespace importato

## Collegamento con la Documentazione Principale

Per una panoramica di tutti i conflitti risolti, vedere il documento principale sulla [risoluzione dei conflitti nel progetto](../../../../docs/logs/conflict_resolution_progress.md). 
