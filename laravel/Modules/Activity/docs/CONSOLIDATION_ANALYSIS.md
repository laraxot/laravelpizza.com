---
title: Root .md Consolidation Analysis — Activity Module
date: 2026-08-18
status: analysis
---

# Consolidation Analysis — Activity Module

**Module:** Activity  
**Scope:** Root .md files owned by Activity, relocation plan  
**Analysis Date:** 2026-08-18

## Files Relocating to This Module

### Overview

1 critical documentation file currently in root belongs to Activity module and should move to `laravel/Modules/Activity/docs/`:

| File | Lines | Status | Priority | Owner Rationale |
|------|-------|--------|----------|-----------------|
| `critical-mai-fare-migrate-refresh.md` | 67 | MOVE | **CRITICAL** | Activity data integrity constraint; must be visible to developers |

## Consolidation Rationale

**Why move:**
- **Criticality:** This is a hard constraint: NEVER run `migrate:refresh`, `migrate:fresh`, or `migrate --force` on Activity. Data loss is irreversible.
- **Visibility:** Moving to Activity/docs ensures every Activity developer sees this constraint immediately. Root .md are easily missed.
- **Isolation:** Activity owns its migration policy; policy should live in Activity module.

**When to move:**
- **NOW** — No delays. This is a safety-critical document.

## Post-Move Structure

```
laravel/Modules/Activity/
├── docs/
│   ├── CONSOLIDATION_ANALYSIS.md (this file)
│   ├── CRITICAL_MIGRATION_CONSTRAINTS.md ← rename for clarity
│   └── ... (other Activity docs)
├── app/
├── config/
├── database/
│   ├── migrations/ (sacred — no refresh)
│   ├── factories/
│   └── seeders/
└── tests/
```

## Index of Relocated Docs

1. **critical-mai-fare-migrate-refresh.md** (rename to **CRITICAL_MIGRATION_CONSTRAINTS.md**):
   - Explicit list of forbidden commands
   - Why: Activity holds user behavioral data; refresh loses audit trail
   - Enforcement: Documented in Activity/docs and referenced in Activity README.md

## Related Modules

- **Progressioni** — depends on Activity; same constraint applies to Progressioni migrations.
- **Tenant** — shared tenancy; migration policy affects all modules.

## Action Items

- [ ] Move `critical-mai-fare-migrate-refresh.md` from root to `laravel/Modules/Activity/docs/`
- [ ] Rename to `CRITICAL_MIGRATION_CONSTRAINTS.md` for clarity
- [ ] Add reference in `laravel/Modules/Activity/README.md` with ⚠️ badge
- [ ] Cross-link from Progressioni/docs (note shared constraint)
- [ ] Commit as atomic: "docs(activity): consolidate critical migration constraints from root"

## Enforcement

**Add to Activity/README.md:**

```markdown
⚠️ **CRITICAL CONSTRAINT**

Activity module holds user behavioral audit data. Never run:
- `php artisan migrate:refresh`
- `php artisan migrate:fresh`
- `php artisan migrate --force`

Details: see `docs/CRITICAL_MIGRATION_CONSTRAINTS.md`
```

## Reference

**Global consolidation plan:** See `ROOT_MD_CONSOLIDATION_PLAN.md` (to be created in docs/).
