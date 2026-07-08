---
title: architecture rules — Theme Three
type: reference
updated: 2026-06-18
---

# Architecture Rules — Theme Three

Themes follow the same directory structure standards as Modules.

## Key References

- **Global Rules**: [Trigger Map](../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)
- **Module Structure Rules**:
  - All functional code MUST be inside `app/`.
  - Root-level capitalized directories (e.g., `Actions/`, `Database/`) are forbidden.
  - `database/` must be lowercase.
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

---

*Updated: June 2026*
