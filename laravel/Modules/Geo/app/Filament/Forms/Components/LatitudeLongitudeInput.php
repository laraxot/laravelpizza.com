<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * LatitudeLongitudeInput - Dual input fields with map assistance.
 *
 * Zen: The raw guts of the data for direct manipulation.
 * Implementation: Separate Blade and Lit JS.
 */
class LatitudeLongitudeInput extends XotBaseField
{
    use HasCoordinatePicker;

    protected string $view = 'geo::filament.forms.components.latitude-longitude-input';

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCoordinatePicker();
        $this->dehydrated(false);
    }
}
