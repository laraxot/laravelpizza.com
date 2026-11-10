<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources;

use Modules\Meetup\Models\Performer;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * PRD FR-2: anagrafica gestita dagli organizzatori e collegata agli eventi dal form evento.
 * Form in Schemas\PerformerForm, tabella in Pages\ListPerformers; navigazione ed etichette da lang/{it,en}/performer.php.
 */
class PerformerResource extends XotBaseResource
{
    protected static ?string $model = Performer::class;

    protected static ?string $recordTitleAttribute = 'name';
}
