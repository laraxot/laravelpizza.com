<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\ClientResource\Pages;

use Modules\User\Filament\Resources\ClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewClient extends XotBaseViewRecord
{
    protected static string $resource = ClientResource::class;
}
