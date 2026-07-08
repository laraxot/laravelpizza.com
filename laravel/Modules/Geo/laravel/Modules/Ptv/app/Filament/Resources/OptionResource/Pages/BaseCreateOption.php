<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\OptionResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Ptv\Filament\Resources\OptionResource;

abstract class BaseCreateOption extends CreateRecord
{
    protected static string $resource = OptionResource::class;
}
