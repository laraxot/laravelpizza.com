# Translation Directory Structure

## Rule: No `lang/lang/` Redundancy

Translation directories must follow Laravel convention:

```
Modules/ModuleName/lang/{locale}/file.php
```

**NOT**:
```
Modules/ModuleName/lang/lang/{locale}/file.php  ← WRONG
```

### Why

- DRY principle: `lang/lang/` is redundant
- Laravel expects `lang/{locale}/` directly
- Prevents path resolution confusion

### Fixed

- 2026-03-12: Removed `Job/lang/lang/` and `User/lang/lang/`

### Reference

See `project_docs/TRANSLATION_DIRECTORY_RULES.md` for full details.
