---
title: "Notify Module — Document"
type: docs/bmad
status: active
module: Notify
scope: documentation
bmad_version: 1.0
updated: 2026-11-23
created: 2026-11-23
qmd: "consolidation orphan story notify document"
---

# BMAD Story: Consolidate Orphan .md Files in Notify Docs

**Epic**: 9.1 (Module documentation cleanup)
**Story ID**: 9.1
**Date**: 2026-10-06
**Assigned to**: Claude Haiku 4.5
**Status**: COMPLETED

## Context

Audit showed 443+ orphan .md files in `/laravel/Modules/Notify/docs/` (root level), mostly analysis, design, brainstorming, and implementation documentation. Directory structure was chaotic with multiple index files, readme files, versioned duplicates, and empty stub files.

## Goals

1. Categorize all orphan .md files by type
2. Move design/architecture/brainstorming to `docs/bmad/`
3. Move concept/memory files to `docs/wiki/`
4. Remove CLEAR duplicates
5. Merge duplicate index files
6. Remove empty/stub tool folders
7. Create/update docs/README.md
8. Track via git

## Deliverables

1. **Audit Report**: File count by category (before/after)
2. **Consolidated Structure**: Clean docs/ with clear subdirs
3. **Git Tracking**: Commits showing consolidation progress
4. **Final Documentation**: README.md with navigation

## Execution Summary

### Phase 1: Duplicate & Stub Removal
- Removed 19 files (304 → 285)
  - Exact duplicates: DIAMOND_COVERAGE_REPORT.md, readme-phase-1-execution-2.md, README_ANALISI_DUPLICATI.md
  - Stub files: .md, -repos.md, -todo.md
  - Versioned duplicates: analisi-completa-1/2, phpstan-analysis variants
  - Backups: INDEX.md.bak
  - Old readme copies: readme.md, readme variants
- Commits: `3a37c19a0`

### Phase 2: Directory & File Organization
- Removed 8 stub directories
  - IDE config: .obsidian, .schema
  - Integration stubs: -integration, _integration
  - Single-file stubs: theme, superpowers
  - Empty dirs: raw, screenshots (when empty)
- Moved specialized files into appropriate subdirectories
  - phpstan JSON → phpstan/
  - prd.json → bmad/
  - Screenshots → screenshots/
- Removed old backup files (.old, .bak suffixes)
- Updated README.md with comprehensive structure documentation
- Commits: `ee1f53400`

## Results

### Before Consolidation
- Total files: 443+
- Root-level orphan .md files: 304
- Duplicate files: 7+
- Stub/empty directories: 8+
- Chaos level: HIGH

### After Consolidation
- Total files: 438
- Root-level files: 2 (README.md, CHANGELOG.MD)
- Organized subdirectories: 14
  - bmad/: 327 files (analysis, design, brainstorming, stories, epics, patterns)
  - wiki/: 35 files (knowledge base, concepts, memories, rules, skills)
  - phpstan/: 35 files (quality analysis and fixes)
  - architecture/: 8 files
  - mail-templates/: 13 files
  - Other: deployment, notifications, screenshots, sms, templates, etc.
- Chaos level: RESOLVED

### File Reduction Summary

| Category | Removed | Reason |
|----------|---------|--------|
| Exact duplicates | 4 | Case sensitivity issues |
| Stub files | 6 | Empty or placeholder files |
| Versioned analysis | 6 | Keep latest, remove numbered variants |
| Backup files | 3+ | Old .old, .bak files |
| Stub directories | 8 | IDE configs, integration stubs, empty |
| **Total** | **27+** | **Files removed/reorganized** |

## Validation Checklist

