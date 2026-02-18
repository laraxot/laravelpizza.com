# Git Conflicts Resolution Pattern

## Overview

During the February 2026 rebase operation, we resolved a large number of git conflicts across multiple modules. This document captures the patterns and lessons learned.

## Conflict Resolution Strategy

### 1. Bulk Resolution for Documentation Files

For documentation files (`.md`), configuration files, and test files:

```bash
# Accept all incoming changes (theirs)
for f in $(git diff --name-only --diff-filter=U); do
    git checkout --theirs "$f" && git add "$f"
done
```

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
- **Resolution**: Accept incoming (theirs) - documentation should be latest

### Pattern 2: Composer Dependencies
- **Location**: `composer.json` in module roots
- **Resolution**: Accept incoming (theirs) - dependencies must be current

### Pattern 3: Resource Files
- **Location**: `Resources/views/*.blade.php`, `Resources/assets/*`
- **Resolution**: Accept incoming (theirs) - frontend assets should be latest

## Rebase Workflow

```bash
# 1. Check for rebase status
ls -la .git/rebase-merge .git/rebase-apply

# 2. Check for unmerged files
git status --short | grep "^UU"

# 3. Resolve conflicts in batches
for f in $(git diff --name-only --diff-filter=U); do
    git checkout --theirs "$f" && git add "$f"
done

# 4. Continue rebase
git rebase --continue

# 5. If index corruption occurs
rm -f .git/index.lock .git/index
git reset --hard HEAD

# 6. Push when complete
git push origin dev
```

## Post-Rebase Verification

After resolving conflicts:

1. **Check PHPStan**: `./vendor/bin/phpstan analyse $file --level=10`
2. **Verify syntax**: `php -l $file`
3. **Check git status**: `git status --short`

## Lessons Learned

1. **Efficiency over Precision**: For 200+ files, bulk resolution is necessary
2. **Theirs Strategy**: During rebase, `--theirs` represents the commits being applied
3. **Index Corruption**: Large rebases can corrupt git index - reset and restart
4. **Documentation Priority**: Keep latest documentation, archive old versions

## Files Affected

- 200+ files across 40+ modules
- Primary conflicts in:
  - `docs/*.md` - Documentation files
  - `composer.json` - Dependency configurations
  - `Resources/views/*` - Blade templates
  - `tests/*.php` - Test files

## Date: February 2026
