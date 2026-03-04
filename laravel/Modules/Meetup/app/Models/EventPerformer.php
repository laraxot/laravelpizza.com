<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Modules\Xot\Models\XotBasePivot;

/**
 * @property-read \Modules\Meetup\Models\Profile|null $creator
 * @property-read \Modules\Meetup\Models\Profile|null $deleter
 * @property-read \Modules\Meetup\Models\Profile|null $updater
 *
 * @method static \Modules\Meetup\Database\Factories\EventPerformerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer query()
 *
 * @mixin \Eloquent
 */
class EventPerformer extends XotBasePivot
{
    /** @var string */
    protected $table = 'event_performer';

    /** @var list<string> */
    protected $fillable = ['event_id', 'user_id'];
}
