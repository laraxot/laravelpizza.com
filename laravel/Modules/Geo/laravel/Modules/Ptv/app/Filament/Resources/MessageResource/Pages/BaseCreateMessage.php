<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\MessageResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Ptv\Filament\Resources\MessageResource;

abstract class BaseCreateMessage extends CreateRecord
{
    protected static string $resource = MessageResource::class;
}
