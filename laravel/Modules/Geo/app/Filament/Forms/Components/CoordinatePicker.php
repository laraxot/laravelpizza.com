<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
<<<<<<< HEAD
 * CoordinatePicker - Geographic selection component.
 *
 * View: geo::filament.forms.components.coordinate-picker
 *
 * Standardized on 'lat' and 'lng' keys.
 * JSON-first: saves state as an array/JSON in the defined field.
=======
 * CoordinatePicker - Senior Architectural Core for geographic selection.
 *
 * Rule: Extends XotBaseField.
 * Rule: No "Default" prefixes.
 * Rule: Unified state.
>>>>>>> 40b96bcd6 (.)
 */
class CoordinatePicker extends XotBaseField
{
    use HasCoordinatePicker;

    protected function setUp(): void
    {
        parent::setUp();
<<<<<<< HEAD

        $this->setUpCoordinatePicker();
=======
        $this->setUpCoordinatePicker();
        $this->dehydrated();
>>>>>>> 40b96bcd6 (.)
    }
}
