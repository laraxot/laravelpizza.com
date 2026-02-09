# PasswordData — Tenant-Configurable Password Management

> **Philosophy**: Centralize password rules in a single Spatie Data DTO for DRY, type-safe, tenant-configurable validation.

## Key Pattern

```php
// CORRECT ✅ - Uses tenant-configurable PasswordData
use Modules\User\Datas\PasswordData;

// Get validation rule
TextInput::make('password')
    ->rule(PasswordData::make()->getPasswordRule())

// Get both password and confirmation inputs
Grid::make(2)->schema(
    PasswordData::make()->getPasswordFormComponents('password')
)
```

## Why PasswordData?

| Principle | Implementation |
|-----------|----------------|
| **DRY** | Password rules defined once, used everywhere |
| **Tenant-Configurable** | Rules loaded from `TenantService::getConfig('password')` |
| **Type-Safe** | Spatie Data DTO with strict typing |
| **Fluent API** | Builds Laravel's `Password` validation dynamically |
| **Helper Text** | Auto-generates requirements description |

## PasswordData Methods

| Method | Returns | Description |
|--------|---------|-------------|
| `make()` | `self` | Singleton from tenant config |
| `getPasswordRule()` | `Password` | Laravel Password validation rule |
| `getPasswordFormComponents(field)` | `array<TextInput>` | Password + confirmation inputs |
| `getHelperText()` | `string` | Human-readable requirements |
| `getValidationMessages()` | `array<string,string>` | Validation error messages |

## Configuration (per tenant)

Located in tenant config under `password` key:

```php
[
    'min' => 8,              // Minimum length
    'mixedCase' => true,     // Require upper+lower
    'letters' => true,       // Require letters
    'numbers' => true,       // Require numbers
    'symbols' => true,       // Require special chars
    'uncompromised' => true, // Check haveibeenpwned.com
    'compromisedThreshold' => 0,
    'otp_length' => 6,       // OTP code length
    'otp_expiration_minutes' => 5,
    'expires_in' => 60,      // Password reset expiry
]
```

## Anti-Pattern

```php
// ❌ WRONG - Hardcoded rules, violates DRY
TextInput::make('password')
    ->rules([
        'min:12',
        'regex:/[A-Z]/',
        'regex:/[a-z]/',
    ])

// ✅ CORRECT - Uses PasswordData
TextInput::make('password')
    ->rule(PasswordData::make()->getPasswordRule())
```

## Additional Libraries

- [zxcvbn-php](https://github.com/bjeavons/zxcvbn-php) — Password strength estimation
- [password-exposed](https://github.com/DivineOmega/laravel-password-exposed-validation-rule) — Check breached passwords

---

*Last updated: February 2026*
