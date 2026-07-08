<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\SessionResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Xot\Filament\Resources\SessionResource;

class CreateSession extends XotBaseCreateRecord
{
    protected static string $resource = SessionResource::class;
}
