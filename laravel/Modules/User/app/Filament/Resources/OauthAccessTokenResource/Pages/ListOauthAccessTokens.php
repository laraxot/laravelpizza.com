<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthAccessTokenResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction; // Added
use Modules\User\Filament\Resources\OauthAccessTokenResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * Class ListOauthAccessTokens.
 */
class ListOauthAccessTokens extends XotBaseListRecords
{
    protected static string $resource = OauthAccessTokenResource::class;

    /**
     * @return array<string, Action>
     */
    #[\Override]
    protected function getHeaderActions(): array
    {
        return [
            // OAuth tokens are typically created through the OAuth flow, so no create action
            // 'create' => CreateAction::make(),
        ];
    }
}
