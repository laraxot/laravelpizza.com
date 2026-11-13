# Geo Module — Components

## Filament Form Components

| Component | Path | Description |
|-----------|------|-------------|
| **AddressInput** | `app/Filament/Forms/Components/AddressInput.php` | Address input field with geolocation button (Filament Field component) |
| **AddressField** | `app/Filament/Forms/Components/AddressField.php` | Full address section with cascading region/province/locality selects |
| **AddressSection** | `app/Filament/Forms/Components/AddressSection.php` | Legacy section-based address form |

### Usage: AddressInput (Recommended for simple address + geolocation)

```php
use Modules\Geo\Filament\Forms\Components\AddressInput;

// In any Filament schema (wizard, form, etc.)
AddressInput::make('address')
    ->label('Indirizzo')
    ->required()
    ->spritePath('/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg');
```

### Anti-Pattern: NEVER use \Blade::render()

```php
// ❌ WRONG - Causes "Undefined variable $_instance" errors
Placeholder::make('address_section')
    ->label('')
    ->content(new HtmlString(
        \Blade::render('geo::filament.components.address-field', [...])
    ));
```

**Why**: `\Blade::render()` creates an isolated context. No access to `$this`, `$form`, `$livewire`, or proper `wire:model` bindings.

### Usage: AddressField (For full address with geographic hierarchy)

```php
use Modules\Geo\Filament\Forms\Components\AddressField;

AddressField::make('address')
    ->relationship('address')
    ->disableLiveUpdates(); // Use in wizards to prevent infinite loops
```

## Blade Components (Legacy)

| Component | Path | Description |
|-----------|------|-------------|
| Address Field (Blade) | `resources/views/components/geolocation/address-field.blade.php` | Legacy Blade component — DO NOT USE in Filament schemas |
| Address Field (Filament view) | `resources/views/filament/components/address-field.blade.php` | Legacy Filament view — superseded by `AddressInput` component |

### Translations

Namespace: `geo::address.*`
- `fields.address.label` → "Luogo*"
- `fields.address.placeholder` → "Cerca un luogo*"
- `fields.use_my_location.label` → "Usa la tua posizione"
- `geolocation.not_supported` → "Geolocalizzazione non supportata"
- `geolocation.address_not_found` → "Indirizzo non trovato"
- `geolocation.error` → "Errore generico"
- `geolocation.permission_denied` → "Permesso negato"

### Zen

> **Geolocation belongs to Geo module.**
> The Geo module owns all location-related functionality. Domain modules (Fixcity, etc.) consume it via native Filament components.
> This follows **Domain-Driven Design**, **Single Responsibility Principle**, and the **Laraxot Architecture**.

### Architecture Rule

**NEVER use `\Blade::render()` to inject UI into a Filament schema.**

Always create a proper `Filament\Forms\Components\Field` subclass with its own view. This ensures:
1. Native `wire:model` bindings
2. Proper state hydration/dehydration
3. Integration with Filament validation
4. Reusability across all modules
5. No context isolation errors
