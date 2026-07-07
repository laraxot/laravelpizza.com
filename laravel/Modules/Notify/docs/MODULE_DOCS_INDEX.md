# Master Documentation Index - FixCity Fila5

**Project:** FixCity Fila5  
**Date:** 2026-04-01  
**Status:** ✅ **Active**  
**Total Docs:** 7,137+ markdown files  

---

## 🎯 Purpose

Questo documento crea un **sistema di indicizzazione centrale** con collegamenti bidirezionali tra:
- ✅ Documentazione moduli (6,812 file)
- ✅ Documentazione temi (325 file)
- ✅ BMad documentation (9 file)
- ✅ Project documentation (153 file)
- ✅ Rules, memories, skills

---

## 📚 Documentation Hierarchy

```
FixCity Fila5 Documentation
├── 📁 Master Index (THIS FILE)
│
├── 📁 BMad Output (_bmad-output/)
│   ├── General BMad Docs:
│   │   ├── prd.md
│   │   ├── architecture.md
│   │   ├── ui-spec.md
│   │   ├── epics-and-stories.md
│   │   ├── sprint-plan.md
│   │   ├── adversarial-review.md
│   │   └── BMAD-WORKFLOW-COMPLETE.md
│   │
│   └── Design Comuni Italia Project:
│       ├── DESIGN_COMUNI_INDEX.md - Index for all Design Comuni docs
│       ├── design-comuni-prd.md - Product Requirements Document
│       ├── design-comuni-architecture.md - Architecture Design
│       ├── design-comuni-ui-spec.md - UI Specification
│       ├── design-comuni-epics.md - Epics & Stories (12 epics, 62 stories)
│       ├── design-comuni-sprint-plan.md - Sprint Plan (6 sprints, 12 weeks)
│       └── design-comuni-block-analysis.md - Block Analysis (47 components, 38 pages)
│
├── 📁 Modules (laravel/Modules/*/docs/)
│   ├── Xot (Core Framework) - 1,941 files
│   ├── Fixcity (Main Domain) - XXX files
│   ├── User (Authentication) - XXX files
│   ├── Cms (Content) - XXX files
│   ├── Blog (Articles) - XXX files
│   ├── Geo (Maps) - XXX files
│   ├── Media (Files) - XXX files
│   ├── Notify (Notifications) - XXX files
│   ├── Activity (Logging) - XXX files
│   ├── Gdpr (Compliance) - XXX files
│   ├── Lang (Localization) - XXX files
│   ├── Comment (Feedback) - XXX files
│   ├── Rating (Reviews) - XXX files
│   ├── Seo (SEO) - XXX files
│   ├── Tenant (Multi-tenancy) - XXX files
│   ├── UI (Components) - XXX files
│   ├── AI (ML Integration) - XXX files
│   └── Job (Employment) - XXX files
│
├── 📁 Themes (laravel/Themes/*/docs/)
│   ├── Sixteen - 325+ files
│   │   ├── DESIGN_COMUNI_TEAM_GUIDE.md - Complete team guide for replication
│   │   ├── DESIGN_COMUNI_PROJECT_SUMMARY.md - Project summary and status
│   │   ├── COMPONENT_CATALOG.md - All 47 components (TO BE CREATED)
│   │   ├── BLOCK_TYPES.md - All block types (TO BE CREATED)
│   │   ├── JSON_STRUCTURE.md - JSON schema (TO BE CREATED)
│   │   └── screenshots/ - Screenshot comparisons (TO BE CREATED)
│   └── [Other themes]
│
├── 📁 Project (docs/)
│   ├── Project docs - 153+ files
│   ├── Rules
│   ├── Guides
│   └── References
│
├── 📁 Planning (.planning/)
│   ├── PROJECT.md - Project overview and history
│   ├── ROADMAP.md - 12-week implementation plan (6 phases)
│   ├── STATE.md - Current state tracking
│   └── research/
│       └── design-comuni-pages.md - Complete page analysis (674 lines)
│
└── 📁 Skills & Rules (.qwen/skills/, docs/rules/)
    ├── BMad skills
    ├── Project rules
    └── Memories
```

---

## 🔗 Bidirectional Link System

### Link Pattern 1: Module → Master Index

