<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\ClientResource\Pages;

use Modules\User\Filament\Resources\ClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListClients extends XotBaseListRecords
{
    protected static string $resource = ClientResource::class;
    // This class extends the base list records functionality
    // All common functionality is handled by XotBaseListRecords
}
