# Architectural Rules & Guidelines — Xot Module

The Xot module is the **foundational framework** for the entire Laraxot ecosystem. It provides core utilities, base classes, and architectural standards that all other modules must follow.

## Super Cow Methodology

This module adheres to the **Super Cow Methodology** — Laraxot's comprehensive architecture for building scalable, maintainable Laravel applications.

For detailed implementation guidance:
- [Super Cow Methodology](./super_cow_methodology.md)
- [PHP Quality Guide](./php_quality_guide.md)
- [Filament Extension Rules](./filament_extension_rules.md)

## Key Principles

1. **DRY & KISS**: Don't repeat yourself, keep it simple.
2. **Zero Errors**: PHPStan Level 10 compliance is mandatory.
3. **XotBase**: All modules must extend `XotBase` classes, never Filament classes directly.
4. **Directory Structure**: All domain logic must reside within `app/` and database migrations within `database/`. See the structure section below.

## Directory Structure

### ✅ Correct Structure

```
Xot/
├── app/                           # Domain & application logic
│   ├── Actions/                   # Business logic actions
│   ├── Events/                    # Domain events
│   ├── Listeners/                 # Event listeners
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
├── helpers/
├── packages/
├── stubs/                         # Code generation stubs
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
- [Laraxot Architecture Rules](./laraxot-architecture-rules.md)

---

*Last updated: June 2026*
