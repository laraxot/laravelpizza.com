# Architectural Rules & Guidelines

This module adheres to the **Laraxot Architecture** and **Super Cow Methodology**.

For strict coding standards, Filament extension rules, and PHPStan guidelines, please refer to the central documentation in the **Xot Module**:

- [Super Cow Methodology](../../Xot/docs/super_cow_methodology.md)
- [PHP Quality Guide](../../Xot/docs/php_quality_guide.md)
- [Filament Extension Rules](../../Xot/docs/filament_extension_rules.md)

## Key Principles

1. **DRY & KISS**: Don't repeat yourself, keep it simple.
2. **Zero Errors**: PHPStan Level 10 compliance is mandatory.
3. **XotBase**: Always extend `XotBase` classes, never Filament classes directly.
4. **Directory Structure**: All domain logic must reside within `app/` and database migrations within `database/`. See the structure section below.

## Directory Structure

### ✅ Correct Structure

```
User/
├── app/                           # Domain & application logic
│   ├── Actions/                   # Business logic actions
│   ├── Events/                    # Domain events
│   ├── Listeners/                 # Event listeners
│   ├── Application/               # Use case implementations
│   ├── Models/
│   ├── Http/
│   ├── Filament/
│   ├── Providers/
│   └── ... (other domain classes)
├── database/                      # Database migrations & seeders
│   ├── migrations/
│   └── seeders/
├── resources/                     # View resources
├── routes/
├── config/
├── lang/
├── docs/                          # Documentation
├── tests/
└── ... (other standard folders)
```

### ❌ Forbidden Root Folders

**These folders MUST NOT exist at module root level:**
- ❌ `Actions/` — Must move to `app/Actions/`
- ❌ `Application/` — Must move to `app/Application/`
- ❌ `Database/` (capitalized) — Rename to lowercase `database/`
- ❌ `Events/` — Must move to `app/Events/`
- ❌ `Listeners/` — Must move to `app/Listeners/`

**Rationale:** Laravel PSR-4 autoloading expects all application code within `app/`. Root-level folders break namespace resolution and violate consistency standards.

## Related Documentation

- [Module Structure Organization Rule](../../../docs/wiki/concepts/module-structure-organization-rule.md)
- [No lang/lang/ and No _docs/ Rule](../../../docs/wiki/concepts/no-lang-lang-and-no-underscore-docs-rule.md)

---

*Last updated: June 2026*
