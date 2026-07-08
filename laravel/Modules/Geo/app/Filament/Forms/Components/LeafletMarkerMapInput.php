<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * LeafletMarkerMapInput - Technical Leaflet implementation for marker-based input.
 *
 * Zen: The technical soul of marker interaction.
 * Implementation: Separate Blade and Lit JS.
 */
class LeafletMarkerMapInput extends XotBaseField
{
    use HasCoordinatePicker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCoordinatePicker();
    }
}
