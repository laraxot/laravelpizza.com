---
title: Design Comuni Italia - Architectural Decisions & Implementation Strategy
category: General
labels: ['design-comuni', 'architecture', 'decision-record']
---

# Design Comuni Italia - Architectural Decisions

This discussion documents the key architectural decisions for replicating the 38 static pages from [Design Comuni Italia](https://italia.github.io/design-comuni-pagine-statiche/) in the FixCity project.

---

## 🎯 Goal

Replicate **EXACTLY** 38 static pages with:
- **100% HTML Parity** inside `<body>` tag (excluding scripts)
- **100% Visual Parity** (screenshot match)
- **Tailwind CSS** with @apply (NOT Bootstrap imports)
- **JSON-driven content** (NOT hardcoded HTML)
- **Universal reusable blocks** (NOT page-specific)

---

## 🏗️ Architecture Decisions

### 1. ONE [slug].blade.php for ALL Pages ✅

**Decision**: Use single dynamic blade file for all 38 pages.

**File**: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`

**Rationale**:
- DRY: One blade handles 38 pages
- KISS: Simple logic, dynamic slug
- Maintainability: Change 1 file, not 38
- Scalability: Add pages without new blades

**Implementation**:
```php
<x-layouts.app>
 @volt('tests.view')
    <x-page side="content" :slug="$pageSlug" :data="$data" />
 @endvolt
</x-layouts.app>
```

**Alternatives Rejected**:
- ❌ `homepage.blade.php` - Violates DRY
- ❌ `argomenti.blade.php` - Not scalable
- ❌ 38 separate files - Maintenance nightmare

---

### 2. JSON for Content, Blade for Structure ✅

**Decision**: Content stored in JSON files, structure in Blade.

**Files**: `laravel/config/local/fixcity/database/content/pages/tests.[slug].json`

**Rationale**:
- Separation of Concerns: Structure ≠ Content
- CMS-driven: Content editors modify JSON
- Reusability: Same blade, different content
- Versioning: JSON under Git, easy diff

**Implementation**:
```json
{
  "slug": "tests.homepage",
  "content_blocks": {
    "it": [
      {
        "type": "hero",
        "view": "pub_theme::components.blocks.hero.homepage",
        "data": {...}
      }
    ]
  }
}
```

**Alternatives Rejected**:
- ❌ Hardcoded HTML in blade - Not maintainable
- ❌ Database content - Overkill for static pages
- ❌ Markdown - Not structured enough

---

### 3. Universal Blocks, NOT Page-Specific ✅

**Decision**: Create 47 reusable blocks used across 38 pages.

**Pattern**: `pub_theme::components.blocks.<type>.<blade>`

**Rationale**:
- DRY: 47 blocks for 38 pages (NOT 38 specific blocks)
- Maintainability: Change 1 block, all pages updated
- Consistency: Same block, same look
- Scalability: New pages use existing blocks

**Block Types** (inspired by):
- https://flowbite.com/blocks/ → `hero`, `card`, `navigation`
- https://tailwindcss.com/plus/ui-blocks → `grid`, `list`, `modal`
- https://daisyui.com/components/ → `accordion`, `carousel`, `tabs`
- https://italia.github.io/bootstrap-italia/docs/componenti/ → `breadcrumbs`, `footer`, `header`

**Implementation**:
```blade
✅ pub_theme::components.blocks.hero.homepage
✅ pub_theme::components.blocks.card.simple
✅ pub_theme::components.blocks.navigation.main
```

**Alternatives Rejected**:
- ❌ `pub_theme::components.blocks.tests.argomenti` - Page-specific
- ❌ `pub_theme::components.blocks.homepage.specific` - Not reusable

---

### 4. Tailwind @apply, NOT Bootstrap Imports ✅

**Decision**: Use Tailwind CSS with @apply to replicate Bootstrap Italia classes.

**Rationale**:
- Performance: Compiled CSS, no CDN
- Customization: Tailwind utilities
- Consistency: Single design system
- Build: Vite manages assets

**Implementation**:
```css
/* style-apply.css */
.it-header-wrapper {
  @apply text-white relative;
  background-color: var(--bs-primary);
}

.it-header-slim-wrapper {
  @apply py-2 text-sm;
  background-color: var(--bs-primary-dark);
}
```

**HTML**: Keeps Bootstrap Italia class names (for parity)  
**CSS**: Tailwind @apply replicates styles

**Alternatives Rejected**:
- ❌ Bootstrap Italia CDN - Performance, build issues
- ❌ Pure Bootstrap - Conflicts with Tailwind
- ❌ Mixed CSS - Inconsistent

---

### 5. <x-layouts.app>, NOT Custom Layouts ✅

**Decision**: Single layout for all public frontend pages.

**Hierarchy**:
```
x-layouts.main (base HTML: DOCTYPE, head, body, scripts)
└── x-layouts.app (frontend wrapper)
    ├── <x-section slug="header" />
    ├── <x-page />
    └── <x-section slug="footer" />
```

**Rationale**:
- DRY: One layout for all public pages
- KISS: Clear hierarchy
- Consistency: All pages same structure

**Alternatives Rejected**:
- ❌ `<x-layouts.design-comuni>` - Duplicate
- ❌ Page-specific layouts - Not DRY

---

### 6. <x-section slug="header" />, NOT Inline HTML ✅

**Decision**: Use section components for header and footer.

**Rationale**:
- DRY: Header defined once, reused everywhere
- Maintainability: Change section, update all pages
- Flexibility: Pass parameters (`tpl="slim"`)

**Implementation**:
```blade
<x-layouts.app>
    <x-section slug="header" />
    <x-section slug="footer" tpl="slim" />
</x-layouts.app>
```

**Alternatives Rejected**:
- ❌ Inline `<header>` HTML - Duplicate
- ❌ @include - Less flexible

---

### 7. Namespace `pub_theme`, NOT `sixteen::` ✅

**Decision**: Use dynamic theme namespace.

**Rationale**:
- Theme-aware: Works with any theme
- Dynamic: `pub_theme` resolves to current theme
- Portability: Change theme, blocks work

**Implementation**:
```blade
<x-pub_theme::components.blocks.header.slim />
<x-pub_theme::components.blocks.hero.homepage />
```

**Alternatives Rejected**:
- ❌ `<x-sixteen::...>` - Hardcoded theme
- ❌ `<x-themes::...>` - Not dynamic

---

### 8. Forward-Only Git, NO Reset/Revert ✅

**Decision**: Never reset or revert commits.

**Rationale**:
- History: Every commit is a step forward
- Learning: Mistakes teach, don't erase
- Traceability: Always understand "why"

**Implementation**:
```bash
✅ git commit -m "Fix header colors"
✅ git commit -m "Improve footer layout"
```

**Alternatives Rejected**:
- ❌ `git reset --hard HEAD~5` - Lose history
- ❌ `git revert <commit>` - Negative progress

**Philosophy**:
> "Study old versions to understand 'why', improve by moving forward"

---

### 9. Vite Build: outDir: './public' + npm run copy ✅

**Decision**: Build theme independently, copy to public_html.

**Rationale**:
- Theme isolation: Independent build
- Deployment: Copy to public_html/themes/[theme]/
- Manifest: Laravel finds assets with `@vite([...], 'themes/Sixteen')`

**Implementation**:
```js
// vite.config.js
build: {
  outDir: './public',
  manifest: 'manifest.json',
}
```

```json
// package.json
"copy": "cp -rv ./public/* ../../../public_html/themes/Sixteen/"
```

```bash
cd laravel/Themes/Sixteen
composer update -W
npm install
npm run build
npm run copy
```

**Alternatives Rejected**:
- ❌ `outDir: '../../public_html/build'` - Wrong path
- ❌ No copy step - Assets not deployed

---

### 10. HTML Parity: Body Tag (Excluding Scripts) ✅

**Decision**: Match original HTML inside `<body>` tag exactly (scripts can differ).

**Rationale**:
- SEO: Same HTML structure
- Accessibility: Same ARIA labels
- Consistency: Exact match

**Implementation**:
```html
<!-- ORIGINALE -->
<body>
  <div class="skiplink">...</div>
  <header class="it-header-wrapper">...</header>
  <main id="main-container">...</main>
  <footer class="it-footer">...</footer>
</body>

<!-- FIXCITY: MUST BE IDENTICAL -->
<body>
  <div class="skiplink">...</div>
  <header class="it-header-wrapper">...</header>
  <main id="main-container">...</main>
  <footer class="it-footer">...</footer>
</body>
```

**SCRIPTS**: Can differ (Alpine.js vs Bootstrap Italia JS)

**Alternatives Rejected**:
- ❌ Different HTML structure - SEO, accessibility issues
- ❌ Include scripts in parity - Too strict, different tech stack

---

## 📊 Implementation Status

| Category | Total | Completed | In Progress | Pending |
|----------|-------|-----------|-------------|---------|
| Pages | 38 | 0 | 1 (Homepage) | 37 |
| Blocks | 47 | 20 | 5 | 22 |
| JSON Files | 38 | 5 | 2 | 31 |
| Documentation | 10 | 5 | 2 | 3 |

---

## 🚀 Next Steps

1. **Homepage HTML Parity** (Priority: CRITICAL)
   - Verify body HTML exact match
   - Fix header (colors, logo, slogan visibility)
   - Fix footer (layout, links)
   - Screenshot comparison

2. **Block Creation** (Priority: HIGH)
   - Create missing Tier 1 blocks
   - Document block types
   - Ensure reusability

3. **JSON Content** (Priority: HIGH)
   - Create all 38 JSON files
   - Verify block references
   - Test with `<x-page>`

4. **Documentation** (Priority: MEDIUM)
   - Update all docs folders
   - Add bidirectional links
   - Create screenshot comparisons

---

## 📚 References

- **Design Comuni**: https://github.com/italia/design-comuni-pagine-statiche
- **Live Pages**: https://italia.github.io/design-comuni-pagine-statiche/
- **Bootstrap Italia**: https://italia.github.io/bootstrap-italia/
- **Flowbite Blocks**: https://flowbite.com/blocks/
- **Tailwind UI**: https://tailwindcss.com/plus/ui-blocks
- **DaisyUI**: https://daisyui.com/components/

---

## 📖 Related Documentation

- [MASTER_IMPLEMENTATION_PLAN.md](../../laravel/Themes/Sixteen/docs/design-comuni/MASTER_IMPLEMENTATION_PLAN.md)
- [ARCHITECTURAL_DECISIONS.md](../../laravel/Themes/Sixteen/docs/design-comuni/ARCHITECTURAL_DECISIONS.md)
- [HTML_PARITY_VERIFICATION_REPORT.md](../../laravel/Themes/Sixteen/docs/design-comuni/HTML_PARITY_VERIFICATION_REPORT.md)
- [QWEN.md](../../QWEN.md)

---

**Created**: 2026-04-01  
**Status**: ✅ Active  
**Methodology**: DRY + KISS + Forward-Only
