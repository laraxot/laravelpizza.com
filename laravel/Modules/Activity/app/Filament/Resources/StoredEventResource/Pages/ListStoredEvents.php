<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\StoredEventResource\Pages;

use Modules\Activity\Filament\Resources\StoredEventResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * Colonne e azioni stanno in `StoredEventsTable`: la List page non le dichiara.
 *
 * @see StoredEventResource
 */
class ListStoredEvents extends XotBaseListRecords
{
    protected static string $resource = StoredEventResource::class;
}
