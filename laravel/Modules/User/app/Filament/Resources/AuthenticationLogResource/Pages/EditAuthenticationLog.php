<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\AuthenticationLogResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Modules\User\Filament\Resources\AuthenticationLogResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

/**
 * Class EditAuthenticationLog.
 */
class EditAuthenticationLog extends XotBaseEditRecord
{
    protected static string $resource = AuthenticationLogResource::class;

    /**
     * @return array<string, Action>
     */
    #[\Override]
    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
