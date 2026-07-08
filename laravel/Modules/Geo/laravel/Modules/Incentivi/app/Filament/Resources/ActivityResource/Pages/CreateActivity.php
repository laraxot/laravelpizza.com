<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ActivityResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Incentivi\Filament\Resources\ActivityResource;

class CreateActivity extends CreateRecord
{
    protected static string $resource = ActivityResource::class;
}
