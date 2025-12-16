<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\SessionResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\Xot\Filament\Resources\SessionResource;

class EditSession extends XotBaseEditRecord
{
    protected static string $resource = SessionResource::class;
}
