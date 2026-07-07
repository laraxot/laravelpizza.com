<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource\Pages;

<<<<<<< HEAD
use Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditOauthAccessTokens extends XotBaseEditRecord
{
    protected static string $resource = OauthAccessTokenResource::class;
=======
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

/**
 * Class EditOauthAccessTokens.
 */
class EditOauthAccessTokens extends XotBaseEditRecord
{
    protected static string $resource = OauthAccessTokenResource::class;

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
>>>>>>> 40b96bcd6 (.)
}
