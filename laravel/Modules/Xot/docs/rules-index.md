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

### PHPInsights (import order)
- `use function Safe\*` prima di `use Webmozart\Assert\Assert` (ordine alfabetico)
- Metodi protected alla fine di trait/class (dopo metodi pubblici)

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

See: [Action Execution and DI Rules](./actions/action-execution-and-di-rules.md)

## Related Documentation
- [README](./readme.md)
- [phpstan](./phpstan.md)

## Pre-Edit Rule Link

- [Pre-Edit Docs-First Rule](../../../../docs/rules/pre-edit-docs-first-rule.md)
- [Pre-Edit Docs-First Memory](../../../../docs/memory/pre-edit-docs-first-memory.md)
- [Pre-Edit Docs-First Skill](../../../../docs/skills/pre-edit-docs-first-skill.md)
