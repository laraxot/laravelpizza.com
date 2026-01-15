<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\ClientResource\Pages;

use Modules\User\Filament\Resources\ClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditClient extends XotBaseEditRecord
{
    protected static string $resource = ClientResource::class;
    // This class extends the base edit record functionality
    // All common functionality is handled by XotBaseEditRecord
}