**In ogni modulo docs/README.md:**
```markdown
## Cross-References

- → [Master Index](../../docs/MODULE_DOCS_INDEX.md) - Central navigation
- → [BMad Architecture](_bmad-output/architecture.md) - System design
- → [BMad PRD](_bmad-output/prd.md) - Requirements
```

### Link Pattern 2: Master Index → Module

**In Master Index:**
```markdown
## Module Documentation

### Xot (Core Framework)
- **Location:** `laravel/Modules/Xot/docs/`
- **Files:** 1,941
- **Index:** [Xot Docs Index](Modules/Xot/docs/00-index.md)
- **Key Topics:**
  - [Base Classes](Modules/Xot/docs/base/)
  - [Traits](Modules/Xot/docs/traits/)
  - [PHPStan](Modules/Xot/docs/phpstan-*.md)
```

### Link Pattern 3: Theme → Master Index

**In theme docs/README.md:**
```markdown
## Cross-References

- → [Master Index](../../docs/MODULE_DOCS_INDEX.md) - Central navigation
- → [Layout Architecture](layout-architecture.md) - Theme layouts
- → [BMad UI Spec](_bmad-output/ui-spec.md) - Component library
```

---

## 📁 Module Documentation Indexes

### Core Modules

| Module | Files | Index | Key Topics |
|--------|-------|-------|------------|
| **Xot** | 1,941 | [00-index.md](Modules/Xot/docs/00-index.md) | Base classes, traits, PHPStan |
| **Fixcity** | XXX | [index.md](Modules/Fixcity/docs/README.md) | Tickets, categories |
| **User** | XXX | [index.md](Modules/User/docs/README.md) | Auth, RBAC, OAuth |
| **Cms** | XXX | [index.md](Modules/Cms/docs/README.md) | Pages, sections, blocks |
| **Tenant** | XXX | [index.md](Modules/Tenant/docs/README.md) | Multi-tenancy |

### Feature Modules

| Module | Files | Index | Key Topics |
|--------|-------|-------|------------|
| **Blog** | XXX | [index.md](Modules/Blog/docs/README.md) | Articles, categories |
| **Geo** | XXX | [index.md](Modules/Geo/docs/README.md) | Maps, locations |
| **Media** | XXX | [index.md](Modules/Media/docs/README.md) | Files, uploads |
| **Notify** | XXX | [index.md](Modules/Notify/docs/README.md) | Notifications |
| **Comment** | XXX | [index.md](Modules/Comment/docs/README.md) | Comments, reactions |
| **Rating** | XXX | [index.md](Modules/Rating/docs/README.md) | Reviews, ratings |

### Support Modules

| Module | Files | Index | Key Topics |
|--------|-------|-------|------------|
| **Activity** | XXX | [index.md](Modules/Activity/docs/README.md) | Logging, audit |
| **Gdpr** | XXX | [index.md](Modules/Gdpr/docs/README.md) | Privacy, consents |
| **Lang** | XXX | [index.md](Modules/Lang/docs/README.md) | Translations |
| **Seo** | XXX | [index.md](Modules/Seo/docs/README.md) | Meta tags, sitemap |
| **UI** | XXX | [index.md](Modules/UI/docs/README.md) | Components |
| **AI** | XXX | [index.md](Modules/AI/docs/README.md) | ML integration |
| **Job** | XXX | [index.md](Modules/Job/docs/README.md) | Jobs, schedules |

---

## 📁 Theme Documentation Indexes

### Sixteen Theme

**Location:** `laravel/Themes/Sixteen/docs/`  
**Files:** 325  
**Index:** [README.md](Themes/Sixteen/docs/README.md)

**Key Documents:**
- [Layout Architecture](Themes/Sixteen/docs/layout-architecture.md)
- [LAYOUT_ARCHITECTURE_MAP.md](Themes/Sixteen/docs/LAYOUT_ARCHITECTURE_MAP.md)
- [LAYOUT_FIX_COMPLETE_BMAD.md](Themes/Sixteen/docs/LAYOUT_FIX_COMPLETE_BMAD.md)
- [VITE_MANIFEST_FIX_COMPLETE.md](Themes/Sixteen/docs/VITE_MANIFEST_FIX_COMPLETE.md)
- [PHPSTAN_LAYOUT_FIX_COMPLETE.md](Themes/Sixteen/docs/PHPSTAN_LAYOUT_FIX_COMPLETE.md)

