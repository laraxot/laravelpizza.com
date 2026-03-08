<?php

declare(strict_types=1);

namespace Modules\Activity\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;

trait HasEvents
{
    public function storedEvents(): MorphMany
    {
        return // @var mixed morphMany(StoredEvent::class, 'aggregate';
    }

    public function snapshots(): MorphMany
    {
        return // @var mixed morphMany(Snapshot::class, 'aggregate';
    }
}
