<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Progressioni\Database\Factories\CriteriEsclusioneFactory;
use Modules\Progressioni\Models\Scheda;
use Modules\Ptv\Models\Contracts\CriteriEsclusioneContract;
use Webmozart\Assert\Assert;

/**
 * class Modules\Ptv\Models\CriteriEsclusione.
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $field_name
 * @property string|null $op
 * @property string|null $value
 * @property string|null $type
 * @property int|null $anno
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static CriteriEsclusioneFactory factory($count = null, $state = [])
 * @method static Builder|CriteriEsclusione newModelQuery()
 * @method static Builder|CriteriEsclusione newQuery()
 * @method static Builder|CriteriEsclusione query()
 * @method static Builder|CriteriEsclusione whereAnno($value)
 * @method static Builder|CriteriEsclusione whereCreatedAt($value)
 * @method static Builder|CriteriEsclusione whereCreatedBy($value)
 * @method static Builder|CriteriEsclusione whereFieldName($value)
 * @method static Builder|CriteriEsclusione whereId($value)
 * @method static Builder|CriteriEsclusione whereName($value)
 * @method static Builder|CriteriEsclusione whereOp($value)
 * @method static Builder|CriteriEsclusione whereType($value)
 * @method static Builder|CriteriEsclusione whereUpdatedAt($value)
 * @method static Builder|CriteriEsclusione whereUpdatedBy($value)
 * @method static Builder|CriteriEsclusione whereValue($value)
 *
 * @property Profile|null $creator
 * @property EloquentCollection<int, CriteriOption> $criteriOptions
 * @property int|null $criteri_options_count
 * @property Profile|null $updater
 * @property-read Profile|null $deleter
 * @property-read EloquentCollection<int, Scheda> $schede
 * @property-read int|null $schede_count
 *
 * @mixin \Eloquent
 */
class CriteriEsclusione extends BaseCriteriEsclusione
{
    
} // end class
