<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Modules\Xot\Models\XotBasePivot;

/**
 * @property string $id
 * @property string $event_id
 * @property string $performer_id
 * @property string|null $role
 * @property int|null $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
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
    protected $fillable = ['event_id', 'performer_id', 'role', 'sort_order'];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }
}
