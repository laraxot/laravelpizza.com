<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Filament\Forms\Components\Field;

/**
 * Address input field with geolocation button.
 *
 * **Filament Component** (not Blade render) — extends Field so it integrates
 * natively with Filament's form/schema system, Livewire state, and validation.
 *
 * **Why in Geo**: Geolocation and reverse geocoding are geo-spatial concerns.
 * Any module (Fixcity, Municipal, UI, User, etc.) can consume this component.
 *
 * **Usage**:
 * ```php
 * use Modules\Geo\Filament\Forms\Components\AddressInput;
 *
 * AddressInput::make('address')
 *     ->label('Indirizzo')
 *     ->required()
 * ```
 *
 * @see Modules/Geo/resources/views/filament/forms/components/address-input.blade.php
 */
class AddressInput extends Field
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
