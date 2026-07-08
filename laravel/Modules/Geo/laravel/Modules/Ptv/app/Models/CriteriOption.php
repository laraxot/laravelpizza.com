<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Ptv\Database\Factories\CriteriOptionFactory;
use Modules\Xot\Traits\Updater;

/**
 * Modules\Performance\Models\CriteriOption.
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $value
 * @property int|null $anno
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static Builder|CriteriOption newModelQuery()
 * @method static Builder|CriteriOption newQuery()
 * @method static Builder|CriteriOption query()
 * @method static Builder|CriteriOption whereAnno($value)
 * @method static Builder|CriteriOption whereCreatedAt($value)
 * @method static Builder|CriteriOption whereCreatedBy($value)
 * @method static Builder|CriteriOption whereId($value)
 * @method static Builder|CriteriOption whereName($value)
 * @method static Builder|CriteriOption whereUpdatedAt($value)
 * @method static Builder|CriteriOption whereUpdatedBy($value)
 * @method static Builder|CriteriOption whereValue($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @method static CriteriOptionFactory factory($count = null, $state = [])
 *
 * @property-read Profile|null $deleter
 *
 * @mixin \Eloquent
 */
class CriteriOption extends BaseModel
{
    protected $fillable = ['id', 'name', 'value', 'anno'];

    protected $table = 'criteri_options';

    // use Updater;
    // protected $connection = 'performance'; // this will use the specified database connection
    // public $timestamps    = true;
    // protected $dates      = [
    //    'created_at',
    //    'updated_at',
    // ];

    // end search
    // -------------------------
} // end class
