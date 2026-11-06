<?php

declare(strict_types=1);

namespace Modules\User\Filament\Pages;

use Filament\Forms\Components\Toggle;
use Modules\User\Datas\UserConfigData;
use Modules\Xot\Filament\Pages\BaseSettingPage;

/**
 * Impostazioni di User (`config/{tenant}/user.php`), solo super-admin: team personale alla
 * registrazione e password grant di Passport.
 *
 * @see UserConfigData
 */
class SettingPage extends BaseSettingPage
{
    /**
     * @return array<string, Toggle>
     */
    protected function getFormSchema(): array
    {
        return [
            'create_personal_team' => Toggle::make('create_personal_team'),
            'passport_enable_password_grant' => Toggle::make('passport_enable_password_grant'),
        ];
    }
}
