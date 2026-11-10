<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources;

use Modules\Meetup\Models\Sponsor;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * PRD FR-2: anagrafica gestita dagli organizzatori e collegata agli eventi dal form evento.
 * Form in Schemas\SponsorForm, tabella in Pages\ListSponsors; navigazione ed etichette da lang/{it,en}/sponsor.php.
 */
class SponsorResource extends XotBaseResource
{
    protected static ?string $model = Sponsor::class;

    protected static ?string $recordTitleAttribute = 'name';
}
