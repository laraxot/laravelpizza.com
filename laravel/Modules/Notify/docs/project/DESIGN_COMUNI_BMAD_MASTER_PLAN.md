# Design Comuni Italia - BMad Master Plan

**Project:** FixCity Fila5
**Date:** 2026-04-01
**Status:** 🔄 **In Progress**
**Priority:** 🔴 **CRITICAL**
**Method:** BMAD-METHOD + GSD + Ralph Loop

---

## 🎯 Mission Statement

Replicare **ESATTAMENTE** le 38 pagine statiche di Design Comuni Italia utilizzando:
- ✅ **Tailwind CSS** (NOT Bootstrap Italia)
- ✅ **Folio + Volt** (single `[slug].blade.php`)
- ✅ **JSON Content Blocks** (NOT hardcoded HTML)
- ✅ **Universal Reusable Blocks** (NOT page-specific)
- ✅ **<x-layouts.app>** (NOT custom layouts)
- ✅ **<x-section slug="header" />** (NOT inline HTML)
- ✅ **<x-pub_theme:: namespace** (NOT <x-sixteen::)

---

## 📊 Project Scope

### 38 Pagine da Replicare

| Categoria | Pagine | Priority |
|-----------|--------|----------|
| **Generali** | 9 pagine | 🔴 Critical |
| **Amministrazione** | 2 pagine | 🔴 Critical |
| **Novità** | 2 pagine | 🟠 High |
| **Servizi** | 3 pagine | 🔴 Critical |
| **Vivere il Comune** | 2 pagine | 🟠 High |
| **Appuntamento** | 8 pagine | 🟠 High |
| **Assistenza** | 2 pagine | 🟡 Medium |
| **Segnalazione** | 7 pagine | 🟠 High |

**Totale:** 38 pagine

---

## 🏗️ Architecture Principles

### 1. DRY (Don't Repeat Yourself)

❌ **SBAGLIATO:**
```blade
pages/tests/homepage.blade.php
pages/tests/argomenti.blade.php
pages/tests/amministrazione.blade.php
```

✅ **CORRETTO:**
```blade
pages/tests/[slug].blade.php  ← UNICO file per TUTTE
```

---

### 2. KISS (Keep It Simple, Stupid)

❌ **SBAGLIATO:**
```blade
<x-sixteen::blocks.navigation.header-main>
@includeIf('pub_theme::design-comuni.pages.'.$slug)
```

✅ **CORRETTO:**
```blade
<x-layouts.app>
<x-section slug="header" />
<x-page side="content" :slug="$pageSlug" :data="$data" />
```

---

### 3. Universal Blocks

❌ **SBAGLIATO:**
```blade
<x-pub_theme::components.blocks.tests.argomenti.topics-grid>
<!-- "tests.argomenti" è page-specific -->
```

✅ **CORRETTO:**
```blade
<x-pub_theme::components.blocks.topics-grid.default>
<!-- "topics-grid" è universale -->
```

---

### 4. JSON Content

❌ **SBAGLIATO:**
```blade
{{-- Hardcoded HTML in blade --}}
<div class="hero">
    <h1>Benvenuto</h1>
</div>
```

✅ **CORRETTO:**
```json
{
  "slug": "tests.homepage",
  "content_blocks": {
    "it": [
      {
        "type": "hero",
        "data": {
          "view": "pub_theme::components.blocks.hero.default",
          "title": "Benvenuto"
        }
      }
    ]
  }
}
```

---

## 📋 Implementation Phases

### Phase 1: Foundation (Week 1-2)

**Goal:** Setup architettura e componenti base

**Tasks:**
1. ✅ Fix `[slug].blade.php` con Folio + Volt
2. ✅ Fix `index.blade.php` con Folio + Volt
3. ✅ Fix theme detection (APP_URL → config)
4. ✅ Fix Vite build (outDir, copy script)
5. ✅ Creare header component esatto
6. ✅ Creare footer component esatto

**Deliverables:**
- `[slug].blade.php` corretto
- `index.blade.php` corretto
- Theme detection documentata
- Vite build funzionante
- Header/Footer components

---

### Phase 2: Block Components (Week 3-4)

**Goal:** Implementare blocchi universali riutilizzabili

