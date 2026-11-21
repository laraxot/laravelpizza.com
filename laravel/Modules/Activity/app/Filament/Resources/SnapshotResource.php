<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources;

use Modules\Activity\Models\Snapshot;
use Modules\Xot\Filament\Resources\XotBaseResource;

class SnapshotResource extends XotBaseResource
{
    protected static ?string $model = Snapshot::class;
}
