<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Probe per il contratto di navigazione: icona, gruppo e ordinamento arrivano dal
 * trait NavigationLabelTrait (traduzioni), non da property statiche.
 */
class NavigationProbeResource extends XotBaseResource
{
    protected static string $module = 'Xot';
}
