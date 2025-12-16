<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Pages;

use Filament\Resources\Pages\ManageRelatedRecords as FilamentManageRelatedRecords;
use Modules\Xot\Filament\Traits\HasXotTable;

/**
 * ---
 */
abstract class XotBaseManageRelatedRecords extends FilamentManageRelatedRecords
{
    use HasXotTable;
}
