<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Socialite\Resources\SsoProviderResource\Pages;

use Modules\User\Filament\Clusters\Socialite\Resources\SsoProviderResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateSsoProvider extends XotBaseCreateRecord
{
    protected static string $resource = SsoProviderResource::class;
}
