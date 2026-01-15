<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\ClientResource\Pages;

use Modules\User\Filament\Resources\ClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateClient extends XotBaseCreateRecord
{
    protected static string $resource = ClientResource::class;
    // This class extends the base create record functionality
    // All common functionality is handled by XotBaseCreateRecord
}
