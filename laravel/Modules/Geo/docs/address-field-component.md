# Geo Module — AddressInput Component

## Overview

`AddressInput` è un componente Filament Form proprietario del modulo Geo che fornisce un campo indirizzo con pulsante di geolocalizzazione browser.

## Philosophy (Zen Laraxot)

| Principio | Significato |
|-----------|-------------|
| **Separazione responsabilità** | Geolocalizzazione è una preoccupazione geo-spaziale trasversale, non Fixcity-specific |
| **Single source of truth** | Un componente, molti consumatori — evita duplicazione in ogni modulo |
| **Riuso** | Qualsiasi modulo (Fixcity, Transport, Logistics) può usare `AddressInput::make('address')` |
| **Dominio** | Il modulo Geo possiede: geocoding, reverse geocoding, coordinate, mappe, timezone — e UI indirizzo |
| **DRY + KISS** | Niente copy-paste di Blade + JS attraverso i moduli |

## Location

**Component**: `Modules/Geo/Filament/Forms/Components/AddressInput.php`
**View**: `Modules/Geo/resources/views/filament/forms/components/address-input.blade.php`

## Usage

```php
use Modules\Geo\Filament\Forms\Components\AddressInput;

AddressInput::make('address')
    ->spritePath('/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg');
```

### Nel Wizard Fixcity

```php
// Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php
use Modules\Geo\Filament\Forms\Components\AddressInput;

private function makeStepData(): Step
{
    return Step::make('2')
        ->schema([
            AddressInput::make('address')
                ->spritePath('/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg'),
            Select::make('issueType')->...,
            // ...
        ]);
}
```

## Translations

Namespace: `geo::address.*`

| Key | IT | EN |
|-----|----|----|
| `fields.address.label` | Luogo del disservizio | Issue location |
| `fields.address.placeholder` | Inserisci il luogo del disservizio | Enter the issue location |
| `fields.use_my_location.label` | Usa la tua posizione | Use my location |
| `geolocation.not_supported` | Geolocalizzazione non supportata | Geolocation not supported |
| `geolocation.address_not_found` | Indirizzo non trovato | Address not found |
| `geolocation.error` | Errore durante la geolocalizzazione | Error during geolocation |
| `geolocation.permission_denied` | Permesso negato | Permission denied |

## Technical Details

- **Geocoding provider**: Nominatim (OpenStreetMap) — free, no API key
- **Policy**: [Nominatim Usage Policy](https://operations.osmfoundation.org/policies/nominatim/)
- **Browser API**: `navigator.geolocation` (requires user gesture)
- **Livewire binding**: `wire:model.live="data.address"`
- **Alpine.js**: `x-on:click.prevent="useMyLocation()"`
- **Filament v5**: Extends `Field`, uses `x-dynamic-component` wrapper

## See Also

- [Fixcity Ticket Wizard Frontoffice](../../Fixcity/docs/ticket-wizard-frontoffice.md)
- [Nominatim Reverse Geocoding API](https://nominatim.org/release-docs/develop/api/Reverse/)
- [MDN Geolocation API](https://developer.mozilla.org/en-US/docs/Web/API/Geolocation_API)
- [Filament v5 Custom Fields](https://filamentphp.com/docs/5.x/forms/fields/custom)
