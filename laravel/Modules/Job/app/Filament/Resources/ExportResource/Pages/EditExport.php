<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\ExportResource\Pages;

use Modules\Job\Filament\Resources\ExportResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditExport extends XotBaseEditRecord
{
    protected static string $resource = ExportResource::class;
}
