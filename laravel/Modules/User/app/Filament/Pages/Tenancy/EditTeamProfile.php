<?php

declare(strict_types=1);

namespace Modules\User\Filament\Pages\Tenancy;

use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Pages\Tenancy\XotBaseEditTenantProfile;

class EditTeamProfile extends XotBaseEditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Team profile';
    }

    /**
     * @return array<int, TextInput>
     */
    public function getFormSchema(): array
    {
        return [
            TextInput::make('name'),
            // ...
        ];
    }
}
