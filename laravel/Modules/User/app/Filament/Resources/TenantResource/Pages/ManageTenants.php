<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TenantResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Modules\User\Filament\Resources\TenantResource;

class ManageTenants extends ManageRecords
{
    protected static string $resource = TenantResource::class;
}
