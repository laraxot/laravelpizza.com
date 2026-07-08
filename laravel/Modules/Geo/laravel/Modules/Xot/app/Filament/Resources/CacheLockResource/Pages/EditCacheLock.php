<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\CacheLockResource\Pages;

use Modules\Xot\Filament\Resources\CacheLockResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditCacheLock extends XotBaseEditRecord
{
    protected static string $resource = CacheLockResource::class;
}
