<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\SnapshotResource\Pages;

use Modules\Activity\Filament\Resources\SnapshotResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * Colonne, filtri e azioni stanno in `SnapshotsTable`: la List page non li dichiara.
 *
 * @see SnapshotResource
 */
class ListSnapshots extends XotBaseListRecords
{
    protected static string $resource = SnapshotResource::class;
}
