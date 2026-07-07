<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\SnapshotResource\Pages;

use Modules\Activity\Filament\Resources\SnapshotResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditSnapshot extends XotBaseEditRecord
{
    protected static string $resource = SnapshotResource::class;
}
