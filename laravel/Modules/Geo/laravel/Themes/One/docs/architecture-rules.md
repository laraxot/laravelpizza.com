---
title: architecture rules — Theme One
type: reference
updated: 2026-06-18
---

# Architecture Rules — Theme One

Themes follow the same directory structure standards as Modules.

## Key References

- **Global Rules**: [Trigger Map](../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)
- **BMAD Architecture**: [architecture.md](../../../../../docs/wiki/bmad/architecture.md) · [architecture-module-directory-structure.md](../../../../../docs/wiki/bmad/architecture-module-directory-structure.md)
- **Module Structure Rule**: [module-root-php-folders-forbidden.md](../../../../../docs/wiki/rules/module-root-php-folders-forbidden.md)
- **PHPStan Memory**: ALWAYS use `php -d memory_limit=-1 ./vendor/bin/phpstan` for heavy analyses to avoid parallel worker crashes.
- **Documentation Rules**: [No lang/lang/ and No _docs/ Rule](../../../../../docs/wiki/concepts/no-lang-lang-and-no-underscore-docs-rule.md)

## Directory Structure

Themes must maintain consistent structure with Modules:

```
Theme/
├── components/              # Reusable components
├── layouts/                 # Layout templates
├── resources/              # CSS, JS, images
├── config/
├── docs/                   # Documentation (never _docs)
└── tests/
```

### ❌ Forbidden Root Folders

At theme root level, these folders MUST NOT exist:
- ❌ `Actions/`
- ❌ `Application/`
- ❌ `Events/`
- ❌ `Listeners/`
- ❌ `Database/` (capitalized)

## Regola Dipendenza Moduli

La dipendenza tra moduli è **unidirezionale**:

```
Xot ← UI ← Geo, User, Tenant, Activity, …
```

- Il modulo **UI non dipende** da Geo (o altri moduli domain-specific)
- Il modulo **Geo può dipendere** da UI
- Componenti geografici (mappe, geocoding, `LocationSelector` con `Comune`) → `Modules/Geo/`
- Ref: [`Modules/UI/docs/dependency-rules.md`](../../../../Modules/UI/docs/dependency-rules.md)

---

*Updated: 2026-07-06*
