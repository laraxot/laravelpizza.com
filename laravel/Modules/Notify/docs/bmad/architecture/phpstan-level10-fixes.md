---
title: "PHPStan Level 10 Fixes - Notify Module"
type: concept
tags: [phpstan, level10, fixes]
created: 2026-07-14
updated: 2026-07-14
qmd: "phpstan-level10-fixes-2 phpstan level 10 fixes - notify module"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index-1.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-100.md"
  - "./acronym-naming-conventions-1.md"
  - "./acronym-naming-conventions-2.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# PHPStan Level 10 Fixes - Notify Module

## Overview
This document tracks PHPStan Level 10 compliance fixes for the Notify module.

## Fixed Syntax Errors

### Language Files Syntax Fixes

#### Modules/Notify/resources/lang/it/mail.php
- **Issue**: Multiple duplicate key declarations and syntax errors
- **Fix**: Removed duplicate `tooltip` declarations and fixed array structure
- **Before**: Multiple duplicate keys causing syntax errors
- **After**: Clean array structure with unique keys

#### Modules/Notify/resources/lang/it/notification.php
- **Issue**: Extra closing brackets and semicolons
- **Fix**: Removed extra `];` and `]; ];` at end of file
- **Before**: Multiple closing brackets causing syntax errors
- **After**: Proper single closing bracket structure

#### Modules/Notify/resources/lang/it/template.php
- **Issue**: Extra closing brackets and semicolons
- **Fix**: Removed extra `];` and `]; ];` at end of file
- **Before**: Multiple closing brackets causing syntax errors
- **After**: Proper single closing bracket structure

## Remaining PHPStan Errors

After fixing the syntax errors, the following PHPStan errors remain in the Notify module:

### Type-related Errors
1. **Method return type declarations** - Various methods need proper return type hints
2. **Parameter type declarations** - Method parameters need type hints
3. **Property type declarations** - Class properties need type definitions

### Database-related Errors
1. **Eloquent relationship types** - Relationship methods need proper return types
2. **Query builder types** - Database queries need proper type annotations

### Configuration-related Errors
1. **Config array access** - Proper array key existence checks needed
2. **Configuration type safety** - Config values need proper type handling

## Next Steps

1. **Type Declarations**: Add proper PHP type hints to all methods and properties
2. **Database Annotations**: Add proper PHPDoc annotations for Eloquent relationships
3. **Configuration Safety**: Implement proper null checks for config access
4. **Return Types**: Ensure all methods have explicit return type declarations

## Testing

Run PHPStan regularly to track progress:
```bash
COMPOSER_DISABLE_XDEBUG_WARN=1 ./vendor/bin/phpstan analyse Modules/Notify --level=10 --no-progress
```

## Status
- ✅ Syntax errors fixed in language files
- ⚠️ Type-related errors remain
- ⚠️ Database-related errors remain
- ⚠️ Configuration-related errors remain