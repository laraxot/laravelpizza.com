---
title: "PHPStan Fixes Progress - 2026-01-09"
type: concept
tags: [phpstan, progress]
created: 2026-07-14
updated: 2026-07-14
qmd: "phpstan-progress phpstan fixes progress - 2026-01-09"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# PHPStan Fixes Progress - 2026-01-09

**Start Time**: 14:00
**Current Progress**: 35 → 26 errors (9 fixed)
**Status**: 🟡 IN PROGRESS

## Fixed So Far

### Batch 1: class.notFound (11 errors) ✅
- **Files**: PasswordResetConfirmWidget.php, ResetPasswordWidget.php
- **Fix**: Added `use Illuminate\Database\Eloquent\Model;`  
- **Time**: 10 minutes
- **Verified**: ✅ [OK] No errors

### Batch 2: RegisterTenant return type (2 errors) ✅  
- **File**: RegisterTenant.php:59
- **Fix**: Created `$schema` variable for type narrowing
- **Verified**: ✅ [OK] No errors

## Remaining: 26 errors

Next: Fix varTag errors (batch processing)

