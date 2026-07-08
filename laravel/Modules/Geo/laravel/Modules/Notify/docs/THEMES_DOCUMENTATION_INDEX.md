# Theme Documentation Master Index

**📍 Central Hub for All Theme Documentation**

Connects all theme docs with bidirectional links and visual architecture.

---

## 🗺️ Active Themes

### Sixteen - PRIMARY THEME ⭐

**📁 Location:** `laravel/Themes/Sixteen/`  
**Status:** ✅ Active (production)  
**Purpose:** Design Comuni replication + modern UI  
**Tech Stack:** Tailwind CSS + Alpine.js + Livewire Volt

**Core Documentation:**
- [00-INDEX.md](../laravel/Themes/Sixteen/docs/00-INDEX.md) - Start here
- [Design Comuni Integration](../laravel/Themes/Sixteen/docs/design-comuni-integration.md)
- [Component Catalog](../laravel/Themes/Sixteen/docs/COMPONENT_CATALOG.md)
- [Layout Architecture](../laravel/Themes/Sixteen/docs/layout-hierarchy.md)

**Directory Structure:**
```
Sixteen/
├── docs/                          ← 200+ documentation files
│   ├── 00-INDEX.md               ← MASTER INDEX
│   ├── architecture/             ← Diagrams & architecture
│   ├── design-comuni/            ← Design Comuni project
│   ├── components/               ← Component docs
│   ├── guides/                   ← How-to guides
│   └── screenshots/              ← Visual references
│
├── resources/
│   ├── views/
│   │   ├── layouts/              ← Main layout files
│   │   ├── pages/                ← Page components (Folio)
│   │   ├── components/           ← Reusable components
│   │   └── blocks/               ← Content blocks
│   │
│   ├── css/
│   │   ├── tailwind.config.js    ← Tailwind config
│   │   └── app.css               ← Global styles
│   │
│   └── js/
│       └── app.js                ← Alpine.js setup
│
├── public/
│   ├── images/
│   ├── icons/
│   └── fonts/
│
└── config/
    └── database/content/pages/   ← JSON content files
        ├── homepage.json
        ├── about.json
        └── ...
```

---

### TwentyOne - ALTERNATIVE THEME

**📁 Location:** `laravel/Themes/TwentyOne/`  
**Status:** ✅ Available  
**Purpose:** Alternative theme variant  

