---
name: navigation-properties-rule-user-module
description: User module navigation static properties usage rule
type: project
---

## Rule Overview

**Do not use static navigation properties from non-XotBasePage classes.**  

In the User module, classes that extend `XotBasePage` should **not** define the following static properties:

```php
protected static ?string $navigationIcon = 'heroicon-o-key';
protected static ?string $navigationGroup = 'User';
protected static ?int $navigationSort = 90;
```

### Why This Rule Exists

- **Separation of Concerns**: Navigation configuration belongs to the page class itself, not to its extending classes.
- **Automatic Detection**: `XotBasePage` automatically discovers navigation settings from the child class, making explicit static declarations redundant.
- **Consistency**: Ensures all navigation properties are resolved through the same mechanism across the module.

### Correct Usage

```php
// ✅ CORRECT - No static navigation properties needed
class SocialiteSettingsPage extends XotBasePage
{
    // Navigation is automatically picked up from $this->view, $this->title, etc.
}
```

### Incorrect Usage

```php
// ❌ WRONG - Redundant static properties
protected static ?string $navigationIcon = 'heroicon-o-key';
protected static ?string $navigationGroup = 'User';
protected static ?int $navigationSort = 90;
```

### Remediation Checklist

1. Search for static `$navigationIcon`, `$navigationGroup`, `$navigationSort` declarations in the User module.
2. Remove any such declarations that are not part of a direct `XotBasePage` subclass.
3. Verify that navigation label, icon, group, and sort are defined as methods (`getNavigationLabel()`, `getTitle()`) if needed.
4. Run `phpstan analyse` to ensure no regressions.

### Related Rules

- **Filament Widget + Template as Dress Rule** – Widget PHP handles logic; Blade template is only presentation.
- **5‑Element Translation Rule** – All translation entries must follow the structured format.
- **SVG Asset Location** – SVG files must be stored under `resources/svg/` of their module.

### Documentation

- See `Modules/User/docs/wiki/rules/navigation-properties.md` for this rule.
- Refer to `Modules/Xot/docs/models/THIRD-PARTY-MODEL-INHERITANCE-PHILOSOPHY.md` for inheritance patterns.
