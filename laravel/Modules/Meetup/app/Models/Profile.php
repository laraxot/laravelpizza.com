<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Modules\User\Models\User;
use Illuminate\Support\Carbon;
use Modules\User\Models\BaseProfile;
use Modules\Meetup\Enums\EventStatus;
use Modules\Activity\Traits\HasEvents;
use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Traits\HasSnapshots;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Meetup\Enums\EventAttendanceMode;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Profile extends BaseProfile{
    /** @var string */
    protected $connection = 'meetup';
}