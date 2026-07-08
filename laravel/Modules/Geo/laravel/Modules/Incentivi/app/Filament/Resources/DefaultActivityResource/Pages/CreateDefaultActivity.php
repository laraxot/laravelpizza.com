<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\DefaultActivityResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Incentivi\Filament\Resources\DefaultActivityResource;

class CreateDefaultActivity extends CreateRecord
{
    protected static string $resource = DefaultActivityResource::class;
}
