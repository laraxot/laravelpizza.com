<?php

declare(strict_types=1);

namespace Modules\Activity\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Models\Snapshot;

trait HasEvents
{
    public function storedEvents(): MorphMany
    {
        return $this->morphMany(StoredEvent::class, 'aggregate');
    }

    public function snapshots(): MorphMany
    {
        return $this->morphMany(Snapshot::class, 'aggregate');
    }
}