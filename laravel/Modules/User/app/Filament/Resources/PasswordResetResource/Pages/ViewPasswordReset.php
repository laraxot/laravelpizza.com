<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\PasswordResetResource\Pages;

use Modules\User\Filament\Resources\PasswordResetResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewPasswordReset extends XotBaseViewRecord
{
    protected static string $resource = PasswordResetResource::class;
}
