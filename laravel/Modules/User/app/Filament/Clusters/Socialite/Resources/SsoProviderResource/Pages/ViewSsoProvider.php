<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Socialite\Resources\SsoProviderResource\Pages;

use Modules\User\Filament\Clusters\Socialite\Resources\SsoProviderResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewSsoProvider extends XotBaseViewRecord
{
    protected static string $resource = SsoProviderResource::class;
}
