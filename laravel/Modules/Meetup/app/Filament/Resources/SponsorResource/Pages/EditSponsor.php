<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\SponsorResource\Pages;

use Modules\Meetup\Filament\Resources\SponsorResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditSponsor extends XotBaseEditRecord
{
    protected static string $resource = SponsorResource::class;

    /**
     * "Modifica evento" e non "Modifica Evento": il titolo predefinito di Filament usa l'etichetta del modello con
     * l'iniziale maiuscola.
     */
    #[\Override]
    public function getTitle(): string
    {
        return (string) __('meetup::sponsor.edit_title');
    }
}
