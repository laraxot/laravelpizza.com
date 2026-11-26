<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\LocationResource\Pages;

use Modules\Geo\Filament\Resources\LocationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * Elenco località: titolo da Lang (`geo::location`), niente stringa hardcoded.
 *
 * @see Modules/Geo/docs/manuals/manuale-utente.md
 */
class ListLocations extends XotBaseListRecords
{
    protected static string $resource = LocationResource::class;
}
