# Enum Standards - Notify Module

## Overview

All enums in the Notify module follow the **Filament Standard** with `EnumTrait` from `Modules\Xot\Traits\EnumTrait`.

## Rule: No label(), icon(), color() Methods

**CRITICAL:** Never define `label()`, `icon()`, or `color()` methods in enums. These names violate Filament standards.

### ❌ Wrong

```php
enum NotificationTypeEnum: string
{
    use EnumTrait;
    
    public function label(): string  // ❌ Forbidden
    public function icon(): string   // ❌ Forbidden
    public function color(): string  // ❌ Forbidden
}
```

### ✅ Correct

```php
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

enum NotificationTypeEnum: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;
    
    // EnumTrait provides:
    // - getLabel()  ← from translations
    // - getIcon()   ← from translations
    // - getColor()  ← from translations
}
```

## Translation Structure

Configure enum values in language files:

```php
// Modules/Notify/lang/it/enums.php
return [
    'notification_type' => [
        'values' => [
            'email' => [
                'label' => 'Email',
                'icon' => 'heroicon-o-envelope',
                'color' => 'success',
                'description' => 'Notifica via email',
            ],
            'sms' => [
                'label' => 'SMS',
                'icon' => 'heroicon-o-device-phone-mobile',
                'color' => 'warning',
            ],
            'push' => [
                'label' => 'Push Notification',
                'icon' => 'heroicon-o-bell',
                'color' => 'info',
            ],
        ],
    ],
    'notification_log_status' => [
        'values' => [
            'pending' => [
                'label' => 'In attesa',
                'icon' => 'heroicon-o-clock',
                'color' => 'gray',
            ],
            'sent' => [
                'label' => 'Inviato',
                'icon' => 'heroicon-o-paper-airplane',
                'color' => 'blue',
            ],
            // ... etc
        ],
    ],
];
```

## Enums in This Module

| Enum | Trait | Interfaces | Custom Methods |
|------|-------|------------|----------------|
| `NotificationTypeEnum` | ✅ EnumTrait | HasColor, HasIcon, HasLabel | None |
| `NotificationLogStatusEnum` | ✅ EnumTrait | HasColor, HasIcon, HasLabel | `isCompleted()`, `isFailed()`, `isPending()` |
| `ChannelEnum` | ✅ EnumTrait | HasLabel | None |
| `ContactTypeEnum` | ✅ EnumTrait | HasLabel | `getColumnDefinitions()` |
| `SmsDriverEnum` | ✅ EnumTrait | HasLabel | None |

## Override Policy

Only override `getLabel()`, `getIcon()`, `getColor()` if you need custom logic different from translations:

```php
public function getColor(): string
{
    return match ($this) {
        self::FAILED => 'danger',
        default => parent::getColor(), // or from trait
    };
}
```

## References

- Global Rule: `docs/wiki/rules/enum-filament-standard.md`
- EnumTrait: `Modules/Xot/app/Traits/EnumTrait.php`
