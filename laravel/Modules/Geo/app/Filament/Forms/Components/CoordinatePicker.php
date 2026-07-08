<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * CoordinatePicker - Geographic selection component.
 *
 * View: geo::filament.forms.components.coordinate-picker
 *
 * Standardized on 'lat' and 'lng' keys.
 * JSON-first: saves state as an array/JSON in the defined field.
 */
class CoordinatePicker extends XotBaseField
{
    use HasCoordinatePicker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpCoordinatePicker();
    }
}
