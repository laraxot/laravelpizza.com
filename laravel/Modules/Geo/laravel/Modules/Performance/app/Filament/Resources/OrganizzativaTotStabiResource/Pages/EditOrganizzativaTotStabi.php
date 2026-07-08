<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaTotStabiResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Performance\Filament\Resources\OrganizzativaTotStabiResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditOrganizzativaTotStabi extends XotBaseEditRecord
{
    protected static string $resource = OrganizzativaTotStabiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