**Block Categories:**

| Category | Blocks | Priority |
|----------|--------|----------|
| **Hero** | hero/default, hero/with-image | 🔴 |
| **Navigation** | breadcrumb, topics-grid, links-list | 🔴 |
| **Cards** | cards/grid, cards/teaser, cards/simple | 🔴 |
| **Content** | text-block, accordion, tabs | 🟠 |
| **Forms** | search, feedback, contact | 🟠 |
| **Media** | gallery, video, carousel | 🟡 |

**Deliverables:**
- 20+ block components
- Documentation per block
- Usage examples

---

### Phase 3: Content JSON (Week 5-6)

**Goal:** Creare JSON per tutte le 38 pagine

**JSON Structure:**
```json
{
  "slug": "tests.{page}",
  "content_blocks": {
    "it": [
      {
        "type": "breadcrumb",
        "data": { "view": "...", "items": [...] }
      },
      {
        "type": "hero",
        "data": { "view": "...", "title": "..." }
      }
    ]
  }
}
```

**Pages:**
- Homepage (tests.homepage.json)
- Argomenti (tests.argomenti.json)
- Amministrazione (tests.amministrazione.json)
- ... (35 more)

**Deliverables:**
- 38 JSON files
- Validation per file
- Content blocks mapping

---

### Phase 4: HTML Parity (Week 7-8)

**Goal:** HTML inside `<body>` identico a Design Comuni

**Comparison:**
```
Design Comuni: https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html
FixCity:       http://fixcity.local/it/tests/homepage
```

**Checklist:**
- [ ] Skip links (`.skiplink`)
- [ ] Header (`header.it-header-wrapper`)
- [ ] Main (`main#main-container`)
- [ ] Footer (`footer#footer.it-footer`)
- [ ] All CSS classes match
- [ ] All data attributes match
- [ ] All ARIA labels match

**Deliverables:**
- HTML parity report
- Screenshot comparison
- Fix list

---

### Phase 5: Visual Parity (Week 9-10)

**Goal:** Visual identity al 100% con Design Comuni

**Tools:**
- Tailwind `@apply` in `style-apply.css`
- Alpine.js per interazioni
- No Bootstrap Italia CSS/JS

**Checklist:**
- [ ] Colors match exactly
- [ ] Typography match exactly
- [ ] Spacing match exactly
- [ ] Icons match exactly
- [ ] Layout match exactly

**Deliverables:**
- Visual parity report
- Screenshot comparison
- CSS fixes

---

### Phase 6: Testing & QA (Week 11-12)

**Goal:** Quality assurance e testing

**Tests:**
- Pest tests per components
- Accessibility audit (WCAG 2.1 AA)
- Performance audit (Lighthouse >90)
- Cross-browser testing
- Mobile responsiveness

**Deliverables:**
- Test suite
- Accessibility report
- Performance report
- Bug fixes

---

## 📁 Documentation Structure

### Module Docs

```
laravel/Modules/Cms/docs/
├── README.md
├── PAGE_COMPONENT_ARCHITECTURE.md    ← Page component logic
├── BLOCK_DATA_STRUCTURE.md           ← BlockData structure
└── JSON_CONTENT_GUIDE.md             ← JSON content guide
```

### Theme Docs

```
laravel/Themes/Sixteen/docs/
├── README.md
├── LAYOUT_ARCHITECTURE_AND_NAMESPACE.md  ← Layout hierarchy
├── THEME_DETECTION_SYSTEM.md             ← Theme detection
├── VITE_BUILD_SYSTEM.md                  ← Vite build process
├── DESIGN_COMUNI_HTML_REPLICATION.md     ← HTML analysis
├── DESIGN_COMUNI_AMMINISTRAZIONE_ANALYSIS.md
└── prompts/
    └── replikate.txt                     ← Replication prompt
```

### Project Docs

```
docs/project/
├── MODULE_DOCS_INDEX.md              ← Master index
├── THEME_DETECTION_SYSTEM.md         ← Theme detection
└── DESIGN_COMUNI_BMAD_MASTER_PLAN.md ← This file
```

### BMad Docs

