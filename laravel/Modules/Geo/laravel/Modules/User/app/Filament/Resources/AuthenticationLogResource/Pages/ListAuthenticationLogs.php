<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\AuthenticationLogResource\Pages;

use Filament\Actions\Action;
use Modules\User\Filament\Resources\AuthenticationLogResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * Class ListAuthenticationLogs.
 */
class ListAuthenticationLogs extends XotBaseListRecords
{
    protected static string $resource = AuthenticationLogResource::class;

    /**
     * @return array<string, Action>
     */
    #[\Override]
    protected function getHeaderActions(): array
    {
        return [
            // Authentication logs are typically system-generated, so no create action
            // 'create' => CreateAction::make(),
        ];
    }
}
