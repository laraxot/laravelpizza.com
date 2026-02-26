<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Modules\Xot\Models\XotBasePivot;

/**
 * @property-read \Modules\Meetup\Models\Profile|null $creator
 * @property-read \Modules\Meetup\Models\Profile|null $deleter
 * @property-read \Modules\Meetup\Models\Profile|null $updater
 * @method static \Modules\Meetup\Database\Factories\EventSponsorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor query()
 * @mixin \Eloquent
 */
class EventSponsor extends XotBasePivot
{
    /** @var string */
    protected $table = 'event_sponsor';

    /** @var list<string> */
    protected $fillable = ['event_id', 'user_id'];
}
