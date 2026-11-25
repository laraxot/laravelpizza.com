<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\CacheResource\Pages;

use Modules\Xot\Filament\Resources\CacheResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditCache extends XotBaseEditRecord
{
    protected static string $resource = CacheResource::class;
}
