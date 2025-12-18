<?php

declare(strict_types=1);

namespace Modules\Activity\Traits;

use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Models\Snapshot;

trait HasEvents
{
    public function storedEvents()
    {
        return $this->morphMany(StoredEvent::class, 'aggregate');
    }

    public function snapshots()
    {
        return $this->morphMany(Snapshot::class, 'aggregate');
    }
}