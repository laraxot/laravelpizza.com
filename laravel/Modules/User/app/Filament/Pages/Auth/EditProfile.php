<?php

declare(strict_types=1);

namespace Modules\User\Filament\Pages\Auth;

use Modules\User\Datas\PasswordData;
use Modules\Xot\Filament\Pages\Auth\XotBaseEditProfile;

class EditProfile extends XotBaseEditProfile
{
    public static ?string $title = 'Profilo Utente';

    public function getFormSchema(): array
    {
        return array_merge(
            [$this->getNameFormComponent(), $this->getEmailFormComponent()],
            PasswordData::make()->getPasswordFormComponents('new_password')
        );
    }
}