```
_bmad-output/
├── DESIGN_COMUNI_INDEX.md            ← BMad index
├── design-comuni-prd.md              ← PRD
├── design-comuni-architecture.md     ← Architecture
├── design-comuni-ui-spec.md          ← UI Spec
├── design-comuni-epics.md            ← Epics & Stories
├── design-comuni-sprint-plan.md      ← Sprint plan
└── design-comuni-block-analysis.md   ← Block analysis (598 righe)
```

---

## 🔗 Bidirectional Links

### Link Pattern 1: Module → Master Index

**In ogni modulo docs/README.md:**
```markdown
## Cross-References

- → [Master Index](../../../docs/project/MODULE_DOCS_INDEX.md)
- → [Theme Detection](../../../docs/project/THEME_DETECTION_SYSTEM.md)
- → [Page Component Architecture](PAGE_COMPONENT_ARCHITECTURE.md)
```

### Link Pattern 2: Theme → Master Index

**In theme docs/README.md:**
```markdown
## Cross-References

- → [Master Index](../../../docs/project/MODULE_DOCS_INDEX.md)
- → [Theme Detection](../../../docs/project/THEME_DETECTION_SYSTEM.md)
- → [Layout Architecture](LAYOUT_ARCHITECTURE_AND_NAMESPACE.md)
```

### Link Pattern 3: Master Index → Module/Theme

**In docs/project/MODULE_DOCS_INDEX.md:**
```markdown
## Theme Documentation

### Sixteen
- **Location:** `laravel/Themes/Sixteen/docs/`
- **Files:** 221
- **Index:** [Sixteen Docs Index](Themes/Sixteen/docs/00-index.md)
- **Key Topics:**
  - [Layout Architecture](Themes/Sixteen/docs/LAYOUT_ARCHITECTURE_AND_NAMESPACE.md)
  - [Theme Detection](docs/project/THEME_DETECTION_SYSTEM.md)
  - [Design Comuni Replication](Themes/Sixteen/docs/DESIGN_COMUNI_HTML_REPLICATION.md)
```

---

## 🚀 GitHub Workflow

### Issues Template

```markdown
## Design Comuni Replication - {Page Name}

**URL Design Comuni:** https://italia.github.io/design-comuni-pagine-statiche/sito/{page}.html
**URL FixCity:** http://fixcity.local/it/tests/{page}

### Checklist

- [ ] HTML inside <body> identical (excluding scripts)
- [ ] JSON content created
- [ ] Block components created
- [ ] Visual parity achieved
- [ ] Screenshot comparison added
- [ ] Documentation updated

### Screenshots

- [ ] Design Comuni screenshot
- [ ] FixCity screenshot
- [ ] Comparison analysis

### Analysis

[Link to analysis doc in Themes/Sixteen/docs/]
```

### Discussions Template

```markdown
## Design Comuni Replication - Progress Update

### Week {N}

**Completed:**
- Component X created
- Page Y replicated
- Documentation Z updated

**Blockers:**
- Issue A
- Issue B

**Next Week:**
- Task 1
- Task 2

### Metrics

- Pages completed: X/38
- Components created: Y/47
- Documentation updated: Z files
```

---

## 📊 Progress Tracking

### Weekly Checkpoints

| Week | Focus | Target | Actual | Status |
|------|-------|--------|--------|--------|
| 1-2 | Foundation | 6 tasks | - | 🔄 In Progress |
| 3-4 | Block Components | 20 blocks | - | ⏳ Pending |
| 5-6 | Content JSON | 38 files | - | ⏳ Pending |
| 7-8 | HTML Parity | 38 pages | - | ⏳ Pending |
| 9-10 | Visual Parity | 100% match | - | ⏳ Pending |
| 11-12 | Testing & QA | 80% coverage | - | ⏳ Pending |

### Component Progress

| Tier | Components | Target | Created | Status |
|------|------------|--------|---------|--------|
| Tier 1 | 7 | 7 | 5 | ✅ 71% |
| Tier 2 | 5 | 5 | 2 | 🔄 40% |
| Tier 3 | 10 | 10 | 3 | 🔄 30% |
| Tier 4 | 12 | 12 | 4 | 🔄 33% |
| Tier 5 | 13 | 13 | 0 | ⏳ 0% |

---

## 🎯 Success Criteria

### Definition of Done (Per Page)

