<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\ImportResource\Pages;

use Modules\Job\Filament\Resources\ImportResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListImports extends XotBaseListRecords
{
    protected static string $resource = ImportResource::class;
}
