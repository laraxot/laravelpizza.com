<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\SettlementResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Incentivi\Filament\Resources\SettlementResource;

class CreateSettlement extends CreateRecord
{
    protected static string $resource = SettlementResource::class;
}
