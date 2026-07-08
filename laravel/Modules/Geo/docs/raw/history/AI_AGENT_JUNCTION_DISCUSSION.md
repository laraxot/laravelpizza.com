# AI Agent Directory Junction - Coordination

**Date**: 2026-03-13  
**Status**: ✅ Implemented for Qwen  
**Agents Involved**: All AI Agents (Qwen, Gemini, Claude, Cursor, etc.)

---

## Overview

Implemented centralized AI agent directory structure with symlinks for better organization and synchronization.

## The Structure

```
bashscripts/ai/.{agent}/       # Source of truth (commands, skills, rules)
.{agent}/                       # Symlink (project root access)
laravel/.{agent}/               # Symlink (laravel access)
```

## Implementation Status

### base_ptvx_fila5 (Qwen)

| Component | Status | Path |
|-----------|--------|------|
| **Source** | ✅ Done | `bashscripts/ai/.qwen/` |
| **Root Symlink** | ✅ Done | `.qwen/` -> `bashscripts/ai/.qwen/` |
| **Laravel Symlink** | ✅ Done | `laravel/.qwen/` -> `../bashscripts/ai/.qwen/` |
| **Documentation** | ✅ Done | `bashscripts/docs/AI_AGENT_JUNCTION_RULE.md` |

### Other Bases (TODO)

| Base | Agent | Status | Action Required |
|------|-------|--------|-----------------|
| **base_fixcity_fila5** | Gemini | ⏳ TODO | Create symlinks |
| **base_fixcity_fila5** | Claude | ⏳ TODO | Create symlinks |
| **base_fixcity_fila5** | Qwen | ⏳ TODO | Create symlinks |
| **base_quaeris_fila5** | Claude | ⏳ TODO | Create symlinks |
| **base_quaeris_fila5** | Qwen | ⏳ TODO | Create symlinks |
| **base_quaeris_fila5** | Gemini | ⏳ TODO | Create symlinks |

---

## Benefits

1. **Single Source of Truth**: All AI files in `bashscripts/ai/.{agent}/`
2. **Easy Synchronization**: Update once, available everywhere
3. **Clean Structure**: No duplication, no confusion
4. **Multi-Base Pattern**: Same structure across all bases

---

## Implementation Guide

### For Other AI Agents

```bash
# Step 1: Ensure source directory exists
mkdir -p bashscripts/ai/.{agent}

# Step 2: Move existing files to source
# (if any files exist in root or laravel)
rsync -av .{agent}/ bashscripts/ai/.{agent}/
rsync -av laravel/.{agent}/ bashscripts/ai/.{agent}/

# Step 3: Create symlinks
cd /var/www/_bases/base_ptvx_fila5
rm -rf .{agent}
ln -s bashscripts/ai/.{agent} .{agent}

cd laravel
rm -rf .{agent}
ln -s ../bashscripts/ai/.{agent} .{agent}

# Step 4: Verify
ls -la .{agent}
ls -la laravel/.{agent}
cat .{agent}/some-file.md
```

### For Other Bases

```bash
# base_fixcity_fila5
cd /var/www/_bases/base_fixcity_fila5
# Already has bashscripts/ai/.qwen/
# Just create symlinks:
rm -rf .qwen && ln -s bashscripts/ai/.qwen .qwen
cd laravel && rm -rf .qwen && ln -s ../bashscripts/ai/.qwen .qwen

# base_quaeris_fila5
cd /var/www/_bases/base_quaeris_fila5
# Same process
```

---

## Verification Commands

```bash
# Check symlinks
ls -la .qwen
ls -la laravel/.qwen

# Test file access from all paths
cat .qwen/QWEN.md
cat laravel/.qwen/QWEN.md
cat bashscripts/ai/.qwen/QWEN.md
# All should show the same content

# Find broken symlinks
find . -type l -exec test ! -e {} \; -print
# Should return empty
```

---

## Documentation

| Document | Path |
|----------|------|
| **Full Rule** | `bashscripts/docs/AI_AGENT_JUNCTION_RULE.md` |
| **Implementation Report** | `bashscripts/docs/AI_AGENT_JUNCTION_REPORT.md` |
| **File Location Rules** | `docs/FILE_LOCATION_RULES.md` |
| **Agent Memory** | `AGENT_MEMORY.md` |

---

## Action Items for AI Agents

### Qwen (This Agent)

- [x] Create source directory structure
- [x] Create root symlink
- [x] Create laravel symlink
- [x] Document the rule
- [x] Update AGENT_MEMORY.md
- [x] Create GitHub discussion

### Gemini

- [x] Implement in base_ptvx_fila5
- [x] Create symlinks for `.gemini` and `.agent`
- [ ] Sync to other bases
- [x] Update documentation (AGENTS.md, GEMINI.md)

### Claude

- [ ] Implement in base_quaeris_fila5
- [ ] Create symlinks for `.claude`
- [ ] Sync to other bases
- [ ] Update documentation

### Cursor

- [ ] Implement in all bases
- [ ] Create symlinks for `.cursor`
- [ ] Document usage

---

## GitHub Issues to Create

- [ ] `AI Agent Junction - base_fixcity_fila5 Implementation`
- [ ] `AI Agent Junction - base_quaeris_fila5 Implementation`
- [ ] `AI Agent Junction - Cursor Implementation`
- [ ] `AI Agent Junction - Claude Implementation`
- [ ] `AI Agent Junction - Gemini Implementation`

---

## Related Discussions

- Script Location Rule: All `.sh` files in `bashscripts/`
- File Location Rules: Proper file placement
- Multi-Agent Coordination: Working together across bases

---

## Timeline

| Date | Milestone | Status |
|------|-----------|--------|
| 2026-03-13 | Qwen implementation (base_ptvx_fila5) | ✅ Done |
| 2026-03-14 | Other agents in base_ptvx_fila5 | ⏳ TODO |
| 2026-03-15 | All agents in base_fixcity_fila5 | ⏳ TODO |
| 2026-03-15 | All agents in base_quaeris_fila5 | ⏳ TODO |

---

## Questions for the Team

1. Should we apply this to ALL AI agents immediately, or one at a time?
2. Should we create a script to automate the symlink creation?
3. Are there any AI agents that should NOT follow this pattern?

---

**Labels**: `documentation` `convention` `ai-agents` `coordination` `infrastructure`
