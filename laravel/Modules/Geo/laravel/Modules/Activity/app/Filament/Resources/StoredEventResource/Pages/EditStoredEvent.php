<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\StoredEventResource\Pages;

use Modules\Activity\Filament\Resources\StoredEventResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditStoredEvent extends XotBaseEditRecord
{
    protected static string $resource = StoredEventResource::class;
}
