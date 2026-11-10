<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\VenueResource\Pages;

use Modules\Meetup\Filament\Resources\VenueResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListVenues extends XotBaseListRecords
{
    protected static string $resource = VenueResource::class;
}
