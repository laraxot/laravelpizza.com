<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Pages;

use Modules\Xot\Filament\Pages\Auth\XotBaseEditProfile;

class EditProfile extends XotBaseEditProfile
{
    protected static bool $registerNavigation = true;

    protected static bool $isDiscovered = false;
}
