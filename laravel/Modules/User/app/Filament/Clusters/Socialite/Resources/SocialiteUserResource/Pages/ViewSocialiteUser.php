<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Socialite\Resources\SocialiteUserResource\Pages;

use Modules\User\Filament\Clusters\Socialite\Resources\SocialiteUserResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewSocialiteUser extends XotBaseViewRecord
{
    protected static string $resource = SocialiteUserResource::class;
}
