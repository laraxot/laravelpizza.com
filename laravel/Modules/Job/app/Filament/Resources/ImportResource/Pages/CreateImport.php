<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\ImportResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Job\Filament\Resources\ImportResource;

class CreateImport extends XotBaseCreateRecord
{
    protected static string $resource = ImportResource::class;
}
