<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\SocialiteUserResource\Pages;

use Filament\Actions\Action;
use Modules\User\Filament\Resources\SocialiteUserResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * Class ListSocialiteUsers.
 */
class ListSocialiteUsers extends XotBaseListRecords
{
    protected static string $resource = SocialiteUserResource::class;

    /**
     * @return array<string, Action>
     */
    #[\Override]
    protected function getHeaderActions(): array
    {
        return [
            // Socialite users are typically created through authentication, so no create action
            // CreateAction::make(),
        ];
    }
}
