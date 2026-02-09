# Task: Full Site Replication and Alignment

## Objective
Bring the local `Meetup` theme frontend as close as possible to the target site (`https://laravelpizza.com/`), achieving pixel-parity in design and matching content. This task must strictly adhere to the project's Laraxot architecture.

**Local site URL**: Resolved via APP_URL + Tenant config. Typically `http://127.0.0.1:8000/{locale}`.
**Theme path**: `laravel/Themes/Meetup/` (resolved via `.env` → Tenant → `xra.php` → `pub_theme`).

## Core Architectural Principles
- **DO NOT** use traditional controllers or custom routes in `web.php` for public-facing pages
- **ALL** content pages are driven by Folio and defined by `.json` files in `laravel/config/local/laravelpizza/database/content/pages/{slug}.json`
- **ALL** section data (header, footer) lives in `laravel/config/local/laravelpizza/database/content/sections/{slug}.json`
- **ALL** page structure is built from `content_blocks` which map to Blade components in `laravel/Themes/Meetup/resources/views/components/blocks/`
- **SVG icons**: Files in `Modules/Meetup/resources/svg/`, invoked via `<x-filament::icon icon="meetup-{name}" />`. NO inline SVG in Blade.
- **URLs**: Always use `LaravelLocalization::localizeUrl('/path')`. Never hardcode locale prefix.
- **Many-to-many relations**: Always `$this->belongsToManyX()`, never `belongsToMany()`.

## Mission: ELEVATION, NOT JUST REPLICATION
We're not just copying - we're **ELEVATING** the original site to be MORE COOL, MORE ENGAGING, MORE VIRAL.

## Pre-Task Study (Mandatory)
Before making any changes, study the existing documentation:

1. **Theme Documentation**: `laravel/Themes/Meetup/docs/`
2. **CMS Module Documentation**: `laravel/Modules/Cms/docs/` (Section.php, content blocks)
3. **Other Modules**: `Modules/Lang/docs/`, `Modules/UI/docs/`, `Modules/Xot/docs/`
4. **Reference Plan**: `laravel/Themes/Meetup/docs/replikate/replicate.md`

## Step-by-Step Implementation Plan

### Step 1: Core Component Entrypoints

**Header & Footer** are loaded via `<x-section slug="header" />` and `<x-section slug="footer" />`.
- Investigate `laravel/Modules/Cms/app/View/Components/Section.php` for slug → view resolution
- Correct any incorrect naming or view paths
- Ensure no hardcoded theme prefixes (e.g., `two::...`)

### Step 2: Achieve Visual Parity

**Color Palette (from actual target screenshots Feb 2026)**:
- **Background Primary**: #0f172a (Tailwind slate-900) — nav, hero, page bg
- **Background Darker**: #0b1120 (~slate-950) — footer
- **Card Background**: #1e293b (slate-800) — feature cards
- **Accent/CTA**: #dc2626 (Tailwind red-600) — buttons, highlights, accent text
- **Text Primary**: #ffffff (white) — headings
- **Text Secondary**: #9ca3af (gray-400) — body text
- **Text Muted**: #6b7280 (gray-500) — copyright, subtle text
- **Border**: #334155 (slate-700) — dividers on dark bg

**Method**:
- Use Tailwind CSS classes only. No custom or inline styles.
- Match contrast, spacing, and structure of target.

**Localization**:
- All URLs via `LaravelLocalization::localizeUrl('/path')`
- Language selector via `LaravelLocalization::getLocalizedURL($code, null, [], true)`
- Current locale via `LaravelLocalization::getCurrentLocale()`

### Step 3: Content and Block Alignment

**Homepage structure (from actual target)**:
1. **Hero** → `pub_theme::components.blocks.hero.main` — dark bg, pizza icon, two-tone title, dual CTAs
2. **Features** → `pub_theme::components.blocks.features.grid` — "Why Join Our Community?" with icon cards
3. **CTA Banner** → `pub_theme::components.blocks.cta.banner` — red banner "Ready to Join?"

**Content source**: `laravel/config/local/laravelpizza/database/content/pages/home.json`

**Content validation**:
- ALL content must be LaravelPizza-specific (meetups, community, Laravel development)
- NEVER content from other businesses ("Marco Sottana", "Consulenza Sicurezza", medical terms)
- NEVER content from other projects (TechPlanner, etc.)

### Step 4: Verification and Reporting

**Visuals**: Before/after screenshots for header, footer, hero, features, CTA.

**Gap Analysis**: Create/update report in `laravel/Themes/Meetup/docs/` detailing:
- What is completed vs. still missing
- Recommendations for improvements (SEO, accessibility, marketing)

**Pages to verify** (desktop + mobile):
- Homepage: `/{locale}`
- Events, About, Contact, etc.

## Critical Architecture Rules

1. **NO controllers** — Folio + Volt + JSON CMS-driven pages only
2. **Content in JSON** — pages in `pages/{slug}.json`, sections in `sections/{slug}.json`
3. **SVG icons** — `Modules/Meetup/resources/svg/` + `<x-filament::icon icon="meetup-{name}" />`
4. **Localized URLs** — `LaravelLocalization::localizeUrl()` always
5. **XotBase extension** — Filament classes extend XotBase* abstracts
6. **Theme build** — `npm run build && npm run copy` from `Themes/Meetup/` after CSS/JS changes
7. **belongsToManyX** — never use plain `belongsToMany()` for M2M relations
8. **No inline SVG** — never paste SVG markup in Blade
9. **No property_exists()** — use `isset()` or `hasAttribute()` on models

## Common Errors to Avoid

- Wrong content domain (medical/safety content instead of Laravel meetups)
- Wrong colors (#1e3a5f navy instead of correct #0f172a slate-900 + #dc2626 red)
- Hardcoding URLs without `LaravelLocalization::localizeUrl()`
- Creating controllers for public pages
- Inline SVG in Blade (must use file + icon component)
- Extending Filament classes directly (must use XotBase*)
- Forgetting `npm run build && npm run copy` after theme changes
- Not updating documentation after changes

## Improvements Over Target

1. **Performance**: Lazy loading, optimized SVGs, minimal JS
2. **Animations**: Scroll animations via Alpine.js + Intersection Observer
3. **Accessibility**: WCAG 2.1 AA, ARIA labels, keyboard navigation
4. **SEO**: Schema.org JSON-LD, heading hierarchy, meta tags, hreflang
5. **Multilingual**: Content in JSON + lang files, language switcher
6. **AdSense Ready**: Non-intrusive ad placement areas
7. **Inbound Marketing**: Newsletter, event registration CTAs
8. **Mobile First**: Touch-friendly, responsive design
9. **Microinteractions**: Hover effects, smooth transitions

---

*For specific design details, refer to `replicate.md` in this directory.*
