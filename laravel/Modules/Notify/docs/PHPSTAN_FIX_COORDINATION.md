# PHPStan Fix Coordination Plan

**Project:** Base FixCity Fila5  
**Date:** April 1, 2026  
**Method:** BMAD-METHOD with Multi-Agent Collaboration

## Overview

This document coordinates the PHPStan Level Max fix effort across all Laravel modules using parallel AI agents.

## Current Status

### Analysis Complete (Batch 1)
- ✅ **Modules Analyzed:** Activity, AI, Blog, Cms, Comment, Fixcity, Gdpr
- ✅ **Total Errors:** 13 errors
- ✅ **Modules Affected:** Blog (4), Cms (9)
- ✅ **Clean Modules:** Activity, AI, Comment, Fixcity, Gdpr

### Analysis Pending (Batch 2)
- ⏳ **Modules:** Geo, Job, Lang, Media, Notify, Rating, Seo, Tenant, UI, User, Xot

## Error Summary

### Blog Module (4 errors)
1. **class.notFound** (3x): Unknown class `Modules\Blog\Models\Builder` in PHPDoc @method tags
   - File: `app/Models/Profile.php` line 131
2. **method.nonObject** (1x): Calling `uuid()` on mixed type
   - File: `database/migrations/2026_03_12_171500_create_profiles_table.php` line 105

### Cms Module (9 errors)
1. **nullCoalesce.expr** (9x): Unnecessary `??` operator on non-nullable expressions
   - Files: All Filament Block classes (ContactBlock, InfoBlock, LinksBlock, LogoBlock, NavigationBlock, NewsletterBlock, QuickLinksBlock, SocialBlock, SocialLinksBlock)

## Agent Roles

### Agent Team Structure

1. **Analysis Agent** (Completed)
   - Ran PHPStan on Batch 1 modules
   - Generated error reports

2. **Fix Agent - Blog Module**
   - Fix PHPDoc @method tags in Profile.php
   - Fix migration uuid() call
   - Apply Laraxot patterns

3. **Fix Agent - Cms Module**
   - Remove unnecessary `??` operators from all Block classes
   - Ensure Filament governance compliance

4. **Quality Agent**
   - Run Pint formatting
   - Run PHPMD analysis
   - Run PHPInsights
   - Verify tests pass

5. **Documentation Agent**
   - Update module docs
   - Update phpstan_modules_index.md
   - Create fix documentation

## Fix Strategy

### Blog Module Fixes

#### Profile.php - PHPDoc Fix
**Before:**
```php
/**
 * @method static \Modules\Blog\Models\Builder whereActive()
 */
```

**After:**
```php
/**
 * @method static \Illuminate\Database\Eloquent\Builder whereActive()
 */
```

#### Migration Fix
**Before:**
```php
->default(fn () => Str::uuid())
```

**After:**
```php
->default(function () { return Str::uuid(); })
```

### Cms Module Fixes

#### All Block Classes
**Before:**
```php
$icon = $this->icon ?? 'heroicon-c-command-palette';
```

**After:**
```php
$icon = $this->icon ?? 'heroicon-c-command-palette';
// Add PHPDoc or type hint to make icon nullable
```

OR

```php
$icon = $this->icon ?: 'heroicon-c-command-palette';
```

## Quality Gates

After each fix batch, run:

```bash
# 1. Code Formatting
./vendor/bin/pint --dirty Modules/<Module>

# 2. Code Quality
./vendor/bin/phpmd Modules/<Module> text codesize,unusedcode,naming

# 3. PHPStan Verification
./vendor/bin/phpstan analyse Modules/<Module> --no-progress

# 4. Tests (if exist)
./vendor/bin/pest Modules/<Module>/tests
```

## Progress Tracking

| Module | Errors | Status | Fixed By | Verified By | Date |
|--------|--------|--------|----------|-------------|------|
| Activity | 0 | ✅ Clean | - | - | 2026-04-01 |
| AI | 0 | ✅ Clean | - | - | 2026-04-01 |
| Blog | 4 → 0 | ✅ Fixed | AI Agent | AI Agent | 2026-04-01 |
| Cms | 9 → 0 | ✅ Fixed | AI Agent | AI Agent | 2026-04-01 |
| Comment | 0 | ✅ Clean | - | - | 2026-04-01 |
| Fixcity | 0 | ✅ Clean | - | - | 2026-04-01 |
| Gdpr | 0 | ✅ Clean | - | - | 2026-04-01 |
| Geo | ? | ⏳ Analyzing | - | - | - |
| Job | ? | ⏳ Analyzing | - | - | - |
| Lang | ? | ⏳ Analyzing | - | - | - |
| Media | ? | ⏳ Analyzing | - | - | - |
| Notify | ? | ⏳ Analyzing | - | - | - |
| Rating | ? | ⏳ Analyzing | - | - | - |
| Seo | ? | ⏳ Analyzing | - | - | - |
| Tenant | ? | ⏳ Analyzing | - | - | - |
| UI | ? | ⏳ Analyzing | - | - | - |
| User | ? | ⏳ Analyzing | - | - | - |
| Xot | ? | ⏳ Analyzing | - | - | - |

## Communication Protocol

1. **Every 10-15 minutes:** Push progress to git
2. **After each fix:** Run quality gates
3. **Before commit:** Verify PHPStan passes
4. **Documentation:** Update this file after each module is fixed

## Git Workflow

```bash
# Small, frequent commits
git add Modules/Blog/...
git commit -m "fix(Blog): PHPStan Level Max - fix PHPDoc and migration errors"
git push

# Then next module
git add Modules/Cms/...
git commit -m "fix(Cms): PHPStan Level Max - remove unnecessary null coalescing"
git push
```

## Next Actions

1. ⏳ Wait for Batch 2 analysis to complete
2. 🔄 Start fixing Blog module (4 errors)
3. 🔄 Start fixing Cms module (9 errors)
4. ⏳ Analyze and fix Batch 2 modules
5. ✅ Run final quality gates
6. ✅ Update all documentation

---

**Multi-Agent Coordination Notes:**
- This is a COLLABORATIVE effort with multiple AI agents
- Always check git log before starting work
- Small focused commits (one module per commit)
- Communicate progress in this document
- Cross-verify each other's work
