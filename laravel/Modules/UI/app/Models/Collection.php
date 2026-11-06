<?php

declare(strict_types=1);

namespace Modules\UI\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\BaseModel;

/**
 * Collection model for UI module.
 *
 * FormBuilder module not available - extending from XotBaseModel instead.
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $type
 * @property int|null $theme_id
 * @property bool $is_active
 * @property int|null $order
 *
 * @method static \Modules\UI\Database\Factories\CollectionFactory factory($count = null, $state = [])
 * @method static Builder<static>|Collection newModelQuery()
 * @method static Builder<static>|Collection newQuery()
 * @method static Builder<static>|Collection query()
 *
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read ProfileContract|null $updater
 *
 * @method static Builder<static>|Collection whereCreatedAt($value)
 * @method static Builder<static>|Collection whereCreatedBy($value)
 * @method static Builder<static>|Collection whereDeletedAt($value)
 * @method static Builder<static>|Collection whereDeletedBy($value)
 * @method static Builder<static>|Collection whereDescription($value)
 * @method static Builder<static>|Collection whereId($value)
 * @method static Builder<static>|Collection whereIsActive($value)
 * @method static Builder<static>|Collection whereName($value)
 * @method static Builder<static>|Collection whereOrder($value)
 * @method static Builder<static>|Collection whereThemeId($value)
 * @method static Builder<static>|Collection whereType($value)
 * @method static Builder<static>|Collection whereUpdatedAt($value)
 * @method static Builder<static>|Collection whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class Collection extends BaseModel
{
    protected $table = 'collections';

    /** @var list<string> */
    protected $fillable = [
        'name',
        'description',
        'type',
        'theme_id',
        'is_active',
        'order',
    ];
}
