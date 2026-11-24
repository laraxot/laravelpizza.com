<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\VenueResource\Pages;

use Modules\Meetup\Filament\Resources\VenueResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateVenue extends XotBaseCreateRecord
{
    protected static string $resource = VenueResource::class;

    /**
     * "Nuova sede", "Nuovo evento": il titolo predefinito di Filament ("Nuovo :label") sbaglia il genere.
     */
    #[\Override]
    public function getTitle(): string
    {
        return (string) __('meetup::venue.create_title');
    }
}
