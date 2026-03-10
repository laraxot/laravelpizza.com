# Git Conflicts Resolution Pattern

## Overview

During the February 2026 rebase operation, we resolved a large number of git conflicts across multiple modules. This document captures the patterns and lessons learned.

## Conflict Resolution Strategy

### 1. Forward-Only Resolution for Documentation Files

For documentation files (`.md`), configuration files, and test files, the correct default is inspection first, not wholesale checkout:

```bash
git diff --name-only --diff-filter=U
git show :2:path/to/file
git show :3:path/to/file
```

Then merge intentionally into the current file and `git add` only after the resulting file reflects the current project contract.

### 2. Composer.json Conflicts

For `composer.json` files across modules, prioritize the incoming version which contains the latest dependency updates.

### 3. Critical Source Files

For PHP source files in `app/` directories:
1. Check for conflict markers with: `grep -n "^<<< HEAD\|^=======\|^>>>>>>>" $file`
2. If clean, mark as resolved with: `git add $file`
3. If conflicts exist, resolve manually preserving both changes where appropriate

## Common Conflict Patterns

### Pattern 1: Documentation Updates
- **Location**: `docs/*.md`, `README.md`
- **Resolution**: merge intentionally; never assume "theirs" is automatically correct

### Pattern 2: Composer Dependencies
- **Location**: `composer.json` in module roots
- **Resolution**: inspect both sides and keep the dependency set coherent with the current project state

### Pattern 3: Resource Files
- **Location**: `Resources/views/*.blade.php`, `Resources/assets/*`
- **Resolution**: preserve the active UX and behavioral contract, merging only the needed delta

## Rebase Workflow

```bash
# 1. Check for rebase status
ls -la .git/rebase-merge .git/rebase-apply

# 2. Check for unmerged files
git status --short | grep "^UU"

# 3. Resolve conflicts after inspection
#    no wholesale checkout of ours/theirs as default strategy

# 4. Continue rebase
git rebase --continue

# 5. Push when complete
git push origin dev
```

## Post-Rebase Verification

After resolving conflicts:

1. **Check PHPStan**: `./vendor/bin/phpstan analyse $file --level=10`
2. **Verify syntax**: `php -l $file`
3. **Check git status**: `git status --short`

## Lessons Learned

1. **Precision over shortcuts**: bulk acceptance creates regressions that are hard to audit later
2. **History is for study**: old sides are references, not restore targets
3. **Forward-only**: conflict resolution must produce a new coherent state
4. **Documentation priority**: preserve the current correct intent, not blindly one side

## Files Affected

- 200+ files across 40+ modules
- Primary conflicts in:
  - `docs/*.md` - Documentation files
  - `composer.json` - Dependency configurations
  - `Resources/views/*` - Blade templates
  - `tests/*.php` - Test files
