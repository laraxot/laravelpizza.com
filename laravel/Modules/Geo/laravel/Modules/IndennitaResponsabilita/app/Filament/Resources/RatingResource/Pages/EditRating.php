<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\RatingResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\IndennitaResponsabilita\Filament\Resources\RatingResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditRating extends XotBaseEditRecord
{
    protected static string $resource = RatingResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
