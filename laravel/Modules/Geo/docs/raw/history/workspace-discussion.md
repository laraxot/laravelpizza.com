# Workspace File Naming Convention - Coordination

## Overview

This discussion coordinates the implementation of the workspace file naming convention across all modules in the PTVX Fila5 Mono repository.

## The Rule

**Every module MUST have exactly ONE `.code-workspace` file named `_<module_name_in_snake_case>.code-workspace`.**

### Examples

✅ **Correct:**
- `Modules/Xot/_xot.code-workspace`
- `Modules/Activity/_activity.code-workspace`
- `Modules/CertFisc/_cert_fisc.code-workspace`

❌ **Incorrect:**
- `Modules/Xot/_activity.code-workspace` (wrong module)
- `Modules/Job/_user.code-workspace` (wrong module)
- Multiple workspace files in one module directory

## Why This Matters

1. **Consistency**: Predictable naming across all 34+ modules
2. **Discoverability**: Developers immediately find the correct workspace file
3. **IDE Configuration**: Each module's VSCode settings are clearly identified
4. **Version Control**: No confusion about which workspace file is authoritative

## Documentation Updates

The following documentation has been updated:

| Document | Path | Status |
|----------|------|--------|
| Convention Guide | `docs/conventions/workspace-naming.md` | ✅ Created |
| Module Rule Doc | `laravel/Modules/Xot/docs/workspace-file-rule.md` | ✅ Created |
| Agent Memory | `AGENT_MEMORY.md` | ✅ Updated |
| Critical Rules | `.agents/docs/agents-guide/04-architecture/critical-rules-summary.md` | ✅ Updated |
| GEMINI.md | `GEMINI.md` | ✅ Updated |

## Cleanup Progress

### Completed

- [x] Removed `_activity.code-workspace` from `Modules/Xot/`
- [x] Removed `_activity.code-workspace` from `Modules/Job/`
- [x] Removed `_user.code-workspace` from `Modules/Job/`
- [x] Removed `_user.code-workspace` from `Modules/Badge/`
- [x] Removed `_user.code-workspace` from `Modules/CertFisc/`
- [x] Removed `_user.code-workspace` from `Modules/IndennitaCondizioniLavoro/`
- [x] Removed `_blog.code-workspace` from `Modules/Rating/`
- [x] Removed `_user.code-workspace` from `Modules/Rating/`

## Related Issue

- Issue #XX: Workspace File Naming Convention - One Module, One Workspace

## References

- [VS Code Workspaces Documentation](https://code.visualstudio.com/docs/editor/workspaces)
- [Project Structure Guide](docs/project/structure.md)
- [Coding Standards](docs/project/coding-standards.md)

---

**Labels:** `documentation` `convention` `cleanup` `coordination`
