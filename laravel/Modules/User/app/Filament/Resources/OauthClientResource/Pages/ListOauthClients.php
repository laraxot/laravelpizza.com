<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthClientResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Modules\User\Filament\Resources\OauthClientResource;
/**
 * Class ListOauthClients.
 */
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListOauthClients extends XotBaseListRecords
{
    protected static string $resource = OauthClientResource::class;

    /**
     * Get the header actions.
     *
     * @return array<string, Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }
}
