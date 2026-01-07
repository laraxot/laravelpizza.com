<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamInvitationResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Modules\User\Filament\Resources\TeamInvitationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * Class ListTeamInvitations.
 */
class ListTeamInvitations extends XotBaseListRecords
{
    protected static string $resource = TeamInvitationResource::class;

    /**
     * @return array<string, Action>
     */
    #[\Override]
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }
}
