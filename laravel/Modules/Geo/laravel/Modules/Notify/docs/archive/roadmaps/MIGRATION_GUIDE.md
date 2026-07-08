# 📍 Roadmap Migration Guide

> **How to find documents that were moved during consolidation**

When the 355+ scattered roadmap files were consolidated into a central hub, old roadmap files were archived to preserve history. This guide helps you locate old documents in their new locations.

---

## Quick Lookup by Old Location

### Master Roadmap Files

| Old Location | New Location | Status |
|--------------|--------------|--------|
| `/docs/MASTER_ROADMAP.md` | `/docs/ROADMAP.md` | ✅ ARCHIVED |
| `/docs/MASTER_ROADMAP_2025.md` | `/docs/ROADMAP.md` | ✅ ARCHIVED |
| `/docs/PROJECT-ROADMAP.md` | `/docs/ROADMAP.md` | ✅ ARCHIVED |
| `/docs/PROJECT_ROADMAP.md` | `/docs/ROADMAP.md` | ✅ ARCHIVED |
| `/docs/roadmap.md` | `/docs/ROADMAP.md` | ✅ ARCHIVED |
| `/docs/roadmap_project.md` | `/docs/ROADMAP.md` | ✅ ARCHIVED |

**Archive Location**: `/docs/archive/roadmaps/legacy-master-roadmaps/`

---

### Module Roadmaps

All module-specific roadmaps remain in their module directories but are listed in the central hub.

#### Activity Module
| Old File | Path | Status |
|----------|------|--------|
| `product-roadmap.md` | `/laravel/Modules/Activity/docs/` | ✅ REFERENCED |
| `PRODUCT_ROADMAP.md` | `/laravel/Modules/Activity/docs/` | ✅ REFERENCED |
| `roadmap-2025.md` | `/laravel/Modules/Activity/docs/` | ✅ REFERENCED |
| `stabilization-roadmap.md` | `/laravel/Modules/Activity/docs/` | ✅ REFERENCED |
| `phpstan-roadmap.md` | `/laravel/Modules/Activity/docs/` | ✅ REFERENCED |

**Archive**: `/docs/archive/roadmaps/module-roadmaps/Activity/`

#### User Module
| Old File | Path | Status |
|----------|------|--------|
| `product-roadmap.md` | `/laravel/Modules/User/docs/` | ✅ REFERENCED |
| `roadmap-1-1.md` | `/laravel/Modules/User/docs/` | ✅ REFERENCED |
| `2025-q4-roadmap.md` | `/laravel/Modules/User/docs/roadmap/` | ✅ REFERENCED |

**Archive**: `/docs/archive/roadmaps/module-roadmaps/User/`

---

### Planning Documents (GSD Phases)

All GSD phase planning documents remain in `.planning/phases/` and are indexed in the central ROADMAP.

| Phase | Location | Status |
|-------|----------|--------|
| Phase 5-6 | `/planning/phases/05-create-tests-blocks/` | ✅ REFERENCED |
| Phase 6 | `/planning/phases/06-create-universal-blocks/` | ✅ REFERENCED |
| Phase 12 | `/planning/phases/12-design-comuni-pages/` | ✅ REFERENCED |
| Phase 13 | `/planning/phases/13-homepage-html-parity/` | ✅ REFERENCED |

**Archive Index**: `/docs/archive/roadmaps/phase-planning/PHASES.md`

---

## Archive Directory Structure

