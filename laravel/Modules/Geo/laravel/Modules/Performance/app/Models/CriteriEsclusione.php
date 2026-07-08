<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;
use Modules\Xot\Traits\Updater;

/**
 * Modules\Performance\Models\CriteriEsclusione.
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $field_name
 * @property string|null $op
 * @property string|null $value
 * @property int|null $anno
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
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
 * @method static Builder|CriteriEsclusione whereUpdatedAt($value)
 * @method static Builder|CriteriEsclusione whereUpdatedBy($value)
 * @method static Builder|CriteriEsclusione whereValue($value)
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class CriteriEsclusione extends BaseModel
{
    protected $fillable = ['id', 'name', 'field_name', 'op', 'value', 'anno'];

    // use Updater;
    // protected $connection = 'performance'; // this will use the specified database connection
    protected $table = 'criteri_esclusione';

    // public $timestamps = true;
    /*
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    */
    // end search
    // -------------------------
} // end class
