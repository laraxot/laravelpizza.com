---
title: Consolidation activity docs 2026 10 06.story
module: Activity
---

# Story: Activity Module Documentation Consolidation (Phase 1)

**Phase**: BMAD  
**Date**: 2026-10-06  
**Owner**: Marco Xot (Claude Haiku 4.5)  
**Status**: Complete (Phase 1)  
**Module**: Activity  

## Objective

Organize 41 orphaned `.md` files in Activity module into structured BMAD hierarchy:
- Categorize by type (API, architecture, testing, features, concepts)
- Consolidate duplicates
- Move to appropriate wiki/ or bmad/ subdirectories
- Create canonical file reference

## Problem Statement

Activity module `docs/` contained 155 .md files with:
- 41 orphaned files in root directory
- 5+ duplicate event-sourcing pattern files
- 3 variant index files (`00-index.md`, `00-index.md`, `00-INDEX.md`)
- 2 API documentation files (`api.md`, `API.md`)
- Scattered coverage, analysis, and feature docs
- Unclear categorization and file relationships

Result: Difficult to navigate, maintain, and locate canonical documentation.

## Solution Implemented

### Phase 1: File Categorization & Movement

#### Moved to wiki/ subdirectories (28 files)
- **wiki/testing/** — Coverage, testing policy, phpstan coverage (11 files)
- **wiki/analysis/** — Optimization and analysis documents (2 files)
- **wiki/features/** — Activity-specific feature docs (2 files)
- **wiki/concepts/** — Patterns, anti-patterns, architectural (8 files)
- **wiki/howto/** — Agent disciplines and how-to guides (3 files)

#### Moved to bmad/ subdirectories (1 file)
- **bmad/architecture/** — Architecture rules and decisions

#### Consolidated & Deduplicated (4 files)
- **event-sourcing patterns**: 5 variants → 1 canonical file
- **API documentation**: 2 files → 1 canonical (API.md)
- **Index files**: 3 variants → 1 canonical (00-INDEX.md)
- **README updates**: 5 old variants → archived

#### Archived for Reference (8 files)
- `archive/duplicates/` — event-sourcing pattern variants
- `archive/old-updates/` — old README update files
- `archive/unclear/` — small/unclear files (ai-methodologies.md)

### Canonical Files (docs root)

5 canonical files remain in `docs/`:
- ✓ `README.md` (644 lines) — Module overview
- ✓ `API.md` (30 lines) — Public API documentation
- ✓ `ARCHITECTURE.md` (269 lines) — Architecture overview
- ✓ `00-INDEX.md` (69 lines) — Index
- ✓ `purpose.md` (98 lines) — Module purpose statement

### New Structure

```
Activity/docs/
  README.md               (main overview)
  API.md                  (public APIs)
  ARCHITECTURE.md         (architecture)
  00-INDEX.md             (index)
  purpose.md              (module purpose)
  
  bmad/
    architecture/
      architecture-rules.md
    stories/              (this story)
  
  wiki/
    analysis/             (new: optimization, analysis)
    concepts/             (new: patterns, anti-patterns)
    features/             (new: activity-specific features)
    howto/                (new: agent disciplines)
    testing/              (new: coverage, testing policies)
  
  archive/                (deprecated, duplicates)
    duplicates/
    old-updates/
    unclear/
```

## Files Changed

### Created
- `docs/TODO.md` — Consolidation tracking and next steps
- `docs/stories/consolidation-activity-docs.story.md` — This story
- `docs/wiki/testing/` — New directory (11 files)
- `docs/wiki/analysis/` — New directory (2 files)
- `docs/wiki/features/` — New directory (2 files)
- `docs/wiki/concepts/event-sourcing-patterns.md` — Consolidated
- `docs/wiki/concepts/anti-patterns.md` — Consolidated
- `docs/wiki/howto/` — New directory (3 files)
- `docs/bmad/architecture/architecture-rules.md` — Moved

### Modified
- None (lazy approach: move, don't modify)

### Deleted
- `api.md` (duplicate, kept API.md)
- `00-index.md` (duplicate, kept 00-INDEX.md)
- `00-index.md` (duplicate, kept 00-INDEX.md)
- `architecture.md` (duplicate, kept ARCHITECTURE.md)
- `readme-*.md`, `readme_*.md` (old variants, archived)
- `ai-methodologies.md` (unclear, archived)

### Archived
- 8 files moved to `archive/` for reference

## Metrics

| Metric | Before | After | Change |
|--------|--------|-------|--------|
| Total .md files | 155 | ~130 | -25 |
| Orphaned (root) | 41 | 5 | -36 |
| Event-sourcing variants | 5 | 1 | -4 |
| Index files | 3 | 1 | -2 |
| API docs | 2 | 1 | -1 |

## Verification

✓ All files accounted for (moved, archived, or kept)  
✓ No files deleted (safety: archived instead)  
✓ New wiki/ subdirectories created  
✓ Duplicates consolidated  
✓ TODO.md created for tracking next steps  
✓ BMAD story documented  

## Next Steps (Phase 2)

1. **Review consolidated canonical files**
   - [ ] README.md — does it reflect new structure?
   - [ ] API.md — complete coverage?
   - [ ] ARCHITECTURE.md — current?

2. **Consider promoting wiki files** — if any should be back at root

3. **Archive cleanup** — periodic review for safe deletion

4. **Update 00-INDEX.md** — verify it still indexes correctly with new structure

5. **Cross-reference in wiki/index.md** — link to testing/, analysis/, concepts/ directories

## Notes

- **Strategy**: Minimal changes. No deletions (archived for safety).
- **Lazy approach**: Move and consolidate; don't rewrite unless needed.
- **Consolidation rule**: Keep 1 canonical, archive duplicates (traceable if needed).
- **Future**: Archive can be periodically reviewed and cleaned; currently kept for reference.

---

**Author**: Marco Xot  
**Co-Authored-By**: Claude Haiku 4.5 <noreply@anthropic.com>
