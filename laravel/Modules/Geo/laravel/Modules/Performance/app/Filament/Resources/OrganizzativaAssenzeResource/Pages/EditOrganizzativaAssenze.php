<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaAssenzeResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Performance\Filament\Resources\OrganizzativaAssenzeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditOrganizzativaAssenze extends XotBaseEditRecord
{
    protected static string $resource = OrganizzativaAssenzeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
