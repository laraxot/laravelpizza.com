<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamInvitationResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Modules\User\Filament\Resources\TeamInvitationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

/**
 * Class EditTeamInvitations.
 */
class EditTeamInvitations extends XotBaseEditRecord
{
    protected static string $resource = TeamInvitationResource::class;

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
