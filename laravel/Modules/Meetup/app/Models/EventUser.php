<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Modules\Xot\Models\XotBasePivot;

/**
 * @property string $id
 * @property string $event_id
 * @property string $user_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \Modules\Meetup\Models\Profile|null $creator
 * @property-read \Modules\Meetup\Models\Profile|null $deleter
 * @property-read \Modules\Meetup\Models\Profile|null $updater
 *
 * @method static \Modules\Meetup\Database\Factories\EventUserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser query()
 *
 * @mixin \Eloquent
 */
class EventUser extends XotBasePivot
{
    /** @var string */
    protected $table = 'event_user';

    /** @var list<string> */
    protected $fillable = ['event_id', 'user_id', 'status'];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'status' => 'string',
        ];
    }

    public const STATUS_ATTENDING = 'attending';
    public const STATUS_WAITLISTED = 'waitlisted';
    public const STATUS_CANCELLED = 'cancelled';
}
