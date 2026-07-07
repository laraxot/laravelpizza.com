<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * LocationPicker - Specialized for finding locations via address search.
 *
 * Zen: The bridge between human address and machine coordinate.
 * Implementation: Separate Blade and Lit JS.
 */
class LocationPicker extends XotBaseField
{
    use HasCoordinatePicker;

<<<<<<< HEAD
=======
    protected string $view = 'geo::filament.forms.components.location-picker';

>>>>>>> 40b96bcd6 (.)
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCoordinatePicker();
    }
}
