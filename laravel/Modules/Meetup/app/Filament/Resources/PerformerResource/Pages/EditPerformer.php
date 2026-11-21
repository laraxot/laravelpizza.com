<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\PerformerResource\Pages;

use Modules\Meetup\Filament\Resources\PerformerResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditPerformer extends XotBaseEditRecord
{
    protected static string $resource = PerformerResource::class;

    /**
     * "Modifica evento" e non "Modifica Evento": il titolo predefinito di Filament usa l'etichetta del modello con
     * l'iniziale maiuscola.
     */
    #[\Override]
    public function getTitle(): string
    {
        return (string) __('meetup::performer.edit_title');
    }
}
