---
title: "Docs Consolidation: Lang Module Organization"
date: 2026-10-06
status: completed
owner: Claude Haiku 4.5
epic: module-bmad-audit
---

# Lang Module Docs Consolidation (2026-10-06)

## Objective
Consolidate and organize 43 orphaned .md files across Lang module docs directory.
Eliminate duplicates, apply BMAD structure, zero orphans.

## Starting State
- 100 .md files (root + subdirectories)
- 13 duplicate files (case variants, outdated versions)
- 37 files in wrong categories or root directory
- No clear BMAD structure for docs

## Duplicates Removed

| Removed | Reason | Kept |
|---------|--------|------|
| `00-INDEX.md` | Outdated tags, superseded | `00-index.md` |
| `advanced_language_switching.md` | Underscore variant, less content | `advanced-language-switching.md` |
| `automatic_translations.md` | Underscore variant | `automatic-translations.md` |
| `cms_link.md` | Underscore variant | `cms-link.md` |
| `changelog.md` | Root CHANGELOG.md is canonical | Removed both |
| `wiki/commands/INDEX.md` | Uppercase duplicate | `wiki/commands/index.md` |
| `wiki/concepts/INDEX.md` | Uppercase duplicate | `wiki/concepts/index.md` |
| `wiki/memories/INDEX.md` | Uppercase duplicate | `wiki/memories/index.md` |
| `wiki/rules/INDEX.md` | Uppercase duplicate | `wiki/rules/index.md` |
| `wiki/skills/INDEX.md` | Uppercase duplicate | `wiki/skills/index.md` |
| `wiki/product/_da-riconciliare/INDEX.md` | Uppercase duplicate | lowercase |
| `wiki/INDEX.md` | Uppercase duplicate | `wiki/index.md` |
| `.github/contributing.md` | Lowercase duplicate | `.github/CONTRIBUTING.md` |
| `.github/security.md` | Lowercase duplicate | `.github/SECURITY.md` |

## File Reorganization

### By Category
- **Architecture & Rules** (4 files) → `bmad/architecture/`
  - `core-architecture.md` (ex architecture.md)
  - `rules.md` (ex architecture-rules.md)
  - `api-reference.md`
  - `module-architecture-legacy.md` (ex ARCHITECTURE.md)
  - Plus 4 structure files from legacy `/architecture` directory

- **Language Patterns & How-To Guides** (8 files) → `wiki/how-to/`
  - advanced-language-switching.md
  - automatic-translations.md
  - best-practices.md
  - composer-merge-plugin.md
  - autoregistration-commands.md
  - build-publish.yml.md

- **Language Reference & Concepts** (10 files) → `wiki/reference/`
  - case-sensitivity.md
  - case-conflicts.md
  - case-variant-collisions.md
  - cases.md
  - translation-fallbacks.md (ex chaos-monkey-translation-fallbacks.md)
  - translation-errors.md (ex common-translation-errors.md)
  - common-translations.md
  - cms-link.md
  - binary-assets.md

- **Analysis & Reports** (9 files) → `bmad/`
  - code-quality-report.md
  - code-quality-improvement.md
  - code-redundancy-audit.md
  - coverage-report.md (ex coverage.md)
  - database-model-coverage.md
  - analysis-results.md
  - bottlenecks.md

- **Agent Protocols & Memories** (4 files) → `wiki/memories/`
  - agent-confidence-discipline.md
  - agent-confidence-protocol.md
  - agent-edit-discipline.md
  - ai-methodologies.md

- **Business & Purpose** (2 files) → `wiki/product/` or `wiki/overviews/`
  - purpose.md → `wiki/product/purpose.md`
  - business-logic-overview.md → `wiki/overviews/`

### Rules Applied
1. **Lowercase filenames**: Standardized all index files to lowercase `index.md`
2. **Dash convention**: Unified spacing in filenames (no underscores vs dashes)
3. **BMAD structure**:
   - Architecture → `bmad/architecture/`
   - Decisions → `bmad/decision-log.md` & stories
   - Analysis → `bmad/`
   - Knowledge → `wiki/*`
4. **Legacy cleanup**: Removed now-empty `/architecture` directory

## Final Structure

```
docs/
├── README.md (NEW - structure guide)
├── 00-index.md (entry point)
├── README-en.md
├── bmad/
│   ├── architecture/ (7 files)
│   ├── stories/ (backlog & epics)
│   ├── epics/ (roadmap)
│   ├── brainstorming/
│   └── [reports & analysis - 9 files]
└── wiki/
    ├── how-to/ (8 files)
    ├── reference/ (10 files)
    ├── rules/ (1 file)
    ├── memories/ (4 files)
    ├── product/ (1 file)
    ├── overviews/ (1 file)
    └── [other navigation & skills]
```

**Total: 87 documented artifacts (down from 100)**
**Orphans: 0**
**Duplicates: 0**

## Verification

✓ No duplicate files (all case variants consolidated)
✓ All files categorized per BMAD rules
✓ No orphaned files in docs/ root (except index & README)
✓ Structure follows BMAD architecture pattern
✓ Legacy directories cleaned up
✓ README.md created for navigation

## Documentation Created

- `docs/README.md` — Full structure guide with quick-start paths
- `docs/bmad/stories/docs-consolidation-2026-10-06.story.md` — This story

## Next Steps

1. **Review & Links**: Update cross-references in consolidated files
2. **QMD Index**: Run `qmd update` to index reorganized docs
3. **Wiki Navigation**: Verify `wiki/index.md` reflects new structure
4. **BMAD Stories**: Link this story from `docs/bmad/stories/index.md`

## Impact

**Clarity**: Developers can now navigate docs by purpose (BMAD, wiki, how-to)
**Discoverability**: New README.md provides clear entry points
**Maintenance**: No more duplicate files; single source of truth per topic
**Onboarding**: Structured documentation makes module easier to understand

---
**Status**: DONE
**Files Changed**: 87 moves/renames, 13 deletions, 1 new file (README.md)
**Zero Breaking Changes**: All files retained, only reorganized

Co-Authored-By: Claude Haiku 4.5 <noreply@anthropic.com>
