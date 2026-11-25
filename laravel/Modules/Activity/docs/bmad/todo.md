---
qmd: "activity bmad todo md"
title: Todo
module: Activity
---

# Activity Module Documentation Consolidation TODO

**Status**: Phase 1 Complete (2026-10-06)  
**Owner**: BMAD Story consolidation-activity-docs

## Summary

Consolidated 41 orphaned `.md` files in `laravel/Modules/Activity/docs/` into structured BMAD hierarchy.

## Changes Made

### Moved to wiki/ subdirectories

- **wiki/testing/** (11 files)
  - coverage-*.md (coverage analysis, status, plans, workflows)
  - testing-coverage-policy.md
  - phpstan-l10-coverage.md
  - factory-coverage-report.md

- **wiki/analysis/** (2 files)
  - analisi-ottimizzazioni.md
  - analysis-religion-zen.md

- **wiki/features/** (2 files)
  - activity-log-ui-improvements.md
  - activity-pdf-reports.md

- **wiki/concepts/** (8 files)
  - event-sourcing-patterns.md (consolidated from 5 variants)
  - anti-patterns.md (merged)
  - accessor-delegation-pattern.md
  - actions-convention.md
  - anti-pattern-model-env-hack.md
  - anti-pattern-redundant-property-override.md

- **wiki/howto/** (3 files)
  - agent-confidence-discipline.md
  - agent-confidence-protocol.md
  - agent-edit-discipline.md

### Moved to bmad/

- **bmad/architecture/** (1 file)
  - architecture-rules.md

### Consolidated

- **API docs**: Removed duplicate `api.md`, kept `api-2.md`
- **Index files**: Consolidated 3 variants (`00-index.md`, `00-index-1.md`), kept `00-INDEX.md`
- **Event-sourcing patterns**: 5 variants consolidated to 1 canonical, duplicates archived
- **README updates**: Old update variants archived to `archive/old-updates/`

### Archived (kept for reference)

- `archive/duplicates/`: Event-sourcing pattern variants
- `archive/old-updates/`: Old README update files
- `archive/unclear/`: `ai-methodologies.md` (too small, unclear purpose)

## Canonical Files (docs root)

✓ `README.md` — Module overview (644 lines)  
✓ `api-2.md` — Public API documentation (30 lines)  
✓ `architecture-3.md` — Architecture overview (269 lines)  
✓ `00-INDEX.md` — Index (69 lines)  
✓ `purpose.md` — Module purpose (98 lines)

## Structure

```
Activity/docs/
  README.md                 (main overview)
  api-2.md                    (API public)
  architecture-3.md           (architecture)
  00-INDEX.md               (index)
  purpose.md                (module purpose)
  bmad/
    architecture/
      architecture-rules.md
    brainstorming/
    epics/
    stories/                (← consolidated story goes here)
  wiki/
    analysis/               (optimization, analysis)
    concepts/               (patterns, anti-patterns, architectural)
    features/               (activity-specific features)
    howto/                  (agent disciplines, how-tos)
    testing/                (coverage, testing policies)
    ...other existing/
  archive/                  (deprecated, duplicates)
  ...other subdirs/
```

## Next Steps

1. **Review README consolidation** — `docs/README.md` may need update to reflect new structure
2. **Review api-2.md** — verify it covers all public APIs
3. **Consider promoting key wiki files** — any should be brought back to root?
4. **Archive cleanup** — periodic review of `archive/` for deletion (currently kept for safety)
5. **Story completion** — link this consolidation in BMAD story once verified

## File Count Summary

**Before**: 155 .md files across docs/ (41 orphaned in root)  
**After**: ~130 .md files (5 canonical at root, rest organized in hierarchy)  
**Reduction**: ~25 files consolidated/archived

---

**Tracked in**: laravel/Modules/Activity/docs/stories/consolidation-activity-docs.md
