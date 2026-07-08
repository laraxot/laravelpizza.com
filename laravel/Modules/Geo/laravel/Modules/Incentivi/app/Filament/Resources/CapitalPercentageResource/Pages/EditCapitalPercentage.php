<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\CapitalPercentageResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Incentivi\Filament\Resources\CapitalPercentageResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditCapitalPercentage extends XotBaseEditRecord
{
    protected static string $resource = CapitalPercentageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
