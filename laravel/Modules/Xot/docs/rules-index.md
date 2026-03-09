# Xot Module Rules Index

## Overview
This file documents the rules and standards specific to the Xot core module.

## Core Architecture Rules

### Base Classes
- All Filament resources MUST extend `XotBaseResource`
- All Filament pages MUST extend `XotBasePage`
- All Filament widgets MUST extend `XotBaseWidget`
- All models MUST extend module-specific BaseModel, not directly Illuminate\Model

### Service Providers
- Minimal service providers - let XotBase handle the work
- NEVER override boot() or register() just to call parent
- Include required properties: `$module_dir`, `$module_ns`, `$name`

### Translations
- Use auto-label system (never manual ->label())
- Translation files go in `lang/{locale}/`
- Use expanded structure with navigation, fields, actions

## Code Quality

### PHPStan
- Target Level 10
- Use Safe\ functions instead of unsafe PHP built-ins
- Proper type declarations on all methods

### Model Conventions
- Use `casts()` method NOT `$casts` property
- Use `isset()` for magic properties, NEVER `property_exists()`
- Always use short array syntax `[]`

## Testing
- Use PestPHP
- Test via Actions (business logic)
- Use contracts for dependency injection

### Actions (Spatie QueueableAction)
- **ALWAYS** use `use QueueableAction` trait (NOT `extends`)
- **ALWAYS** call `execute()` method directly
- **NEVER** use constructor DI - resolve via `app()` inside execute()
- **NEVER** call custom methods that internally call execute()
```php
// ✅ CORRECT
app(CreateUserAction::class)->execute($data);

// ❌ WRONG
app(CreateClientAction::class)->createPersonalAccessClient(); // calls execute() internally
```

See: [Action Usage Patterns](./actions/action-usage-patterns.md)

## Related Documentation
- [README](./README.md)
- [phpstan](./phpstan.md)
- [Chaos Monkey Operability Rules](./chaos-monkey-operability-rules.md)
- [Composer Packages Deep Study (2026-03-02)](./composer-packages-deep-study-2026-03-02.md)
- [Composer Packages Full Catalog (2026-03-02)](./composer-packages-full-catalog-2026-03-02.md)
