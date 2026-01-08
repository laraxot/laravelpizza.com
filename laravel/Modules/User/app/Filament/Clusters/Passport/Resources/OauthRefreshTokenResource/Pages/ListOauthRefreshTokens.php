<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthRefreshTokenResource\Pages;

use Filament\Actions\Action;
use Modules\User\Filament\Clusters\Passport\Resources\OauthRefreshTokenResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListOauthRefreshTokens extends XotBaseListRecords
{
    protected static string $resource = OauthRefreshTokenResource::class;

    /**
     * @return array<string, Action>
     */
    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            // No CreateAction for refresh tokens as they are generated automatically
        ];
    }
}
