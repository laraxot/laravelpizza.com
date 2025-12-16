<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament\Resources\DomainResource\Pages;

use Modules\Tenant\Filament\Resources\DomainResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateDomain extends XotBaseCreateRecord
{
    protected static string $resource = DomainResource::class;
}
