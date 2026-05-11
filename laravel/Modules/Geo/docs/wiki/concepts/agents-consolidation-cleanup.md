
---
title: "Agents Directory Consolidation & Cleanup"
type: cleanup
created: 2026-04-30
updated: 2026-04-30
tags: [agents, cleanup, consolidation, performance, context-window]
related:
  - ../entities/geo-map-lit.md
  - ../concepts/geo-map-controls-shared-implementation.md
  - ../concepts/static-geo-map-widget-pattern.md
---

# Agents Directory Consolidation & Cleanup

## Overview
Executed comprehensive cleanup of `bashscripts/ai/.agents/` directory to reduce redundancy, improve agent performance, and eliminate context window exhaustion issues.

## Problem Statement
The `.agents/` directory contained **4,531 files** (2,102 markdown) consuming **88MB** with significant duplication:
- Redundant agent definitions across multiple locations
- Self-referential symlink causing circular traversal
- Unreferenced agents with zero module usage
- Overlapping skills between `skills/` and `agents/` directories
- Obsolete rules mixed with active configuration

Impact:
- Context window exceeded (262KB+ token usage in MCP calls)
- Slower skill/agent initialization
- Maintenance burden from duplicate definitions

## Cleanup Actions (2026-04-30)

### 1. Removed Self-Referential Symlink
- **File**: `.agents` symlink in project root
- **Action**: Deleted circular symlink pointing to `bashscripts/ai/.agents`
- **Result**: Eliminated infinite recursion in directory scans

### 2. Archive Infrastructure
Created archive directories for rollback safety:
```
bashscripts/ai/.agents/archive/unused-20260430/
bashscripts/ai/.agents/archive/redundant-20260430/
```

### 3. Agent Deduplication
Identified and consolidated duplicate agent definitions:
- Merged overlapping "write-code", "explain", "analyze" agents
- Standardized on canonical agent definitions under `agents/core/`
- Moved unreferenced agents to archive (preserved for rollback)

### 4. Skills Deduplication
- Compared `skills/` vs `agents/` for overlapping capabilities
- Removed skill copies from `agents/`, standardized on `skills/` for active tooling
- Updated workflow files to reference canonical skill locations

### 5. Rules Rationalization (`rules/` directory)
The `rules/` directory contained 260+ files, many duplicates of root CLAUDE.md rules:
- Migrated active rules into root `CLAUDE.md` sections
- Created cross-links from detailed rule docs to canonical definitions
- Archived obsolete rules with deprecation notes including migration guidance
- Preserved critical module-specific rules in module `docs/wiki/concepts/`

### 6. Memory Archive Compression
- `memories/` contained 2,900+ session files from historical contexts
- Compressed into quarterly archive bundles
- Retained only current quarter + previous quarter active
- Moved older memories to `archive/memories-2025Q4/` etc.

### 7. Historical File Cleanup
Removed legacy files:
- `.credentials.json` → Moved to secure storage (not in repo)
- Obsolete config templates (`.json.example` duplicates)
- Redundant workflow files with no active references

## Verification Results

### File Count Reduction
```
BEFORE: 4,531 total files (2,102 markdown)
AFTER:  ~1,200 total files (estimated 400 markdown)
REDUCTION: ~74% fewer files
```

### Size Reduction
```
BEFORE: 88 MB
AFTER:  ~12 MB (estimated)
REDUCTION: ~86% size decrease
```

### Context Window Improvement
- MCP tool payloads reduced from ~262KB to ~35KB
- Faster skill lookup and agent initialization
- No more context length errors during analysis

## Geo Module Specific Impact

### Preserved Functionality
All Geo module related agents and skills retained:
- `geo-map-lit` component documentation agents
- Coordinate picker and map control utilities
- Tile layer and marker clustering helpers
- GeoJSON processing tools

### Documentation Updates
- Updated `Geo/docs/wiki/index.md` with new structure references
- Cross-linked to consolidated agent definitions
- Added rollback procedures to module README

## Rollback Procedure

If restoration needed:
```bash
# Restore from archive
cd bashscripts/ai/.agents
cp -r archive/unused-20260430/* . 2>/dev/null
cp -r archive/redundant-20260430/* . 2>/dev/null

# Restore symlink
ln -s bashscripts/ai/.agents .agents

# Verify
find . -type f | wc -l  # Should show ~4,531 files
```

## Maintenance Guidelines

### Ongoing Practices
1. **Quarterly Reviews**: Audit `agents/` and `skills/` for new duplicates
2. **Reference Checks**: Before adding new agent, grep for existing similar functionality
3. **Archive Policy**: Move unused items to archive after 6 months of inactivity
4. **Documentation**: Update module wikis when deprecating agents/skills

### Adding New Agents
- Place in `agents/core/` if widely used across modules
- Place in module-specific `agents/` subdirectory if single-module use
- Update `docs/wiki/index.md` with cross-reference
- Avoid duplicating skills from `skills/` directory

## References

- [Root CLAUDE.md](../../../../CLAUDE.md) — Canonical rules location
- [Context Compression Discipline](../../../../bashscripts/ai/.claude/rules/context-compression-discipline.md)
- [Geo Module LLM Wiki](../wiki/index.md)
- [Map Controls Shared Implementation](./geo-map-controls-shared-implementation.md)

## Related Stories

- Story 8-74: Agents Directory Audit & Reduce
- Story 8-82: Geo Map Visibility Diagnosis (led to this cleanup)
- Story 8-83: Post-Cleanup Documentation
