<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\EventResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Modules\Meetup\Filament\Resources\EventResource;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;
}