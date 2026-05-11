<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * MapPicker - Specialized for visual selection on a map.
 *
 * Zen: The primary interface for visual discovery.
 * Implementation: Separate Blade and Lit JS.
 */
class MapPicker extends XotBaseField
{
    use HasCoordinatePicker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCoordinatePicker();
        // Note: dehydrated(false) removed - it blocked saving to latitude/longitude columns.
        // The trait HasCoordinatePicker handles state via saveRelationshipsUsing() after save.
    }
}