**Cross-Reference:**
- [Switch to TwentyOne](#twentyone-configuration)
- [Differences from Sixteen](../laravel/Themes/TwentyOne/docs/differences.md)

---

## Component Architecture

### Component Hierarchy

```
┌──────────────────────────────────────────────────┐
│         Component Organization System             │
└──────────────────────────────────────────────────┘

views/components/
├── layout/
│   ├── header.blade.php
│   ├── footer.blade.php
│   ├── sidebar.blade.php
│   └── breadcrumbs.blade.php
│
├── navigation/
│   ├── main-nav.blade.php
│   ├── mobile-nav.blade.php
│   └── submenu.blade.php
│
├── hero/
│   ├── hero-default.blade.php
│   ├── hero-image.blade.php
│   └── hero-video.blade.php
│
├── content/
│   ├── card.blade.php
│   ├── grid.blade.php
│   ├── list.blade.php
│   └── carousel.blade.php
│
├── forms/
│   ├── input-text.blade.php
│   ├── input-email.blade.php
│   ├── input-select.blade.php
│   ├── input-checkbox.blade.php
│   ├── input-radio.blade.php
│   ├── textarea.blade.php
│   ├── button.blade.php
│   └── form-group.blade.php
│
├── modals/
│   ├── modal-default.blade.php
│   ├── modal-confirm.blade.php
│   └── modal-form.blade.php
│
├── alerts/
│   ├── alert-success.blade.php
│   ├── alert-error.blade.php
│   ├── alert-warning.blade.php
│   └── alert-info.blade.php
│
└── blocks/
    ├── block-hero.blade.php
    ├── block-content.blade.php
    ├── block-cta.blade.php
    ├── block-testimonial.blade.php
    └── (44+ block types)
```

---

## Content Block System

### Block Types (47 total)

```
Design Comuni blocks are organized by tier:

TIER 1 - Foundation (Always needed)
├─ Hero Block          → Page header/banner
├─ Content Block       → Rich text + images
├─ CTA Block           → Call-to-action
└─ Form Block          → Contact forms

TIER 2 - Enhanced
├─ Testimonial Block   → User testimonials
├─ Gallery Block       → Image galleries
├─ Timeline Block      → Timeline component
├─ Accordion Block     → Expandable content
└─ Card Grid Block     → Card layouts

TIER 3 - Advanced
├─ Comparison Block    → Side-by-side comparison
├─ Pricing Block       → Pricing tables
├─ Feature Block       → Feature list
├─ Process Block       → Step-by-step process
└─ Video Block         → Embedded videos

TIER 4-5 - Specialized
├─ Map Block           → Location maps
├─ Partner Block       → Partner logos
├─ Newsletter Block    → Email signup
└─ (+ many more...)
```

**Block JSON Structure:**
```json
{
  "type": "hero",
  "title": "Welcome to FixCity",
  "subtitle": "Manage your city, digitally",
  "image": "https://...",
  "cta": {
    "text": "Get Started",
    "url": "/signup"
  }
}
```

---

## Pages Directory

### Folio File-Based Routing

```
pages/
├── index.blade.php                    → /
├── about.blade.php                    → /about
├── contact.blade.php                  → /contact
│
├── tests/
│   ├── index.blade.php                → /it/tests/
│   └── [slug].blade.php               → /it/tests/{slug}
│       (Dynamic route for all pages)
│
├── admin/
│   ├── index.blade.php                → /admin/
│   └── dashboard.blade.php            → /admin/dashboard
│
├── auth/
│   ├── login.blade.php                → /auth/login
│   ├── register.blade.php             → /auth/register
│   └── forgot-password.blade.php      → /auth/forgot-password
│
└── design-comuni/
    ├── homepage.blade.php             → /it/tests/homepage
    ├── amministrazione.blade.php      → /it/tests/amministrazione
    └── ...                            → /it/tests/*
```

### Dynamic Page Loading

```
Request: GET /it/tests/homepage

1. Router matches: pages/tests/[slug].blade.php
2. Slug extracted: homepage

3. Component initializes:
   @mount('tests.homepage')
   
4. Middleware loads JSON:
   config/local/fixcity/database/content/pages/homepage.json

5. Data passed to view:
   @props('content' => $content)

6. Template renders blocks:
   @foreach ($content['blocks'] as $block)
       @component('blocks.' . $block['type'], $block)
       @endcomponent
   @endforeach

7. Result: Rendered page with all blocks
```

---

## Tailwind CSS Configuration

### Tailwind Organization

```
tailwind.config.js
├── theme
│   ├── colors          ← Design Comuni palette
│   ├── spacing         ← Consistent grid
│   ├── typography      ← Font families
│   ├── breakpoints     ← Responsive sizes
│   └── plugins         ← Custom utilities
│
├── content             ← Files to scan
│   ├── "resources/views/**/*.blade.php"
│   ├── "resources/css/**/*.css"
│   └── "resources/js/**/*.js"
│
├── plugins
│   ├── forms           ← Form styling
│   ├── typography      ← Typography plugin
│   └── aspect-ratio    ← Image aspect ratios
│
└── extend
    ├── Custom utilities
    └── Custom colors
```

### Design Tokens (From Design Comuni)

```
Colors:
├─ Primary   → #0066FF (Blue)
├─ Success   → #17A697 (Green)
├─ Warning   → #FF9900 (Orange)
├─ Danger    → #D3212D (Red)
├─ Neutral   → #454A4D, #8A8E92, #D3D4D7 (Grays)
└─ White     → #FFFFFF

Spacing (8px grid):
├─ xs: 4px
├─ sm: 8px
├─ md: 16px
├─ lg: 24px
├─ xl: 32px
└─ 2xl: 48px

Typography:
├─ Lato (sans-serif primary)
├─ Roboto Mono (monospace)
└─ Font sizes: 12, 14, 16, 18, 20, 24, 32px
```

---

## Documentation Files Reference

### Architecture Documentation

| File | Purpose | View |
|------|---------|------|
| `layout-hierarchy.md` | Layout component structure | [View](../laravel/Themes/Sixteen/docs/layout-hierarchy.md) |
| `component-structure.md` | Component organization | [View](../laravel/Themes/Sixteen/docs/component-structure.md) |
| `data-flow.md` | How data flows through views | [View](../laravel/Themes/Sixteen/docs/data-flow.md) |
| `styling-system.md` | Tailwind + CSS strategy | [View](../laravel/Themes/Sixteen/docs/styling-system.md) |
| `asset-pipeline.md` | Vite + asset compilation | [View](../laravel/Themes/Sixteen/docs/asset-pipeline.md) |

### Component Documentation

| File | Purpose | View |
|------|---------|------|
| `COMPONENT_CATALOG.md` | All 47 components listed | [View](../laravel/Themes/Sixteen/docs/COMPONENT_CATALOG.md) |
| `components/navigation.md` | Navigation components | [View](../laravel/Themes/Sixteen/docs/components/navigation.md) |
| `components/forms.md` | Form components | [View](../laravel/Themes/Sixteen/docs/components/forms.md) |
| `components/blocks.md` | Content blocks | [View](../laravel/Themes/Sixteen/docs/components/blocks.md) |
| `components/layout.md` | Layout components | [View](../laravel/Themes/Sixteen/docs/components/layout.md) |

### Design Comuni Documentation

| File | Purpose | View |
|------|---------|------|
| `design-comuni/pages.md` | 38 pages being replicated | [View](../laravel/Themes/Sixteen/docs/design-comuni/pages.md) |
| `design-comuni/blocks.md` | Block analysis | [View](../laravel/Themes/Sixteen/docs/design-comuni/blocks.md) |
| `design-comuni/progress.md` | Implementation progress | [View](../laravel/Themes/Sixteen/docs/design-comuni/progress.md) |
| `design-comuni/challenges.md` | Technical challenges | [View](../laravel/Themes/Sixteen/docs/design-comuni/challenges.md) |

### How-To Guides

| File | Purpose | View |
|------|---------|------|
| `guides/getting-started.md` | Theme setup | [View](../laravel/Themes/Sixteen/docs/guides/getting-started.md) |
| `guides/adding-components.md` | Create new component | [View](../laravel/Themes/Sixteen/docs/guides/adding-components.md) |
| `guides/styling-guide.md` | Styling best practices | [View](../laravel/Themes/Sixteen/docs/guides/styling-guide.md) |
| `guides/responsive-design.md` | Mobile-first approach | [View](../laravel/Themes/Sixteen/docs/guides/responsive-design.md) |
| `guides/customization.md` | Customize theme | [View](../laravel/Themes/Sixteen/docs/guides/customization.md) |

---

## Cross-Module Integration Points

### How Themes Connect to Modules

```
Themes/Sixteen/ ◄──────► Modules/
                  
Resources (views)
    ↓
Displays content from:
    ├─ Cms Module      ← Pages, blocks, content
    ├─ Media Module    ← Images, files
    ├─ Blog Module     ← Blog posts
    ├─ Comment Module  ← Comments on pages
    └─ Rating Module   ← Star ratings

Forms in theme
    ↓
Processes through:
    ├─ Cms Module      ← Create content
    ├─ Comment Module  ← Submit comments
    ├─ Notify Module   ← Send notifications
    └─ Job Module      ← Queue submissions

Navigation & Auth
    ↓
Integrates with:
    ├─ User Module     ← Login/logout
    ├─ Tenant Module   ← Multi-tenant scoping
    └─ Lang Module     ← Translations
```

---

## Theme Configuration

### Switching Themes

**Via .env:**
```bash
APP_URL=http://fixcity.local
# Theme detected from APP_URL → fixcity → Sixteen (or override via config)
```

**Via Config:**
```php
// laravel/config/local/fixcity/xra.php
'pub_theme' => 'Sixteen',  // or 'TwentyOne'
```

### Theme Assets

```
public_html/assets/
├── themes/
│   ├── Sixteen/
│   │   ├── css/
│   │   │   ├── app.css          ← Compiled Tailwind
│   │   │   └── theme.css        ← Theme-specific
│   │   ├── js/
│   │   │   ├── app.js
│   │   │   └── alpine.js
│   │   └── images/
│   │
│   └── TwentyOne/
│       └── (similar structure)
│
├── common/                       ← Shared across themes
│   ├── fonts/
│   ├── icons/
│   └── vendor/
```

---

## Bidirectional Links Map

### Theme → Modules

- **Themes/Sixteen** → `Modules/Cms` - Renders page content
- **Themes/Sixteen** → `Modules/Media` - Displays images
- **Themes/Sixteen** → `Modules/User` - User authentication
- **Themes/Sixteen** → `Modules/Blog` - Shows blog posts
- **Themes/Sixteen** → `Modules/Comment` - Displays comments
- **Themes/Sixteen** → `Modules/Rating` - Shows ratings
- **Themes/Sixteen** → `Modules/Notify` - Form notifications
- **Themes/Sixteen** → `Modules/Lang` - Translations
- **Themes/Sixteen** → `Modules/Tenant` - Tenant scoping

### Modules → Theme

- **Modules/Cms** ← Creates page routes in `pages/tests/[slug]`
- **Modules/Media** ← Stores images in `public_html/storage/`
- **Modules/Blog** ← Blog data in `resources/views/blog/`
- **Modules/Comment** ← Comment component in `resources/components/`

---

## See Also

- **Architecture Diagrams:** [ARCHITECTURE-DIAGRAMS.md](ARCHITECTURE-DIAGRAMS.md)
- **Module Docs Index:** [MODULE_DOCS_INDEX.md](MODULE_DOCS_INDEX.md)
- **Master Index:** [00-INDEX.md](../laravel/Themes/Sixteen/docs/00-INDEX.md)
- **Code Quality:** [CODE_QUALITY_STANDARDS.md](CODE_QUALITY_STANDARDS.md)
- **Framework Rules:** [../laravel/CLAUDE.md](../laravel/CLAUDE.md)

---

**Last Updated:** See git history  
**Version:** Theme Documentation v2  
**Total Docs:** 200+ connected files  
**Central Hub:** Connects all theme documentation with bidirectional links
