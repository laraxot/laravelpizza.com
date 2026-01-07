<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamUserResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

/**
 * Class CreateTeamUser.
 */
class CreateTeamUser extends XotBaseCreateRecord
{
    protected static string $resource = \Modules\User\Filament\Resources\TeamUserResource::class;
}
