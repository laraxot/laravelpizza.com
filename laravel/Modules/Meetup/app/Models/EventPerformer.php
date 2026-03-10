<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Modules\Xot\Models\XotBasePivot;

/**
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $deleter
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Modules\Meetup\Database\Factories\EventPerformerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer query()
 * @property string $id
 * @property string $event_id
 * @property int $performer_id
 * @property string|null $role
 * @property int $order
 * @property string $name
 * @property string|null $type
 * @property string|null $bio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer wherePerformerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class EventPerformer extends XotBasePivot
{
    /** @var string */
    protected $table = 'event_performer';

    /** @var list<string> */
    protected $fillable = ['event_id', 'performer_id', 'role', 'order'];
}
