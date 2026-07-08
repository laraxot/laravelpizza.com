<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\WorkgroupResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Incentivi\Filament\Resources\WorkgroupResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditWorkgroup extends XotBaseEditRecord
{
    protected static string $resource = WorkgroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
