<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Modules\Xot\Models\XotBasePivot;

/**
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $deleter
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Modules\Meetup\Database\Factories\EventSponsorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor query()
 * @property string $id
 * @property string $event_id
 * @property int $sponsor_id
 * @property string|null $sponsorship_details
 * @property string $name
 * @property string|null $level
 * @property string|null $website
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor whereSponsorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor whereSponsorshipDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor whereWebsite($value)
 * @mixin \Eloquent
 */
class EventSponsor extends XotBasePivot
{
    /** @var string */
    protected $table = 'event_sponsor';

    /** @var list<string> */
    protected $fillable = ['event_id', 'sponsor_id', 'role', 'order'];
}
