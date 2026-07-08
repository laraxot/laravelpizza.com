<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\PasswordResetResource\Pages;

use Modules\User\Filament\Resources\PasswordResetResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListPasswordResets extends XotBaseListRecords
{
    protected static string $resource = PasswordResetResource::class;
}
