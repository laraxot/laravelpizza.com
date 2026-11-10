<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\VenueResource\Pages;

use Modules\Meetup\Filament\Resources\VenueResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateVenue extends XotBaseCreateRecord
{
    protected static string $resource = VenueResource::class;
}
