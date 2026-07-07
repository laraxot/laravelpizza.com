# Enum Standards - Geo Module

## Overview

All enums in the Geo module follow the **Filament Standard** with `EnumTrait`.

## Rule: No label(), icon(), color() Methods

**CRITICAL:** Never define `label()`, `icon()`, or `color()` methods in enums.

### ✅ Correct Pattern

```php
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

enum AddressTypeEnum: string implements HasLabel
{
    use EnumTrait;
    
    case HOME = 'home';
    case WORK = 'work';
    // ...
    
    // Use getLabel() from trait in your methods:
    public static function options(): array
    {
        return [
            self::HOME->value => self::HOME->getLabel(),
            self::WORK->value => self::WORK->getLabel(),
        ];
    }
}
```

## Translation Structure

```php
// Modules/Geo/lang/it/enums.php
return [
    'address_type' => [
        'values' => [
            'home' => [
                'label' => 'Casa',
                'icon' => 'heroicon-o-home',
                'color' => 'primary',
            ],
            'work' => [
                'label' => 'Lavoro',
                'icon' => 'heroicon-o-briefcase',
                'color' => 'info',
            ],
            'billing' => [
                'label' => 'Fatturazione',
                'icon' => 'heroicon-o-receipt',
                'color' => 'warning',
            ],
            'shipping' => [
                'label' => 'Spedizione',
                'icon' => 'heroicon-o-truck',
                'color' => 'success',
            ],
            'legal' => [
                'label' => 'Sede legale',
                'icon' => 'heroicon-o-building-library',
                'color' => 'danger',
            ],
            'other' => [
                'label' => 'Altro',
                'icon' => 'heroicon-o-map-pin',
                'color' => 'gray',
            ],
        ],
    ],
    'address_item' => [
        'values' => [
            // ...
        ],
    ],
];
```

## Enums in This Module

| Enum | Trait | Interfaces | Notes |
|------|-------|------------|-------|
| `AddressTypeEnum` | ✅ EnumTrait | HasLabel | Uses `getLabel()` in `options()` |
| `AddressItemEnum` | ✅ EnumTrait | HasLabel | Has `getColumnDefinitions()` |

## References

- Global Rule: `docs/wiki/rules/enum-filament-standard.md`