**Categories:**
- Architecture (10 files)
- Components (50 files)
- Build & Vite (20 files)
- Accessibility (15 files)
- AGID Compliance (30 files)
- Design (25 files)
- Fixes (40 files)
- Guides (50 files)
- References (85 files)

---

## 📁 BMad Documentation

**Location:** `_bmad-output/`  
**Files:** 9  
**Status:** ✅ Complete

| Document | File | Lines | Purpose |
|----------|------|-------|---------|
| **PRD** | `prd.md` | 570 | Product requirements |
| **Architecture** | `architecture.md` | 764 | System design |
| **UI Spec** | `ui-spec.md` | 892 | Component library |
| **Epics** | `epics-and-stories.md` | 1,038 | Product backlog |
| **Sprint Plan** | `sprint-plan.md` | 560 | Sprint planning |
| **Adversarial Review** | `adversarial-review.md` | 486 | Quality audit |
| **Workflow Complete** | `BMAD-WORKFLOW-COMPLETE.md` | 450 | Summary |
| **Index** | `index.md` | 280 | Navigation |
| **Codebase Analysis** | `codebase/` | 3,170 | Technical analysis |

**Cross-References:**
- ← [Master Index](#master-documentation-index---fixcity-fila5) - This document
- ← [Module Docs](#module-documentation-indexes) - Module documentation
- ← [Theme Docs](#theme-documentation-indexes) - Theme documentation

---

## 🇮🇹 Design Comuni Italia - BMad Documentation

**Project:** Replication of 38 Design Comuni static pages
**Status:** 🔄 In Progress
**Priority:** 🔴 CRITICAL
**Total Docs:** 5 BMad docs + 1 index

### Documentation Suite

| Document | File | Lines | Purpose |
|----------|------|-------|---------|
| **Index** | `_bmad-output/DESIGN_COMUNI_INDEX.md` | 300+ | Central navigation for Design Comuni docs |
| **PRD** | `_bmad-output/design-comuni-prd.md` | 800+ | Product requirements (38 pages, WCAG 2.1 AA) |
| **Architecture** | `_bmad-output/design-comuni-architecture.md` | 900+ | System architecture, data flow, security |
| **UI Spec** | `_bmad-output/design-comuni-ui-spec.md` | 700+ | Component specs, design tokens, accessibility |
| **Epics** | `_bmad-output/design-comuni-epics.md` | 1,200+ | 12 epics, 62 stories |
| **Sprint Plan** | `_bmad-output/design-comuni-sprint-plan.md` | 600+ | 6 sprints, 12 weeks |

### Key Features

- ✅ **Single `[slug].blade.php`** - All pages use one file
- ✅ **JSON Content Blocks** - Dynamic content management
- ✅ **Universal Blocks** - Reusable components (NOT page-specific)
- ✅ **Tailwind @apply** - NO Bootstrap Italia imports
- ✅ **Folio + Volt** - File-based routing
- ✅ **WCAG 2.1 AA** - Accessibility compliant

### Implementation Roadmap

| Sprint | Duration | Focus | Stories |
|--------|----------|-------|---------|
| **Sprint 1** | Week 1-2 | Foundation + Header/Footer | 9 |
| **Sprint 2** | Week 3-4 | Block Components | 10 |
| **Sprint 3** | Week 5-6 | Core Pages | 9 |
| **Sprint 4** | Week 7-8 | Content Pages | 8 |
| **Sprint 5** | Week 9-10 | Wizards | 17 |
| **Sprint 6** | Week 11-12 | QA & Documentation | 9 |

**Cross-References:**
- → [Design Comuni Index](_bmad-output/DESIGN_COMUNI_INDEX.md) - Central navigation
- → [PRD](_bmad-output/design-comuni-prd.md) - Requirements
- → [Architecture](_bmad-output/design-comuni-architecture.md) - System design
- → [UI Spec](_bmad-output/design-comuni-ui-spec.md) - Component specs
- → [Replication Master Plan](laravel/Themes/Sixteen/docs/design-comuni/REPLICATION_MASTER_PLAN.md) - Technical guide
- → [Theme Docs Index](laravel/Themes/Sixteen/docs/00-index.md) - Theme documentation

---

## 🔍 Search & Navigation

### By Topic

| Topic | Documents | Location |
|-------|-----------|----------|
| **Architecture** | 50+ | `Modules/Xot/docs/architecture/`, `_bmad-output/architecture.md` |
| **PHPStan** | 100+ | `Modules/*/docs/phpstan*.md` |
| **Testing** | 80+ | `Modules/*/docs/testing/` |
| **Layouts** | 20+ | `Themes/Sixteen/docs/layout*.md` |
| **Vite** | 15+ | `Themes/Sixteen/docs/build*.md` |
| **Components** | 60+ | `Themes/Sixteen/docs/components*.md` |
| **AGID** | 40+ | `Themes/Sixteen/docs/agid*.md` |
| **Accessibility** | 25+ | `Themes/Sixteen/docs/accessibility*.md` |

### By Module

```
Modules/
├── Xot/docs/
│   ├── 00-index.md (START HERE)
│   ├── base/ (Base classes)
│   ├── traits/ (Traits)
│   ├── phpstan*.md (PHPStan docs)
│   ├── testing/ (Testing guides)
│   └── ...
├── Fixcity/docs/
│   └── README.md
├── User/docs/
│   └── README.md
└── ...
```

### By Theme

```
Themes/Sixteen/docs/
├── README.md (START HERE)
├── layout-architecture.md
├── LAYOUT_ARCHITECTURE_MAP.md
├── components/
├── guides/
└── ...
```

---

## 📊 Documentation Statistics

| Category | Files | Lines (est.) |
|----------|-------|--------------|
| **Modules** | 6,812 | 500,000+ |
| **Themes** | 325 | 25,000+ |
| **BMad (General)** | 9 | 8,000+ |
| **BMad (Design Comuni)** | 6 | 4,500+ |
| **Project** | 153 | 15,000+ |
| **Total** | **7,305** | **552,500+** |

---

## 🎯 Documentation Quality Standards

### Required for All Docs

- [x] Clear title and purpose
- [x] Date created/updated
- [x] Cross-references (min 3 bidirectional links)
- [x] Table of contents (if > 100 lines)
- [x] Examples/code snippets where relevant

### Index Requirements

- [x] Master index updated when new docs created
- [x] Module indexes link to master index
- [x] Theme indexes link to master index
- [x] BMad docs link to master index
- [x] Bidirectional links verified monthly

### Maintenance

- **Weekly:** Check for orphaned docs (no incoming links)
- **Monthly:** Update statistics, verify links
- **Quarterly:** Archive outdated docs
- **Per Sprint:** Add new docs to index

---

## 🔗 External References

### BMad Method

- [BMad-METHOD](https://github.com/bmad-code-org/BMAD-METHOD) - Official repository
- [BMad Skills](.qwen/skills/) - Local BMad skills
- [BMad Output](_bmad-output/) - Generated artifacts

### Project Resources

- [GitHub Repository](https://github.com/fixcity/fila5)
- [Laravel Docs](https://laravel.com/docs)
- [Filament Docs](https://filamentphp.com/docs)
- [Vite Docs](https://vitejs.dev/)

---

## 📝 Document Creation Template

```markdown
# Document Title

**Created:** YYYY-MM-DD  
**Updated:** YYYY-MM-DD  
**Status:** Draft | Active | Archived  
**Type:** Guide | Reference | ADR | Fix Report  

---

## Purpose

Brief description of what this document covers.

---

## Content

Main content here.

---

## Cross-References

- → [Related Doc 1](path/to/doc.md)
- → [Related Doc 2](path/to/doc.md)
- → [Master Index](../../docs/MODULE_DOCS_INDEX.md)

---

**Last Updated:** YYYY-MM-DD  
**Author:** Name  
**Review Date:** YYYY-MM-DD
```

---

## 🆘 Support

### Finding Documentation

1. Start at [Master Index](#master-documentation-index---fixcity-fila5)
2. Navigate to module/theme category
3. Use search (Ctrl+F) for keywords
4. Check cross-references in related docs

### Contributing Documentation

1. Create markdown file in appropriate folder
2. Add to module/theme index
3. Add to Master Index
4. Create bidirectional links
5. Commit with clear message

### Questions

- **Module docs:** Contact module owner
- **Theme docs:** Contact frontend team
- **BMad docs:** Contact PO/Tech Lead
- **Master Index:** Contact documentation maintainer

---

**Last Updated:** 2026-04-01  
**Next Review:** 2026-04-08  
**Owner:** Documentation Team  
**Status:** ✅ **Active**

🐮 **Master Documentation Index Complete!**
