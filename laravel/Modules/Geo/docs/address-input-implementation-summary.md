# AddressInput Component Implementation Summary

**Date**: 2026-04-13
**Status**: ✅ Complete
**Trigger**: Error "Undefined variable $_instance" in CreateTicketWizardWidget

## Problem

The `CreateTicketWizardWidget` was using `\Blade::render()` to inject a Blade view into the Filament schema:

```php
// ANTI-PATTERN - Causes "Undefined variable $_instance" error
Placeholder::make('address_section')
    ->label('')
    ->content(new HtmlString(
        \Blade::render('geo::filament.components.address-field', [...])
    ));
```

### Why It Failed

1. `\Blade::render()` creates an **isolated Blade context**
2. The rendered view has NO access to:
   - `$this` (component instance)
   - `$form` (Filament form context)
   - `$livewire` (Livewire component)
   - Proper `wire:model` bindings
3. Laravel's compiled template referenced `$_instance` which doesn't exist in the isolated context

## Solution

Created a **proper Filament Form Component** `AddressInput` that extends `Field`:

### Files Created

| File | Purpose |
|------|---------|
| `Modules/Geo/app/Filament/Forms/Components/AddressInput.php` | Filament Field component class |
| `Modules/Geo/resources/views/filament/forms/components/address-input.blade.php` | Blade view with geolocation |

### Files Updated

| File | Change |
|------|--------|
| `Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` | Added `->label()` and `->required()` to AddressInput usage |
| `Modules/Geo/docs/address-field-component.md` | Updated to document both AddressInput and AddressField |
| `Modules/Geo/docs/address-input-component.md` | Created detailed component documentation |
| `Modules/Geo/docs/components/INDEX.md` | Updated component index with new architecture |
| `Modules/Geo/docs/README.md` | Updated README with component usage |

### Usage (Correct Pattern)

```php
use Modules\Geo\Filament\Forms\Components\AddressInput;

AddressInput::make('address')
    ->label((string) __('fixcity::segnalazione.fields.address.label'))
    ->required()
    ->spritePath('/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg');
```

## Quality Checks

| Check | Status |
|-------|--------|
| Pint Code Formatter | ✅ Pass |
| PHPStan Level 10 | ✅ Pass |
| Blade View Compilation | ✅ Pass |
| No Anti-Patterns Found | ✅ Verified (no `Blade::render('geo::')` in codebase) |

## Philosophy & Architecture

### The Rule

> **NEVER use `\Blade::render()` to inject UI into a Filament schema.**
> Always create a proper `Filament\Forms\Components\Field` subclass with its own view.

### Why Filament Components?

1. **Filament Way**: Filament provides a component system (`Field`, `Section`, `Component`). We MUST use it.
2. **State Management**: Components have native `wire:model` bindings, hydration, dehydration.
3. **Validation**: Components integrate with Filament's validation system.
4. **Reusability**: `AddressInput::make('address')` works in ANY form/schema.
5. **No Escaping**: `\Blade::render()` = escaping the framework. Like raw SQL when you have an ORM.

### Module Boundary

```
Fixcity (specific) → Geo (generic) ✅
Geo → Fixcity ❌ (would create circular dependency)
```

The `AddressInput` component lives in **Geo** because:
- Geolocation is a geo-spatial concern
- Reverse geocoding (lat/lng → address) is Geo territory
- Any module needs it: Fixcity, Municipal, UI, User, etc.

## Documentation Updates

All documentation has been updated to reflect:
1. The anti-pattern and why it fails
2. The correct Filament component usage
3. The module boundary philosophy
4. The architecture decision rationale

## References

- [AddressInput Component Docs](../../../Modules/Geo/docs/address-input-component.md)
- [Address Components Overview](../../../Modules/Geo/docs/address-field-component.md)
- [Module Boundary Philosophy](../../../Modules/Fixcity/docs/MODULE-BOUNDARY-PHILOSOPHY.md)
- [Geo Components Index](../../../Modules/Geo/docs/components/INDEX.md)
