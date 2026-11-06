---
title: "fix merge conflicts"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "fix merge conflicts"
issues: []
discussions: []
---

# BMAD Story: Fix Merge Conflicts in All Modules

## Understand
- **Problem**: 890 PHP files across all modules contain unresolved git merge conflict markers (`<<<<<<< HEAD`, `=======`, `>>>>>>> laraxot/dev`) causing syntax errors and preventing PHPStan analysis
- **Impact**: Composer update fails, PHPStan cannot parse files, code quality tools fail
- **Applicable Rules**:
  - BMAD Workflow: Create story before development
  - Git Flow: Study old versions with `git show`, never restore/checkout/reset/revert/rollback
  - PHPStan Rules: Never modify phpstan.neon, fix syntax errors first
  - Code Quality: After every edit run phpstan + phpmd + phpinsights + pest

## Plan
1. **Analyze conflict patterns** - categorize conflicts by type (lang files, code files, config files, stubs)
2. **Auto-resolve simple conflicts** - where HEAD is empty and laraxot/dev has content (take laraxot/dev)
3. **Manual resolve complex conflicts** - where both sides have different code
4. **Fix EOF/syntax errors** - files with incomplete code after conflict resolution
5. **Run verification** - phpstan, phpmd, phpinsights, pest

## Conflict Categories
1. **Lang files** (Modules/*/lang/) - HEAD empty, laraxot/dev has translations → Take laraxot/dev
2. **Code files** (Modules/*/app/) - Both sides have code → Manual review needed
3. **Config/Stub files** (Modules/*/docs/, config/) - Mixed patterns
4. **Test files** - Both sides may have test variations

## Implement
- Write scripts to auto-resolve clear patterns
- Manually fix complex code conflicts
- Ensure all files have `declare(strict_types=1);`
- Fix any remaining syntax errors

## Verify
- `./vendor/bin/phpstan analyse Modules --memory-limit=8G` - zero parse errors
- `./tools/phpmd.sh` - no critical issues
- `./vendor/bin/phpinsights analyse` - improved scores
- `./vendor/bin/pest` - tests pass

## Document
- Update `Modules/Xot/docs/stories/fix-merge-conflicts.md` (this file)
- Update `docs/wiki/rules/00-TRIGGER_MAP.md` if new patterns found
- Create backlinks in related module docs

## Status
- **Branch**: dev
- **Module**: Xot (primary), all modules affected
- **Next**: Analyze conflict patterns and create resolution strategy