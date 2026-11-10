<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\VenueResource\Pages;

use Modules\Meetup\Filament\Resources\VenueResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditVenue extends XotBaseEditRecord
{
    protected static string $resource = VenueResource::class;
}
