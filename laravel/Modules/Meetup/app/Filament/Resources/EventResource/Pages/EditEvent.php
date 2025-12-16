<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\EventResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Meetup\Filament\Resources\EventResource;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}