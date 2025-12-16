<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamResource\Pages;

use Modules\User\Filament\Resources\TeamResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateTeam extends XotBaseCreateRecord
{
    // //
    protected static string $resource = TeamResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['team_id'] = auth()->id();

        return $data;
    }
}
