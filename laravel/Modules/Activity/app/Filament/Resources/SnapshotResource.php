<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources;

use Modules\Activity\Models\Snapshot;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Resource snapshot event-sourcing: form/table/pages via XotBase auto-discovery.
 */
class SnapshotResource extends XotBaseResource
{
    protected static ?string $model = Snapshot::class;
}