- [ ] JSON content file created
- [ ] All block components exist
- [ ] HTML inside `<body>` identical (95%+)
- [ ] Visual parity achieved (98%+)
- [ ] Screenshot comparison added
- [ ] Analysis document created
- [ ] Cross-references updated

### Definition of Done (Overall Project)

- [ ] 38/38 pages replicated
- [ ] 47/47 components created
- [ ] HTML parity 95%+
- [ ] Visual parity 98%+
- [ ] Documentation complete
- [ ] Tests passing (80%+ coverage)
- [ ] Accessibility WCAG 2.1 AA
- [ ] Performance Lighthouse >90

---

## 🔧 Tools & Skills

### Required Skills

- ✅ BMAD-METHOD (bmad-code-org/BMAD-METHOD)
- ✅ GSD (gsd-build/get-shit-done)
- ✅ Ralph Loop (snarktank/ralph)
- ✅ OpenViking (volcengine/OpenViking)
- ✅ Superpowers (obra/superpowers)
- ✅ UI/UX Pro Max (nextlevelbuilder/ui-ux-pro-max-skill)
- ✅ NotebookLM MCP

### MCP Servers

- ✅ Browser automation (screenshots)
- ✅ GitHub (issues/discussions)
- ✅ Visual comparison
- ✅ Documentation sync

---

## 📝 Documentation Rules

### DRY (Don't Repeat Yourself)

- ✅ Single source of truth
- ✅ Link, don't copy
- ✅ Reuse documentation

### KISS (Keep It Simple, Stupid)

- ✅ Clear and concise
- ✅ No unnecessary complexity
- ✅ Focus on essentials

### Bidirectional Links

- ✅ Min 3 cross-references per doc
- ✅ Module → Master Index
- ✅ Master Index → Module
- ✅ Theme → Master Index
- ✅ Master Index → Theme

---

## 🚨 Anti-Patterns

### 1. ❌ Page-Specific Files

```bash
pages/tests/homepage.blade.php      # NO
pages/tests/argomenti.blade.php     # NO
```

✅ **CORRETTO:** `pages/tests/[slug].blade.php`

---

### 2. ❌ Hardcoded Theme Namespace

```blade
<x-sixteen::...>  # NO
```

✅ **CORRETTO:** `<x-pub_theme::...>`

---

### 3. ❌ Inline Header/Footer

```blade
<header>...</header>  # NO in [slug].blade.php
<footer>...</footer>  # NO in [slug].blade.php
```

✅ **CORRETTO:** `<x-section slug="header" />` in app.blade.php

---

### 4. ❌ Bootstrap Italia Import

```css
@import url('bootstrap-italia.min.css');  # NO
```

✅ **CORRETTO:** Tailwind `@apply` in `style-apply.css`

---

### 5. ❌ Page-Specific Blocks

```blade
<x-pub_theme::blocks.tests.argomenti.topics-grid>  # NO
```

✅ **CORRETTO:** `<x-pub_theme::blocks.topics-grid.default>`

---

## 📞 Support & Resources

### Key Documents

- [Master Index](docs/project/MODULE_DOCS_INDEX.md)
- [Theme Detection](docs/project/THEME_DETECTION_SYSTEM.md)
- [Layout Architecture](Themes/Sixteen/docs/LAYOUT_ARCHITECTURE_AND_NAMESPACE.md)
- [Page Component](Modules/Cms/docs/PAGE_COMPONENT_ARCHITECTURE.md)

### External Resources

- [Design Comuni GitHub](https://github.com/italia/design-comuni-pagine-statiche)
- [Design Comuni Live](https://italia.github.io/design-comuni-pagine-statiche/)
- [Bootstrap Italia](https://italia.github.io/bootstrap-italia/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Flowbite Blocks](https://flowbite.com/blocks/)
- [Tailwind UI](https://tailwindcss.com/plus/ui-blocks)
- [DaisyUI](https://daisyui.com/components/)

---

**📝 Documento preparato da:** Multi-Agent Team (BMad + GSD + Ralph)
**📅 Data:** 2026-04-01
**🔄 Next Review:** Weekly
**🎯 Status:** 🔄 **In Progress**

🐮 **BMad Master Plan Created!**
