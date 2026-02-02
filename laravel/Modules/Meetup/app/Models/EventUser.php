<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Modules\Xot\Models\XotBasePivot;

class EventUser extends XotBasePivot
{
    /** @var string */
    protected $table = 'event_user';

    /** @var list<string> */
    protected $fillable = ['event_id', 'user_id'];
}
