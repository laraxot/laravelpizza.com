<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources;

use Modules\Meetup\Models\Venue;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * PRD FR-2: anagrafica gestita dagli organizzatori e collegata agli eventi dal form evento.
 * Form in Schemas\VenueForm, tabella in Pages\ListVenues; navigazione ed etichette da lang/{it,en}/venue.php.
 */
class VenueResource extends XotBaseResource
{
    protected static ?string $model = Venue::class;

    protected static ?string $recordTitleAttribute = 'name';
}
