<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\AssenzaResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Progressioni\Filament\Resources\AssenzaResource;

class CreateAssenza extends CreateRecord
{
    protected static string $resource = AssenzaResource::class;
}
