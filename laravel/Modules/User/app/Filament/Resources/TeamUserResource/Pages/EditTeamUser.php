<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamUserResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

/**
 * Class EditTeamUser.
 */
class EditTeamUser extends XotBaseEditRecord
{
    protected static string $resource = \Modules\User\Filament\Resources\TeamUserResource::class;
}
