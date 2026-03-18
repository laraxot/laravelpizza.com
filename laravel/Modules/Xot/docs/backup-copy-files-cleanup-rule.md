# Backup and Copy Files Cleanup Rule

> **Rule**: Backup and copy files MUST NOT exist in the repository.

**Date Established**: 2026-03-13  
**Status**: Active  
**Priority**: Critical  

---

## The Rule

**All backup and copy files MUST be:**
1. Added to `.gitignore` (both project root and module level)
2. Deleted from the filesystem

---

## Patterns to Ignore

### Project Root `.gitignore`

```gitignore
# BACKUP & ARCHIVI
*.bak
*.backup
*.backup.*
backups/
*.old
*.old1
*.old2
*_old
*.orig
*.rej
* copy.*
* copy/
*.copy
```

### Module `.gitignore` (e.g., `Modules/Xot/.gitignore`)

```gitignore
# BACKUP FILES
*.old
*.old1
*.old2
*.backup
*.backup.*
*.bak
*.bakcup
*.new
* copy.*
* copy/
*.copy
```

---

## Files Deleted (2026-03-13)

### .gitconfig copy Files

| Module | File Deleted |
|--------|-------------|
| Badge | `.gitconfig copy` |
| CertFisc | `.gitconfig copy` |
| ContoAnnuale | `.gitconfig copy` |
| Europa | `.gitconfig copy` |
| Inail | `.gitconfig copy` |
| Incentivi | `.gitconfig copy` |
| IndennitaCondizioniLavoro | `.gitconfig copy` |
| IndennitaResponsabilita | `.gitconfig copy` |
| Legge104 | `.gitconfig copy` |
| Legge109 | `.gitconfig copy` |
| Mensa | `.gitconfig copy` |
| MobilitaVolontaria | `.gitconfig copy` |
| Performance | `.gitconfig copy` |
| PresenzeAssenze | `.gitconfig copy` |
| Progressioni | `.gitconfig copy` |
| Ptv | `.gitconfig copy` |
| Questionari | `.gitconfig copy` |
| Sigma | `.gitconfig copy` |
| Sindacati | `.gitconfig copy` |

### .gitattributes copy Files

| Module | File Deleted |
|--------|-------------|
| Xot | `.gitattributes copy` |

### Other Copy Files

| Path | File Deleted |
|------|-------------|
| `docs/git/` | `git_up_noai copy.sh` |
| `docs/git-management/` | `git_up_noai copy.sh` |
| `docs/git/maintenance/` | `git_up_noai copy.sh` |
| `bashscripts/git/` | `git_up_noai copy.sh` |
| `bashscripts/git-management/` | `git_up_noai copy.sh` |

---

## Rationale

### 1. Clean Repository

Backup files clutter the repository and make it harder to find the actual source files.

### 2. Version Control Purpose

Git IS the version control system. Having `.bak`, `.old`, or `copy` files defeats the purpose of using Git.

### 3. Confusion Prevention

Multiple versions of the same file (e.g., `.gitconfig` and `.gitconfig copy`) create confusion about which one is authoritative.

### 4. Automated Tools

Backup files can interfere with:
- IDE indexing
- Static analysis tools (PHPStan, Psalm)
- Build processes
- Deployment scripts

---

## Verification

### Find Copy/Backup Files

```bash
# Find all copy files
find . -name "* copy*" -o -name "*.copy" | \
  grep -v node_modules | grep -v vendor | grep -v ".git/"

# Find all backup files
find . -name "*.bak" -o -name "*.backup" -o -name "*.old" | \
  grep -v node_modules | grep -v vendor

# Expected output: (empty - no files found)
```

### Check .gitignore Coverage

```bash
# Test if patterns are in .gitignore
grep -E "^\* copy\.|^\*\.copy|^\*\.bak|^\*\.backup|^\*\.old" .gitignore

# Expected: All patterns should match
```

---

## Exceptions

### Legitimate "copy" Files

Some files legitimately contain "copy" in their name as part of their function:

- `copy_from_last_year.php` - Translation files for copying data
- `copy_to_mono.sh` - Scripts for copying to monorepo

These are **NOT** backup files and should be kept.

### How to Distinguish

| Pattern | Keep or Delete? | Reason |
|---------|----------------|--------|
| `file.php copy` | ❌ Delete | Backup copy |
| `file copy.txt` | ❌ Delete | Backup copy |
| `copy_from_last_year.php` | ✅ Keep | Functional name |
| `copy_to_mono.sh` | ✅ Keep | Functional name |
| `file.copy.php` | ❌ Delete | Backup copy |
| `file_copy.php` | ⚠️ Review | May be intentional duplicate |

---

## Best Practices

### Instead of Creating Copy Files

1. **Use Git branches** for experimental changes
2. **Use Git tags** for version snapshots
3. **Use `git diff`** to see changes
4. **Use `git stash`** for temporary saves
5. **Use IDE local history** for quick rollbacks

### When You Need a Backup

If you absolutely must backup a file before a risky operation:

1. Add to `.gitignore` first:
   ```bash
   echo "*.backup-before-refactor" >> .gitignore
   ```

2. Create the backup outside the repository:
   ```bash
   cp ImportantFile.php ../backups/ImportantFile.php.bak
   ```

3. After the operation, delete the backup:
   ```bash
   rm ../backups/ImportantFile.php.bak
   ```

---

## Related Documentation

- [Module Directory Structure Rule](module-directory-structure-rule.md)
- [Workspace File Naming Rule](workspace-file-rule.md)
- [Git Best Practices](git-best-practices.md)

---

## Checklist for Cleanup

When cleaning up a module:

- [ ] Find all `* copy*` files
- [ ] Find all `*.copy` files
- [ ] Find all `*.bak`, `*.backup` files
- [ ] Find all `*.old`, `*_old` files
- [ ] Add patterns to `.gitignore` (root and module)
- [ ] Delete all found files
- [ ] Commit the cleanup

---

*Last updated: 2026-03-13*
