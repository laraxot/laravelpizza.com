<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\FailedImportRowResource\Pages;

use Modules\Job\Filament\Resources\FailedImportRowResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateFailedImportRow extends XotBaseCreateRecord
{
    protected static string $resource = FailedImportRowResource::class;
}
