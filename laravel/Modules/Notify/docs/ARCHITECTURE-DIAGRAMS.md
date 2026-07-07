# Architecture Diagrams & Visual Reference

**📍 Cross-References:**
- [← Back to Master Index](MASTER_DOCUMENTATION_INDEX.md)
- [Code Quality Analysis](CODE_QUALITY_ANALYSIS.md)
- [Module Dependencies](#module-dependencies)
- [Theme Architecture](#theme-architecture)
- [Data Flow](#data-flow)

---

## System Architecture Overview

```
┌─────────────────────────────────────────────────────────────────────┐
│                        FixCity Platform v2                          │
│                    Laravel 12 + Filament 5 + Livewire 3             │
└─────────────────────────────────────────────────────────────────────┘

┌──────────────────┐         ┌──────────────────┐        ┌──────────────┐
│   Public Layer   │         │  Admin Panel     │        │   Theme      │
│                  │         │  (Filament)      │        │  (Volt+Folio)│
│ - Routes (Folio) │────────→│ - Resources      │───────→│ - Components │
│ - Pages (Volt)   │         │ - Actions        │        │ - Views      │
│ - API (REST)     │         │ - Tables         │        │ - Assets     │
└──────────────────┘         └──────────────────┘        └──────────────┘
         │                             │                        │
         └─────────────────┬───────────┴─────────────────┬──────┘
                           │                             │
                    ┌──────▼──────────────────┐
                    │   Core Module (Xot)     │
                    ├──────────────────────────┤
                    │ - Base Classes           │
                    │ - Traits (DRY)           │
                    │ - Helpers & Utils        │
                    │ - Action Framework       │
                    └──────┬──────────────────┘
                           │
    ┌──────────────────────┼──────────────────────┐
    │                      │                      │
┌───▼─────────┐     ┌──────▼──────┐     ┌────────▼──────┐
│  Data Layer │     │ Service     │     │  Integration  │
├─────────────┤     ├─────────────┤     ├───────────────┤
│ 19 Modules: │     │ - Queueable │     │ - AI Module   │
│ - Activity  │     │   Actions   │     │ - Job Module  │
│ - Cms       │     │ - Business  │     │ - Notify      │
│ - Tenant    │     │   Logic     │     │ - Geo         │
│ - Media     │     │ - Events    │     │ - Gdpr        │
│ - User      │     │ - Listeners │     │ - Seo         │
│ - (+ 13 more)     │             │     │ - Rating      │
└─────────────┘     └─────────────┘     └───────────────┘
         │                                      │
         └──────────────┬───────────────────────┘
                        │
         ┌──────────────▼──────────────┐
         │   Database Layer            │
         ├─────────────────────────────┤
         │ - SQLite (dev)              │
         │ - PostgreSQL (prod)         │
         │ - Multi-tenant Scoping      │
         │ - JSON Config Storage       │
         └─────────────────────────────┘
```

---

## Module Dependency Graph

```
┌─────────────┐
│    Xot      │ ← Core foundation (base classes, traits)
│  (Core)     │
└──────┬──────┘
       │
       ├─→ ┌─────────────┐
       │   │   Activity  │ → Logs all model changes
       │   └─────────────┘
       │
       ├─→ ┌─────────────┐
       │   │   Cms       │ → Content management + JSON blocks
       │   │             │
       │   └─────────────┘
       │
       ├─→ ┌─────────────┐
       │   │   Tenant    │ → Multi-tenancy scoping
       │   │             │
       │   └─────────────┘
       │
       ├─→ ┌─────────────┐
       │   │   Media     │ → File uploads + storage
       │   │             │
       │   └─────────────┘
       │
       ├─→ ┌─────────────┐
       │   │   User      │ → Authentication + authorization
       │   │             │
       │   └─────────────┘
       │
       ├─→ ┌─────────────┐
       │   │   Job       │ → Background job processing
       │   │             │
       │   └─────────────┘
       │
       └─→ ┌─────────────────────────────┐
           │  Integration Modules        │
           ├─────────────────────────────┤
           │ AI, Notify, Geo, Gdpr,      │
           │ Seo, Rating, Blog, Comment  │
           └─────────────────────────────┘
```

---

## Theme Architecture

```
┌─────────────────────────────────────────────────────┐
│           Themes Directory Structure                │
└─────────────────────────────────────────────────────┘

themes/
│
├── Sixteen/  ← ACTIVE THEME
│   ├── docs/
│   │   ├── 00-INDEX.md ◄────────────────┐
│   │   ├── architecture/                │
│   │   │   ├── layout-hierarchy.md      │
│   │   │   └── component-structure.md   │
│   │   ├── components/                  │
│   │   │   ├── overview.md              │ Bidirectional
│   │   │   ├── hero.md                  │ Links Below
│   │   │   └── navigation.md            │
│   │   ├── design-comuni/               │
│   │   │   ├── pages/                   │
│   │   │   ├── blocks/                  │
│   │   │   └── implementation/          │
│   │   └── guides/                      │
│   │       ├── setup.md                 │
│   │       └── customization.md         │
│   │                                    │
│   ├── resources/                       │
│   │   ├── views/                       │
│   │   │   ├── layouts/                 │
│   │   │   ├── pages/                   │
│   │   │   ├── components/              │
│   │   │   └── blocks/                  │
│   │   ├── css/                         │
│   │   │   ├── tailwind.css             │
│   │   │   ├── app.css                  │
│   │   │   └── design-comuni.css        │
│   │   └── js/                          │
│   │       └── app.js                   │
│   │                                    │
│   ├── public/                          │
│   │   ├── images/                      │
│   │   ├── icons/                       │
│   │   └── fonts/                       │
│   │                                    │
│   ├── config/                          │
│   │   └── database/content/pages/      │
│   │       ├── homepage.json            │
│   │       ├── [slug].json              │
│   │       └── ...                      │
│   │                                    │
│   └── providers/                       │
│       └── ThemeServiceProvider.php     │
│                                        │
├── TwentyOne/                           │
│   └── (structure similar)              │
│                                        │
└── docs/  ← Theme-wide docs             │
    └── theme-development.md              │
```

---

## Data Flow: JSON-Driven Pages

```
HTTP Request: /it/tests/homepage
        │
        ▼
┌───────────────────────────────┐
│  Folio File-Based Routing     │
│  pages/tests/[slug].blade.php │
└───────┬───────────────────────┘
        │
        ▼
┌───────────────────────────────┐
│  Volt Component (mount())     │
│  Set $pageSlug = 'tests.slug' │
└───────┬───────────────────────┘
        │
        ▼
┌──────────────────────────────────────┐
│  PageSlugMiddleware                  │
│  Load from JSON config               │
│  laravel/config/local/fixcity/       │
│  database/content/pages/[slug].json  │
└───────┬──────────────────────────────┘
        │
        ▼
┌──────────────────────────────────────┐
│  Content Blocks (Multi-Block JSON)   │
│  ├─ Hero Block                       │
│  ├─ Content Block                    │
│  ├─ CTA Block                        │
│  └─ (+ 44+ custom block types)       │
└───────┬──────────────────────────────┘
        │
        ▼
┌──────────────────────────────────────┐
│  Render Blade Components             │
│  @component('hero', $block)          │
│  @component('content', $block)       │
└───────┬──────────────────────────────┘
        │
        ▼
   HTTP Response
```

---

## Filament Admin Panel Structure

```
┌────────────────────────────────────────┐
│     Filament Admin Panel (/admin)      │
└────────────────────────────────────────┘

Admin Panel
├── Resources (Module-based)
│   ├── CMS Resources
│   │   ├── PageResource
│   │   ├── BlockResource
│   │   └── CategoryResource
│   │
│   ├── User Resources
│   │   ├── UserResource
│   │   └── RoleResource
│   │
│   ├── Media Resources
│   │   ├── MediaResource
│   │   └── FolderResource
│   │
│   ├── Activity Resources
│   │   └── ActivityLogResource
│   │
│   └── (+ more by module)
│
├── Pages (Custom)
│   ├── Dashboard
│   ├── Reports
│   └── Settings
│
├── Widgets
│   ├── StatsWidgets
│   ├── ChartsWidgets
│   └── RecentActivityWidget
│
└── Navigation Structure
    ├── CMS Group
    ├── Users Group
    ├── Media Group
    └── Settings Group
```

---

## Request Lifecycle

```
1. HTTP Request
   ├─ URL: http://fixcity.local/it/tests/homepage
   └─ Method: GET

2. Routing (Folio)
   ├─ Match: pages/tests/[slug].blade.php
   └─ Slug: homepage

3. Component Initialization (Volt)
   ├─ Mount $pageSlug = 'tests.homepage'
   └─ Load component state

4. Middleware Chain
   ├─ PageSlugMiddleware
   │  ├─ Read APP_URL → fixcity.local
   │  ├─ Extract domain → fixcity.local
   │  ├─ Reverse parts → [local, fixcity]
   │  ├─ Build config path → local/fixcity
   │  ├─ Load theme: Sixteen
   │  └─ Load JSON: pages/homepage.json
   │
   └─ Other middleware (auth, cors, etc)

5. Data Loading
   ├─ Parse JSON content blocks
   ├─ Transform block data
   └─ Pass to component view

6. View Rendering
   ├─ Iterate content blocks
   ├─ Render each block component
   ├─ Compile Tailwind CSS
   └─ Generate Alpine.js directives

7. Response
   ├─ HTML output
   ├─ Livewire JS payloads
   └─ Assets (CSS, JS)

8. Browser
   ├─ Render HTML
   ├─ Load assets
   └─ Initialize Alpine.js interactivity
```

---

## Type Safety & Validation Flow

```
┌──────────────────────────┐
│  PHPStan Level 10 Check  │
└────────┬─────────────────┘
         │
    ┌────▼──────────────┐
    │ Missing Types?    │
    │ (properties)      │
    └─┬──────────────┬──┘
      │ YES          │ NO
      ▼              ▼
   ❌ FAIL      ┌────────────┐
               │ Add Types  │
               │ to all     │
               │ props      │
               └────┬───────┘
                    │
              ┌─────▼──────────┐
              │ Missing Return │
              │ Types?         │
              └─┬──────────┬───┘
                │ YES      │ NO
                ▼          ▼
             ❌ FAIL   ┌─────────┐
                      │ Check   │
                      │ Traits  │
                      └────┬────┘
                           │
                      ┌────▼─────────┐
                      │ Traits have  │
                      │ @method      │
                      │ annotations? │
                      └─┬────────┬───┘
                        │ YES    │ NO
                        ▼        ▼
                       ✅ PASS  ❌ FAIL
```

---

## Module Internal Structure

```
Modules/ModuleName/
│
├── app/
│   ├── Actions/
│   │   ├── CreateAction.php
│   │   ├── UpdateAction.php
│   │   └── DeleteAction.php
│   │   
│   │   (Single responsibility, QueueableAction pattern)
│   │   (NO Service classes!)
│   │
│   ├── Filament/
│   │   ├── Resources/
│   │   │   └── XxxResource.php
│   │   │       ├── getFormSchema()
│   │   │       ├── getTableColumns()
│   │   │       └── getActions()
│   │   │
│   │   └── Pages/
│   │       ├── CreatePage.php
│   │       ├── EditPage.php
│   │       └── ListPage.php
│   │
│   ├── Models/
│   │   ├── Xxx.php
│   │   ├── Yyy.php
│   │   └── (Traits for shared behavior)
│   │
│   └── Traits/
│       ├── HasTimestamps.php
│       ├── HasActivity.php
│       └── (Shared trait methods)
│
├── database/
│   ├── migrations/
│   │   └── CreateXxxTable.php
│   │
│   └── seeders/
│       └── XxxSeeder.php
│
├── docs/
│   ├── 00-INDEX.md
│   ├── architecture/
│   ├── guides/
│   └── reference/
│
├── routes/
│   └── web.php (if module routes)
│
├── tests/
│   ├── Unit/
│   ├── Feature/
│   └── (Pest format)
│
└── composer.json
```

---

## See Also

- [→ Module Documentation Index](MODULE_DOCS_INDEX.md)
- [→ Theme Documentation Index](THEMES_DOCUMENTATION_INDEX.md)
- [→ Component Catalog](../laravel/Themes/Sixteen/docs/COMPONENT_CATALOG.md)
- [→ Filament Integration Guide](../laravel/Themes/Sixteen/docs/filament-integration.md)
- [→ Data Flow Analysis](COMPREHENSIVE_CODE_ANALYSIS.md#data-flow)

---

**Last Updated:** See git history  
**Diagram Type:** ASCII Architecture Diagrams  
**Related Docs:** 15+ connected documentation files  
**Cross-Module:** Xot, Cms, Tenant, Media, Filament, Themes