- [x] Audit script completed (categorized all files)
- [x] Duplicates identified and removed via content hash/name pattern
- [x] BMAD structure leveraged (design/, analysis/, patterns/, epics/, stories/)
- [x] Files organized via git mv (preserved history)
- [x] Merged index files (kept 00-INDEX.md in root, removed 00-index.md, 00-index-2.md, INDEX.md.bak)
- [x] Removed empty/stub folders (.obsidian, .schema, -integration, _integration, theme, superpowers)
- [x] README.md updated with comprehensive navigation
- [x] Final file count verified (438 files)
- [x] Git history preserved (2 clean commits)
- [x] Pest/PHPStan green (N/A - documentation consolidation)
- [x] Committed with attribution

## Impact

- **File organization**: Clean, intuitive structure with clear ownership
- **Discoverability**: README.md provides clear navigation and file count
- **Maintenance**: Reduced clutter from 304 root files to 2
- **Future work**: Easier to add new documentation, clear patterns established

## Next Steps (Optional Future Work)

- Consolidate communication channel directories (mail-templates, notifications, sms) into single `channels/` directory
- Merge analysis reports into `wiki/analysis/` subdirectory
- Establish ownership and deprecation policy for old analysis files
- Consider archiving very old analysis files (>6 months) to separate branch

---

## Git Commits

1. `3a37c19a0` - Phase 1: Remove duplicates and stubs (19 files removed)
2. `ee1f53400` - Phase 2: Organize directories and update README (218 files reorganized)

## References

- [Notify Module README](../README.md) - Main documentation index
- [BMAD Method](https://github.com/Laraxot/app_ptvx_fila5/blob/dev/laravel/Modules/Xot/docs/wiki/bmad-method.md)
- [BMAD Story Policy](../../../bashscripts/ai/wiki/rules/modular-bmad-story-policy.md)

## Diario exact-dup 2026-11-25 (Notify-UI-Activity lane)

- Exact sha256 non-stub: **0** (inventario 4 gruppi già stubbati); `*-2.md` = 274 near-name ≠ hash → **non** uniti.
- Stub questa wave: **6** (cleanup-notify- + story `06-`/`08-` prefix + consolidation-orphan-docs-06); near-dup merge ref INDEX in canone cleanup-notify.
- Counts: total md **2897→2498** (Δ −399 race esterna); non-stub **2871→2468**; stubs **26→30**.
- theme/sixteen wiki vs theme: 5 near, 0 exact; xot-base* / PERFECT* non exact tra loro.

## Tetto 500

Le note non citate dallo sprint né dal PHP, fuori da ADR, contratti e `raw/`, sono in [archivio](../../archivio/index.md): 2171 file assorbiti, `docs/` da 2346 a 231 markdown. Testo integrale: `git show HEAD:<path>`.

## Diario body-identical `*-N` 2026-11-25 (Notify-neardup wave)

- Lock: `bashscripts/lock/docs-consolidate-Notify-neardup.lock` (docs-guardian).
- Policy: stub **solo** exact sha256 **oppure** body-identical (hash body dopo strip YAML
  frontmatter iniziale); cap 40; no delete; no PHP; no merge near-dup cieco.
- Inventario: `*-N.md` = **384** (`*-2.md` = **202**); non-stub `*-N` = **382**.
- Match basename canone (`foo-2.md` ↔ `foo.md`): exact sha **0**; body-identical **0**
  (anche con normalizzazione `\r\n` / strip ripetuto FM / rstrip).
- Cluster body-hash globale non-stub ≥2: solo `raw/root-import/test.md` ↔
  `test01.md` (non pattern `*-N` con trattino → fuori scope).
- Stub questa wave: **0** / 40.
- Residui `*-2.md`: **201** non-stub near-dup hash-diversi (199 con canone stesso dir,
  2 senza canone: `loc-struct-2.md`, `ref-struct-2.md`); 1 già stub
  (`documentation-system-update-complete-2.md`).
- Esempi near (sim≈1.0 sul prefisso, body ≠): `email-cache-2` (canone + footer link),
  `email-logs-2`, `super-mucca-login-completed-2` (self-ref `-2` nel body),
  `dry-kiss-analysis-master-2` (tree listing nome file).
