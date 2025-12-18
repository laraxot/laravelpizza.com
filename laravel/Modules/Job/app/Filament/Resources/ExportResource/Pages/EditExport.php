<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\ExportResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\Job\Filament\Resources\ExportResource;

class EditExport extends XotBaseEditRecord
{
    protected static string $resource = ExportResource::class;
}
