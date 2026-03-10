<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Modules\Xot\Models\XotBasePivot;

/**
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $deleter
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Modules\Meetup\Database\Factories\EventUserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser query()
 * @property string $id
 * @property string $event_id
 * @property string $user_id
 * @property string $status
 * @property string|null $registered_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser whereRegisteredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser whereUserId($value)
 * @mixin \Eloquent
 */
class EventUser extends XotBasePivot
{
    /** @var string */
    protected $table = 'event_user';

    /** @var list<string> */
    protected $fillable = ['event_id', 'user_id'];
}
