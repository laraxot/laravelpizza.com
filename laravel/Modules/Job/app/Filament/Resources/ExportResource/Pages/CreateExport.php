<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\ExportResource\Pages;

use Modules\Job\Filament\Resources\ExportResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateExport extends XotBaseCreateRecord
{
    protected static string $resource = ExportResource::class;
}
