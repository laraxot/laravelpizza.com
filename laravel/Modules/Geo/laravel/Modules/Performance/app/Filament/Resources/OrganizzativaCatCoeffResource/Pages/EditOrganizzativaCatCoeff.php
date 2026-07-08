<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaCatCoeffResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Performance\Filament\Resources\OrganizzativaCatCoeffResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditOrganizzativaCatCoeff extends XotBaseEditRecord
{
    protected static string $resource = OrganizzativaCatCoeffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
