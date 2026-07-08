# Multi-Agent AI Coordination Guide

> **For**: All AI Agents working on PTVX bases  
> **Date**: 2026-03-13  
> **Purpose**: Coordinate work across multiple AI agents on different codebases

---

## Project Structure

### Multiple Bases, Same Pattern

| Base | Location | AI Agent | Status |
|------|----------|----------|--------|
| **base_ptvx_fila5** | `/var/www/_bases/base_ptvx_fila5/` | Qwen | ✅ Active |
| **base_fixcity_fila5** | `/var/www/_bases/base_fixcity_fila5/` | Multiple | ✅ Active |
| **base_quaeris_fila5** | `/var/www/_bases/base_quaeris_fila5/` | Multiple | ✅ Active |

All bases follow the **same patterns and rules**.

---

## Critical Rules (All Agents Must Follow)

### 1. Script Location Rule

**ALL `.sh` scripts MUST be in `bashscripts/`, NEVER in `docs/`**

✅ Correct:
```
bashscripts/ollama-optimize.sh
bashscripts/ai/ollama-cmd.sh
bashscripts/maintenance/ollama-optimize-cpu.sh
bashscripts/docs/ollama/ollama-optimize.md (documentation)
```

❌ Wrong:
```
docs/ollama-optimize.sh
laravel/Modules/Xot/optimize.sh
```

**Documentation**: `bashscripts/docs/script-location-rule.md`

### 2. Workspace File Rule

**Each module MUST have exactly ONE `.code-workspace` file**

✅ Correct:
```
Modules/Xot/_xot.code-workspace
Modules/Activity/_activity.code-workspace
```

❌ Wrong:
```
Modules/Xot/_activity.code-workspace (wrong module)
Modules/Xot/_xot.code-workspace + Modules/Xot/_xot_backup.code-workspace (multiple)
```

**Documentation**: `docs/conventions/workspace-naming.md`

### 3. Module Directory Structure

**All source code MUST be in `app/`, NEVER in module root**

✅ Correct:
```
Modules/Xot/app/Datas/XotData.php
Modules/Xot/app/Filament/Forms/Components/
Modules/Xot/app/Services/ArrayService.php
```

❌ Wrong:
```
Modules/Xot/Datas/ (folder in root)
Modules/Xot/Filament/ (folder in root)
Modules/Xot/Services/ (folder in root)
```

**Documentation**: `laravel/Modules/Xot/docs/module-directory-structure-rule.md`

### 4. Backup/Copy Files Rule

**NEVER commit backup or copy files**

Add to `.gitignore`:
```gitignore
* copy.*
*.copy
*.bak
*.backup
*.old
*_old
```

**Documentation**: `laravel/Modules/Xot/docs/backup-copy-files-cleanup-rule.md`

---

## Script Sharing Across Bases

### When You Create a Script

1. **Place in correct location**:
   ```
   {base}/bashscripts/{category}/{script}.sh
   ```

2. **Create documentation**:
   ```
   {base}/bashscripts/docs/{category}/{script}.md
   ```

3. **Notify other bases**:
   - Create GitHub Discussion
   - Mention in commit message
   - Update this document

4. **Sync to other bases** (if useful):
   ```bash
   # Example: Copy ollama-optimize.sh to other bases
   cp base_ptvx_fila5/bashscripts/ollama-optimize.sh \
      base_fixcity_fila5/bashscripts/ollama-optimize.sh
   cp base_ptvx_fila5/bashscripts/docs/ollama/ollama-optimize.md \
      base_fixcity_fila5/bashscripts/docs/ollama/ollama-optimize.md
   ```

### Script Categories

| Category | Path | Examples |
|----------|------|----------|
| **AI** | `bashscripts/ai/` | ollama-*.sh, ai-*.sh |
| **Maintenance** | `bashscripts/maintenance/` | cleanup.sh, optimize-*.sh |
| **Backup** | `bashscripts/backup/` | daily-backup.sh, weekly-backup.sh |
| **CI/CD** | `bashscripts/ci-cd/` | deploy.sh, test.sh |
| **Database** | `bashscripts/database/` | migrate.sh, backup-db.sh |
| **Git** | `bashscripts/git/` | git-*.sh, sync.sh |
| **Documentation** | `bashscripts/docs/` | Script documentation (.md) |

---

## Communication Channels

### GitHub

- **Issues**: Track specific tasks/fixes
- **Discussions**: Coordinate across bases, share scripts
- **Pull Requests**: Review changes

### Documentation Updates

