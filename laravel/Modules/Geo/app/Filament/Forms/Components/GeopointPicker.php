<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * GeopointPicker - Specialized for database-centric point extraction.
 *
 * Zen: The absolute source of truth for the database representation.
 * Implementation: Separate Blade and Lit JS.
 */
class GeopointPicker extends XotBaseField
{
    use HasCoordinatePicker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCoordinatePicker();
    }
}