```
docs/archive/roadmaps/
├── MIGRATION_GUIDE.md (THIS FILE)
├── MANIFEST.md - Complete inventory of archived files
├── ANALYSIS.md - Consolidation analysis findings
├── legacy-master-roadmaps/
│   ├── MASTER_ROADMAP.md (original)
│   ├── MASTER_ROADMAP_2025.md
│   ├── PROJECT-ROADMAP.md
│   ├── PROJECT_ROADMAP.md
│   ├── roadmap.md
│   └── roadmap_project.md
├── module-roadmaps/
│   ├── Activity/
│   │   ├── product-roadmap.md
│   │   ├── PRODUCT_ROADMAP.md
│   │   ├── roadmap-2025.md
│   │   ├── stabilization-roadmap.md
│   │   ├── phpstan-roadmap.md
│   │   └── ... (50+ files)
│   └── User/
│       ├── product-roadmap.md
│       ├── roadmap-1-1.md
│       ├── 2025-q4-roadmap.md
│       └── ... (legacy/ subdirectory)
└── phase-planning/
    ├── PHASES.md - Index of GSD phases
    ├── 05-create-tests-blocks/
    ├── 06-create-universal-blocks/
    ├── 12-design-comuni-pages/
    └── 13-homepage-html-parity/
```

---

## Why Documents Were Archived

During the **Phase 11: Documentation Consolidation** project, we identified:

- ✅ **50+ duplicate roadmaps** across modules
- ✅ **355+ scattered planning files** with no unified entry point
- ✅ **Multiple versions** of the same roadmap (v1, v2, conflict versions)
- ✅ **Legacy files** marked as "legacy" but never cleaned up
- ✅ **Module-specific plans** not linked from central hub

**Solution**: Create a unified central hub at `/docs/ROADMAP.md` while preserving full history.

---

## Searching for Old Content

### By Module
If you're looking for a specific module's roadmap:
1. Go to `/docs/ROADMAP.md`
2. Find section: **"📚 Module-Specific Roadmaps"**
3. Click the module link (e.g., "User Module")

### By Phase
If you're looking for a specific phase:
1. Go to `/docs/ROADMAP.md`
2. Scroll to: **"✅ Completed Phases"** or **"📅 Upcoming Phases"**
3. Find the phase number you need

### By Date/Timeline
If you remember approximately when it was created:
1. Check `/docs/ROADMAP.md` timeline visualization
2. Or search in archived files by date

### All Files in Archive
See complete inventory: `/docs/archive/roadmaps/MANIFEST.md`

---

## Broken Link Fixes

If you have a URL referencing an old roadmap file:

**Old Format**: `/docs/MASTER_ROADMAP.md`  
→ **New Format**: `/docs/ROADMAP.md` + specific phase section

**Old Format**: `/laravel/Modules/Activity/docs/product-roadmap.md`  
→ **New Format**: Same location (still there!) + linked from `/docs/ROADMAP.md`

---

## Contributing Updates

When updating roadmap information:

1. **For central phases 1-15+**: Update `/docs/ROADMAP.md`
2. **For module-specific details**: Update module doc (stays in place)
3. **Do NOT edit archived files** - they're for history only
4. **Link from central hub** - cross-reference modules from `/docs/ROADMAP.md`

---

## Timeline of Changes

| Date | Action | Files |
|------|--------|-------|
| Mar 2026 | Analysis: Identified 50+ duplicate roadmaps | `/docs/archive/roadmaps/ANALYSIS.md` |
| Apr 3 2026 | **CONSOLIDATION**: Created central ROADMAP.md | `/docs/ROADMAP.md` |
| Apr 3 2026 | Archived old master roadmaps | 6 files moved |
| Apr 3 2026 | Created migration guide | THIS FILE |
| Apr 3 2026 | Created archive manifest | `/docs/archive/roadmaps/MANIFEST.md` |
| Pending | Wave 3: Link verification | Next phase |
| Pending | Wave 4: Final cleanup | After verification |

---

## Support

- **Can't find a specific file?** → Check [MANIFEST.md](./MANIFEST.md)
- **Need the full archive contents?** → List: `/docs/archive/roadmaps/`
- **Questions about phases?** → See `/docs/ROADMAP.md`
- **Module documentation?** → Check module directories

---

**Archive Created**: April 3, 2026  
**Consolidation Status**: ✅ Phase 11 Wave 2 In Progress  
**Next Update**: After link verification (Wave 3)
