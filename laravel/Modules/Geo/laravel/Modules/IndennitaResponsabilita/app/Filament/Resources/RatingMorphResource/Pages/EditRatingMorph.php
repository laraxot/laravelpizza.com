<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\RatingMorphResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\IndennitaResponsabilita\Filament\Resources\RatingMorphResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditRatingMorph extends XotBaseEditRecord
{
    protected static string $resource = RatingMorphResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
