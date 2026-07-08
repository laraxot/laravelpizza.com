<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\SettlementResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Incentivi\Filament\Resources\SettlementResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditSettlement extends XotBaseEditRecord
{
    protected static string $resource = SettlementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
