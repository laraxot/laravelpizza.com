<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\VenueResource\Pages;

use Modules\Meetup\Filament\Resources\VenueResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditVenue extends XotBaseEditRecord
{
    protected static string $resource = VenueResource::class;

    /**
     * "Modifica evento" e non "Modifica Evento": il titolo predefinito di Filament usa l'etichetta del modello con
     * l'iniziale maiuscola.
     */
    #[\Override]
    public function getTitle(): string
    {
        return (string) __('meetup::venue.edit_title');
    }
}
