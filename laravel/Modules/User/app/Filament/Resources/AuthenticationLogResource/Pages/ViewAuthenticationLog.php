<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\AuthenticationLogResource\Pages;

use Filament\Schemas\Components\Component;
use Modules\User\Filament\Resources\AuthenticationLogResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewAuthenticationLog extends XotBaseViewRecord
{
    protected static string $resource = AuthenticationLogResource::class;

    /*
     * @return array<string, Component>
     */
}
