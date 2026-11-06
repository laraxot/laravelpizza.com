<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Filament\Forms\Components\Concerns\CanBeReadOnly;
use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * CoordinatePicker - Senior Architectural Core for geographic selection.
 *
 * Rule: Extends XotBaseField.
 * Rule: No "Default" prefixes.
 * Rule: Unified state.
 */
class CoordinatePicker extends XotBaseField
{
    use CanBeReadOnly;
    use HasCoordinatePicker;

    /**
     * La mappa e' di sola lettura se il campo e' disabled o readOnly: il Blade passa `readonly` al Lit
     * (marker non trascinabile, nessun click che scrive lo stato, niente ricerca/geolocalizzazione).
     */
    public function isMapReadonly(): bool
    {
        return $this->isDisabled() || $this->isReadOnly();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCoordinatePicker();
        $this->dehydrated();
    }
}
