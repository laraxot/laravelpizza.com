# File Location Rules

> **Rule**: Every file type has a specific location. Never place files in the project root.

**Date Established**: 2026-03-13  
**Status**: Active  
**Priority**: Critical  

---

## Project Root Rules

### ✅ Files Allowed in Root

Only these files are allowed in the project root:

| File Pattern | Examples | Purpose |
|--------------|----------|---------|
| **Config Files** | `.editorconfig`, `.gitattributes`, `.gitignore` | Project configuration |
| **AI Agent Files** | `AGENTS.md`, `AGENT_MEMORY.md`, `GEMINI.md`, `CLAUDE.md` | AI instructions |
| **README** | `README.md` | Project documentation |
| **Workspace Files** | `*_ptvx_fila5.code-workspace` | Project-level VSCode workspace |
| **Package Files** | `composer.json`, `package.json` | Dependencies (if monorepo root) |
| **License** | `LICENSE`, `LICENSE.md` | Licensing |

### ❌ Files NOT Allowed in Root

| File Type | Wrong Location | Correct Location |
|-----------|----------------|------------------|
| **Scripts** | `script.sh` | `bashscripts/category/script.sh` |
| **Documentation** | `discussion.md` | `docs/discussion.md` |
| **Reports** | `report.md` | `docs/reports/report.md` |
| **Module Workspaces** | `_xot.code-workspace` | `Modules/Xot/_xot.code-workspace` |
| **Backup Files** | `README.md.backup` | (delete it) |
| **Logs** | `access.log` | `storage/logs/` |
| **Temp Files** | `data]`, `coverage` | (delete or move to `storage/`) |

---

## Documentation Files

### All `.md` Files Go in `docs/`

**Exception**: `README.md`, `CHANGELOG.md`, `LICENSE.md` can be in root.

| Type | Wrong | Correct |
|------|-------|---------|
| Discussion | `workspace-discussion.md` ❌ | `docs/workspace-discussion.md` ✅ |
| Report | `report.md` ❌ | `docs/reports/report.md` ✅ |
| Guide | `guide.md` ❌ | `docs/guide.md` ✅ |
| Plan | `plan.md` ❌ | `docs/plan.md` ✅ |

### Module Documentation

Module-specific docs go in the module:

```
Modules/Xot/docs/  ✅
Modules/Activity/docs/  ✅
```

NOT in root `docs/`:

```
docs/xot/  ❌ (unless it's cross-module)
```

---

## Script Files

### All `.sh` Files Go in `bashscripts/`

| Type | Wrong | Correct |
|------|-------|---------|
| Ollama | `docs/ollama-optimize.sh` ❌ | `bashscripts/ollama-optimize.sh` ✅ |
| Git | `docs/git/git_up.sh` ❌ | `bashscripts/git/git_up.sh` ✅ |
| PHPStan | `docs/phpstan_analyze.sh` ❌ | `bashscripts/phpstan/phpstan_analyze.sh` ✅ |
| Maintenance | `docs/backup.sh` ❌ | `bashscripts/maintenance/backup.sh` ✅ |

**Documentation**: `bashscripts/docs/script-location-rule.md`

---

## Workspace Files

### Project vs Module Workspaces

| Type | Location | Example |
|------|----------|---------|
| **Project Workspace** | Root | `_ptvx_fila5.code-workspace` ✅ |
| **Module Workspace** | Module root | `Modules/Xot/_xot.code-workspace` ✅ |
| **Wrong Module Workspace** | Project root | `_xot.code-workspace` ❌ |

**Rule**: Module workspaces MUST be in their respective module directories.

**Documentation**: `docs/conventions/workspace-naming.md`

---

## Backup Files

### NEVER Commit Backup Files

| Pattern | Action |
|---------|--------|
| `*.backup` | ❌ Delete |
| `*.bak` | ❌ Delete |
| `*.old` | ❌ Delete |
| `* copy.*` | ❌ Delete |
| `*.copy` | ❌ Delete |

**Already in `.gitignore`**:
```gitignore
*.bak
*.backup
*.old
* copy.*
*.copy
```

