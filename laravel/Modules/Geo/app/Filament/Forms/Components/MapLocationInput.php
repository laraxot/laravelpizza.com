<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * MapLocationInput - Simple click-on-map to set location.
 *
 * Zen: The primary interface for rapid location setting.
 * Implementation: Separate Blade and Lit JS.
 */
class MapLocationInput extends XotBaseField
{
    use HasCoordinatePicker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCoordinatePicker();
    }
}
