<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources\RatingMorphResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Rating\Filament\Resources\RatingMorphResource;
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
