<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TenantResource\Pages;

use Modules\User\Filament\Resources\TenantResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseManageRecords;

class ManageTenants extends XotBaseManageRecords
{
    protected static string $resource = TenantResource::class;
}
