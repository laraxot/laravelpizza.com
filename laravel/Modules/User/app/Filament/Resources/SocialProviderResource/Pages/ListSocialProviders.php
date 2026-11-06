<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\SocialProviderResource\Pages;

use Modules\User\Filament\Resources\SocialProviderResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListSocialProviders extends XotBaseListRecords
{
    protected static string $resource = SocialProviderResource::class;
}
