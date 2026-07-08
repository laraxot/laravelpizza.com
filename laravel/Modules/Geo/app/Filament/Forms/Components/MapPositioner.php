<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * MapPositioner - Tool for setting the visual viewport (center/zoom).
 *
 * Zen: The ruler of perspective and focus.
 * Implementation: Separate Blade and Lit JS.
 */
class MapPositioner extends XotBaseField
{
    use HasCoordinatePicker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCoordinatePicker();
    }
}
