<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\EventResource\Pages;

use Illuminate\Database\Eloquent\Model;
use Modules\Meetup\Actions\Event\CreateEventAction;
use Modules\Meetup\Filament\Resources\EventResource as EventResourceClass;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateEvent extends XotBaseCreateRecord
{
    protected static string $resource = EventResourceClass::class;

    /**
     * La creazione passa da CreateEventAction (autore e organizzatore = utente corrente, transazione):
     * stessa logica per pannello, import e test. Relatori e sponsor li salva poi Filament.
     *
     * @param  array<string, mixed>  $data
     */
    protected function handleRecordCreation(array $data): Model
    {
        return app(CreateEventAction::class)->execute($data);
    }
}