When you update a rule:

1. Update in YOUR base
2. Create GitHub Discussion
3. Mention other AI agents
4. Wait for confirmation before syncing

### Commit Messages

Use clear, descriptive messages:

```bash
# Good
feat: Add ollama optimization script for i5-8400
- Script: bashscripts/ollama-optimize.sh
- Docs: bashscripts/docs/ollama/ollama-optimize.md
- Hardware: Intel i5-8400, 30GB RAM, CPU-only
- Other bases should sync this script

# Bad
add script
```

---

## Shared Resources

### Common Scripts (Available in All Bases)

| Script | Category | Purpose | Bases |
|--------|----------|---------|-------|
| `ollama-optimize.sh` | AI | Ollama optimization | All |
| `ollama-cmd.sh` | AI | Ollama commands | All |
| `ollama-status.sh` | AI | Status check | All |
| `git_up_noai.sh` | Git | Git sync (no AI files) | All |

### Common Documentation

| Document | Location | Purpose |
|----------|----------|---------|
| Script Location Rule | `bashscripts/docs/script-location-rule.md` | Where scripts go |
| Workspace Naming | `docs/conventions/workspace-naming.md` | Module workspace files |
| Module Structure | `laravel/Modules/Xot/docs/module-directory-structure-rule.md` | Module folders |
| Backup Files | `laravel/Modules/Xot/docs/backup-copy-files-cleanup-rule.md` | No backup files |

---

## Conflict Resolution

### When Two Agents Work on Same File

1. **Check file lock** (if using file locking)
2. **Communicate** via GitHub issue/discussion
3. **Merge manually** if needed
4. **Test** after merge

### File Locking Pattern

Some bases use file locking:

```bash
# Create lock file
touch filename.lock

# Do work
# ...

# Remove lock file
rm filename.lock
```

If you see a `.lock` file, wait or contact the agent who created it.

---

## Quality Standards

### All Agents Must Ensure

- [ ] PHPStan Level 10 (no ignores)
- [ ] `declare(strict_types=1)` in all PHP files
- [ ] Short array syntax `[]` (never `array()`)
- [ ] No `property_exists()` on Eloquent models
- [ ] No constructor DI in Actions
- [ ] Scripts in `bashscripts/`, documented in `bashscripts/docs/`
- [ ] No backup/copy files committed
- [ ] One workspace file per module
- [ ] All code in `app/`, not module root

### Verification Commands

```bash
# Check script location
find . -name "*.sh" ! -path "*/bashscripts/*" ! -path "*/vendor/*"

# Check workspace files
find laravel/Modules -name "*.code-workspace" -exec dirname {} \; | sort | uniq -c | awk '$1 > 1'

# Check backup files
find . -name "* copy*" -o -name "*.copy" -o -name "*.bak" -o -name "*.old"
```

---

## Onboarding New AI Agents

### Give Them This Document

1. Read this guide
2. Read critical rules
3. Understand script location rule
4. Understand workspace naming rule
5. Understand module structure rule
6. Understand backup files rule

### Test Their Understanding

Ask them to:
1. Find where scripts should go
2. Identify violations in the codebase
3. Create a new script with documentation
4. Sync a script from another base

---

## Contact & Coordination

### GitHub Discussion

Create a discussion for major changes:

```markdown
## Major Change: {Change Name}

**Affected Bases**: All / base_ptvx_fila5 / etc.
**Scripts**: bashscripts/category/script.sh
**Docs**: bashscripts/docs/category/script.md

Other AI agents should:
- [ ] Review changes
- [ ] Sync to their base (if applicable)
- [ ] Update documentation
```

### Issue Template

```markdown
## Script/Rule Violation Found

**Location**: path/to/file.sh
**Issue**: Script in wrong location (docs/ instead of bashscripts/)
**Fix**: Moved to bashscripts/category/file.sh
**Other Bases**: Should check for same issue
```

---

## Changelog

| Date | Change | Affected Bases |
|------|--------|----------------|
| 2026-03-13 | Added script location rule | All |
| 2026-03-13 | Added workspace naming rule | All |
| 2026-03-13 | Added module structure rule | All |
| 2026-03-13 | Added backup files rule | All |

---

## See Also

- [AGENTS.md](../../AGENTS.md)
- [AGENT_MEMORY.md](../../AGENT_MEMORY.md)
- [Script Location Rule](bashscripts/docs/script-location-rule.md)
- [Workspace Naming](../../docs/conventions/workspace-naming.md)

---

*Last updated: 2026-03-13*
