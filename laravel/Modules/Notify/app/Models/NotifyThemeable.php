<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Modules\Notify\Models\NotifyThemeable.
 *
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 *
 * @method static Builder<static>|NotifyThemeable newModelQuery()
 * @method static Builder<static>|NotifyThemeable newQuery()
 * @method static Builder<static>|NotifyThemeable query()
 *
 * @property string $id
 * @property string|null $model_type
 * @property int|null $model_id
 * @property int|null $notify_theme_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static Builder<static>|NotifyThemeable whereCreatedAt($value)
 * @method static Builder<static>|NotifyThemeable whereCreatedBy($value)
 * @method static Builder<static>|NotifyThemeable whereDeletedAt($value)
 * @method static Builder<static>|NotifyThemeable whereDeletedBy($value)
 * @method static Builder<static>|NotifyThemeable whereId($value)
 * @method static Builder<static>|NotifyThemeable whereModelId($value)
 * @method static Builder<static>|NotifyThemeable whereModelType($value)
 * @method static Builder<static>|NotifyThemeable whereNotifyThemeId($value)
 * @method static Builder<static>|NotifyThemeable whereUpdatedAt($value)
 * @method static Builder<static>|NotifyThemeable whereUpdatedBy($value)
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class NotifyThemeable extends BaseMorphPivot
{
    /** @var list<string> */
    protected $fillable = [
        'id',
        'model_type',
        'model_id',
        'notify_theme_id',
        'created_by',
        'updated_by',
    ];
}
