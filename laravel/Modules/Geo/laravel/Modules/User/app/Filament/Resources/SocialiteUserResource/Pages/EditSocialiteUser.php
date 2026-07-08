<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\SocialiteUserResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Modules\User\Filament\Resources\SocialiteUserResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

/**
 * Class EditSocialiteUser.
 */
class EditSocialiteUser extends XotBaseEditRecord
{
    protected static string $resource = SocialiteUserResource::class;

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
