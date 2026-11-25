<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Resource di test il cui modello (Modules\Xot\Models\Extra) esiste: XotBaseResource::getModel()
 * lo deduce dal nome della classe.
 */
class ExtraResource extends XotBaseResource
{
    protected static string $module = 'Xot';
}
