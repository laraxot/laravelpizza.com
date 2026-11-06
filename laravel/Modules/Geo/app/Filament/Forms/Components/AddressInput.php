<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Modules\Xot\Filament\Forms\Components\XotBaseField;

/*
 * GateGuard: callers Geo forms address fields; unique AddressInput XotBaseField;
 * reads/writes string address state; user: "migliora qualità codice , fa tutto con bmad + second brain + filament blueprint"
 */

/**
 * Address input with geolocation — extends {@see XotBaseField} (mai Field diretto).
 *
 * Why Geo: geocoding / reverse geocoding. Usage: `AddressInput::make('address')`
 * senza `->label()` hardcoded (traduzioni modulo).
 *
 * @see Modules/Geo/resources/views/filament/forms/components/address-input.blade.php
 */
class AddressInput extends XotBaseField
{
    protected string $view = 'geo::filament.forms.components.address-input';

    /** Path to the SVG sprite for icons */
    protected string $spritePath = '/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg';

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (AddressInput $component, mixed $state): void {
            // Ensure state is a string
            if (! is_string($state)) {
                $component->state('');
            }
        });
    }

    /**
     * Set the SVG sprite path for the geolocation icon.
     */
    public function spritePath(string $path): static
    {
        $this->spritePath = $path;

        return $this;
    }

    public function getSpritePath(): string
    {
        return $this->spritePath;
    }
}
