<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Pages;

use Modules\User\Filament\Resources\UserResource;
use Modules\User\Filament\Resources\UserResource\Widgets\UserOverview;

class ListUsers extends BaseListUsers
{
    protected static string $resource = UserResource::class;

    #[\Override]
    protected function getHeaderWidgets(): array
    {
        return [
            UserOverview::class,
        ];
    }
}