**Documentation**: `laravel/Modules/Xot/docs/backup-copy-files-cleanup-rule.md`

---

## Log Files

### Logs Go in `storage/logs/`

| Wrong | Correct |
|-------|---------|
| `access.log` ❌ | `storage/logs/access.log` ✅ |
| `error.log` ❌ | `storage/logs/error.log` ✅ |
| `laravel/error.log` ❌ | `laravel/storage/logs/error.log` ✅ |

---

## AI Agent Directories

### Centralized in `bashscripts/ai/`

All AI agent directories (`.qwen`, `.cursor`, `.claude`, etc.) MUST be:

1. **Stored in**: `bashscripts/ai/.{agent}/`
2. **Symlinked from**: `.{agent}/` and `laravel/.{agent}/`

| Agent | Source | Symlinks |
|-------|--------|----------|
| **Qwen** | `bashscripts/ai/.qwen/` | `.qwen/`, `laravel/.qwen/` |
| **Cursor** | `bashscripts/ai/.cursor/` | `.cursor/`, `laravel/.cursor/` |
| **Claude** | `bashscripts/ai/.claude/` | `.claude/`, `laravel/.claude/` |

**Documentation**: `bashscripts/docs/AI_AGENT_JUNCTION_RULE.md`

### Delete or Move to `storage/`

| File | Action |
|------|--------|
| `data]` | Delete (looks like typo) |
| `coverage` | Move to `storage/coverage/` or delete |
| `ETA` | Delete or move to `docs/` |

---

## Cleanup Checklist

Run this to find violations:

```bash
# Find .sh files in root
find . -maxdepth 1 -name "*.sh" -type f

# Find .md files in root (except allowed ones)
find . -maxdepth 1 -name "*.md" -type f ! -name "README.md" ! -name "CHANGELOG.md" ! -name "LICENSE*" ! -name "AGENTS*" ! -name "AGENT_MEMORY*" ! -name "GEMINI*" ! -name "CLAUDE*"

# Find backup files
find . -maxdepth 1 \( -name "*.backup" -o -name "*.bak" -o -name "*.old" -o -name "* copy*" \)

# Find workspace files in root (should only be project workspaces)
find . -maxdepth 1 -name "_*.code-workspace" | grep -v "_ptvx\|_base"
```

---

## Current Violations in This Project

Based on `ls -la` output:

| File | Type | Action Required |
|------|------|-----------------|
| `README.md.backup` | Backup | ❌ Delete |
| `access.log` | Log | ❌ Delete or move to `storage/logs/` |
| `data]` | Temp/Typo | ❌ Delete |
| `coverage` | Temp | ❌ Delete or move |
| `ETA` | Doc | ⚠️ Move to `docs/` or delete |
| `_base_ptvx_fila5_mono.code-workspace` | Workspace | ⚠️ Verify if needed |
| `_base_ptvx_fila5_mono_1.code-workspace` | Workspace | ⚠️ Verify if needed |

---

## Multi-Agent Coordination

### For All AI Agents

When you create a file:

1. **Ask**: What type is this?
   - Script (`.sh`) → `bashscripts/`
   - Documentation (`.md`) → `docs/`
   - Config → Root (if allowed)
   - Log → `storage/logs/`

2. **Check**: Does it already exist?
   - Don't create duplicates
   - Update existing files

3. **Document**: Create docs for scripts
   - Script: `bashscripts/category/script.sh`
   - Docs: `bashscripts/docs/category/script.md`

4. **Notify**: Tell other agents
   - GitHub Discussion
   - Clear commit messages

---

## Related Documentation

- [Script Location Rule](bashscripts/docs/script-location-rule.md)
- [Workspace Naming](docs/conventions/workspace-naming.md)
- [Backup Files Cleanup](laravel/Modules/Xot/docs/backup-copy-files-cleanup-rule.md)
- [Module Directory Structure](laravel/Modules/Xot/docs/module-directory-structure-rule.md)
- [Multi-Agent Coordination](docs/MULTI_AGENT_COORDINATION.md)

---

*Last updated: 2026-03-13*
