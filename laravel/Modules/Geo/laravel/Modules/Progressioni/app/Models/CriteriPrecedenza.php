<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Database\Factories\CriteriPrecedenzaFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Progressioni\Models\CriteriPrecedenza.
 *
 * @property int $id
 * @property int $parent_id
 * @property string|null $name
 * @property string|null $order_direction
 * @property string|null $label
 * @property string|null $descr
 * @property string|null $post_type
 * @property int|null $posizione
 * @property int|null $anno
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static CriteriPrecedenzaFactory factory($count = null, $state = [])
 * @method static Builder|CriteriPrecedenza newModelQuery()
 * @method static Builder|CriteriPrecedenza newQuery()
 * @method static Builder|CriteriPrecedenza query()
 * @method static Builder|CriteriPrecedenza whereAnno($value)
 * @method static Builder|CriteriPrecedenza whereCreatedAt($value)
 * @method static Builder|CriteriPrecedenza whereCreatedBy($value)
 * @method static Builder|CriteriPrecedenza whereDescr($value)
 * @method static Builder|CriteriPrecedenza whereId($value)
 * @method static Builder|CriteriPrecedenza whereLabel($value)
 * @method static Builder|CriteriPrecedenza whereName($value)
 * @method static Builder|CriteriPrecedenza whereOrderDirection($value)
 * @method static Builder|CriteriPrecedenza whereParentId($value)
 * @method static Builder|CriteriPrecedenza wherePosizione($value)
 * @method static Builder|CriteriPrecedenza wherePostType($value)
 * @method static Builder|CriteriPrecedenza whereUpdatedAt($value)
 * @method static Builder|CriteriPrecedenza whereUpdatedBy($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class CriteriPrecedenza extends BaseModel
{
    protected $fillable = ['id', 'parent_id',
        'name', 'order_direction',
        'label', 'descr', 'post_type', 'posizione', 'anno', ];

    protected $table = 'criteri_precedenza';
}
