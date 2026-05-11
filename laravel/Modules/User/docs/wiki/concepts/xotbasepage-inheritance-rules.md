---
title: "XotBasePage Inheritance Rules - Auto-Translation via TransTrait"
type: concept
confidence: high
created: 2026-04-20
updated: 2026-04-20
tags: [filament, xotbasepage, translation, inheritance, navigation, dry]
sources:
  - laravel/Modules/Xot/app/Filament/Pages/XotBasePage.php
  - laravel/Modules/Xot/app/Filament/Traits/TransTrait.php
  - laravel/Modules/User/app/Filament/Pages/SocialiteProviderSettingsPage.php
related:
  - ../../../../docs/wiki/concepts/filament-page-architecture.md
  - ./translation-5-level-structure.md
---

# XotBasePage Inheritance Rules

## The Rule

**Pages extending `XotBasePage` MUST NOT override `getNavigationLabel()` or `getTitle()`.**

**TransTrait handles these automatically via translation files.**

---

## ❌ WRONG - Never Do This

```php
namespace Modules\User\Filament\Pages;

class MySettingsPage extends XotBasePage
{
    // These methods should NOT be here!
    
    public static function getNavigationLabel(): string
    {
        return __('user::mysettings.navigation.label');  // ❌ WRONG
    }

    public function getTitle(): string
    {
        return __('user::mysettings.page.title');  // ❌ WRONG
    }
}
```

---

## ✅ CORRECT - Let TransTrait Handle It

```php
namespace Modules\User\Filament\Pages;

class MySettingsPage extends XotBasePage
{
    // Just define these properties
    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationGroup = 'User';
    protected static ?int $navigationSort = 90;

    /** @var string */
    protected string $view = 'user::filament.pages.my-settings';
    
    // NO getNavigationLabel() - TransTrait handles it
    // NO getTitle() - TransTrait handles it
}
```

**Translation file:**
```php
// laravel/Modules/User/lang/it/mysettings.php
return [
    'navigation' => [
        'label' => 'Impostazioni',        // Used for nav
        'group' => 'User',                   // Nav group
    ],
    'title' => 'Impostazioni Utente',      // Page title
];
```

---

## How TransTrait Works

```php
// In XotBasePage (via TransTrait)

public static function getNavigationLabel(): string
{
    return static::trans('navigation.label');  // Auto-resolved
}

public function getHeading(): string
{
    return $this->trans('title');  // Page title
}
```

**Key insight**: TransTrait uses the class name to resolve translation keys automatically.

---

## Required Properties Only

When extending `XotBasePage`, only define:

| Property | Required | Description |
|----------|----------|-------------|
| `$navigationIcon` | Optional | Heroicon name |
| `$navigationGroup` | Optional | Nav group name |
| `$navigationSort` | Optional | Sort order (int) |
| `$view` | **Required** | Blade view path |

**Do NOT define:**
- `getNavigationLabel()` - Handled by TransTrait
- `getTitle()` / `getHeading()` - Handled by TransTrait
- `getPluralModelLabel()` - Handled by TransTrait

---

## Translation Key Structure

For a page class `SocialiteProviderSettingsPage`:

```php
// laravel/Modules/User/lang/it/socialite.php
return [
    // Navigation
    'navigation' => [
        'label' => 'OAuth Providers',
        'group' => 'User Management',
        'icon' => 'heroicon-o-key',
        'sort' => 90,
    ],
    
    // Page title (used by getHeading())
    'title' => 'Configurazione OAuth',
    
    // Form fields
    'form' => [
        'google' => [
            'label' => 'Google OAuth',
            // ...
        ],
    ],
];
```

**Note**: The translation file name should match the feature/context, not necessarily the class name.

---

## Verification

```bash
# Check for unnecessary method overrides
grep -r "function getNavigationLabel\|function getTitle\|function getHeading" \
  laravel/Modules/User/app/Filament/Pages/ || echo "✅ Clean - no overrides"

# Verify pages extend XotBasePage
grep -r "extends XotBasePage" laravel/Modules/User/app/Filament/Pages/

# Check translation files have required keys
grep -l "'navigation'" laravel/Modules/User/lang/it/*.php
```

---

## Pre-Commit Checklist for XotBasePage Pages

- [ ] Extends `XotBasePage` (not `Page` directly)
- [ ] No `getNavigationLabel()` method
- [ ] No `getTitle()` method
- [ ] No `getHeading()` method
- [ ] Has `$view` property defined
- [ ] Translation file exists with `navigation.label`
- [ ] Translation file has `title` key

---

## References

- **XotBasePage**: `laravel/Modules/Xot/app/Filament/Pages/XotBasePage.php`
- **TransTrait**: `laravel/Modules/Xot/app/Filament/Traits/TransTrait.php`
- **Filament Page**: https://filamentphp.com/docs/3.x/pages

---

**Last Updated**: 2026-04-20
**Rule Owner**: Xot Module Architecture
