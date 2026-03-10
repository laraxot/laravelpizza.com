<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder<static>|NotificationType newModelQuery()
 * @method static Builder<static>|NotificationType newQuery()
 * @method static Builder<static>|NotificationType query()
 * @mixin IdeHelperNotificationType
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $template
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static Builder<static>|NotificationType whereCreatedAt($value)
 * @method static Builder<static>|NotificationType whereCreatedBy($value)
 * @method static Builder<static>|NotificationType whereDescription($value)
 * @method static Builder<static>|NotificationType whereId($value)
 * @method static Builder<static>|NotificationType whereName($value)
 * @method static Builder<static>|NotificationType whereTemplate($value)
 * @method static Builder<static>|NotificationType whereUpdatedAt($value)
 * @method static Builder<static>|NotificationType whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class NotificationType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'template',
    ];
}
