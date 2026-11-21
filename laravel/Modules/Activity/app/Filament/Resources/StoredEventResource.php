<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources;

use Modules\Activity\Models\StoredEvent;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Resource stored events: form/table/pages via XotBase auto-discovery.
 */
class StoredEventResource extends XotBaseResource
{
    protected static ?string $model = StoredEvent::class;
}
