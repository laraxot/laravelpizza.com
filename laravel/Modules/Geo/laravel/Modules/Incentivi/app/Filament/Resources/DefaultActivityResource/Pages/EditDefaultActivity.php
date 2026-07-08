<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\DefaultActivityResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Incentivi\Filament\Resources\DefaultActivityResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditDefaultActivity extends XotBaseEditRecord
{
    protected static string $resource = DefaultActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
