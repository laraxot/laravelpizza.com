<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TenantUserResource\Pages;

use Modules\User\Filament\Resources\TenantUserResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

/**
 * Class CreateTenantUser.
 */
class CreateTenantUser extends XotBaseCreateRecord
{
    protected static string $resource = TenantUserResource::class;
}
