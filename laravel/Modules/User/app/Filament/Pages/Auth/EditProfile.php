<?php

declare(strict_types=1);

namespace Modules\User\Filament\Pages\Auth;

use Filament\Schemas\Components\Component;
use Modules\User\Datas\PasswordData;
use Modules\Xot\Filament\Pages\Auth\XotBaseEditProfile;

class EditProfile extends XotBaseEditProfile
{
    public static ?string $title = 'Profilo Utente';

    /**
     * Costruisce il form schema per la pagina di modifica profilo.
     *
     * @return array<int|string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            $this->getNameFormComponent(),
            $this->getEmailFormComponent(),
            ...PasswordData::make()->getPasswordFormComponents('new_password'),
        ];
    }
}
