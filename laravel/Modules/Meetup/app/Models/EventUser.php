<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Modules\Xot\Models\XotBasePivot;

/**
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
    protected $fillable = ['event_id', 'user_id'];
}
