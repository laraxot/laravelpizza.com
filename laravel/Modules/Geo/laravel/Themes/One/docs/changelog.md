---
title: Changelog — One Theme
module: One
type: reference
status: approved
tags: [version, history, releases, changelog]
updated: "2026-06-18"
related:
  - README.md
  - ../README.md
  - ../../../Zero/docs/changelog.md
---

# Changelog — One Theme

Version history for One theme (skeleton/starter theme). Follows Semantic Versioning (MAJOR.MINOR.PATCH).

## Release Strategy

- **Semantic Versioning**: MAJOR.MINOR.PATCH (e.g., 1.0.0)
- **Source**: Git tags + conventional commits
- **Documentation**: Maintained in this file + root CHANGELOG.md
- **Breaking changes**: Always marked with ⚠️ emoji
- **Note**: One is a **skeleton theme** — no built-in CSS build, intentionally minimal

## Current Version

**v1.0.0** — Released 2026-06-18

- Minimal skeleton theme for Laraxot PTVX
- Core Blade components (layouts, navigation)
- Page block structure (mirrors Zero for migration)
- No asset build (Vite, Tailwind, NPM) — projects configure their own
- Designed for custom development

## Version History

### v1.0.0 — 2026-06-18

**Initial Release**

**Purpose:**
One is a **starter scaffold** for projects building custom frontends. Unlike Zero (complete implementation), One provides only the Blade template structure.

**What's Included:**
- Blade component framework
  - App layout (`<x-app-layout>`)
  - Navigation system (`<x-navigation>`, `<x-nav-link>`, `<x-responsive-nav-link>`)
  - Page block stubs (`<x-blocks.*>`)
  - Layout wrapper (`<x-layouts.main>`)
  
- Documentation
  - Architecture guide
  - Component naming conventions
  - Customization patterns
  - Agent discipline rules

**What's NOT Included:**
- ✗ No `package.json` (no Vite, no Tailwind, no Asset build)
- ✗ No CSS files (projects provide their own)
- ✗ No JavaScript/Alpine.js (optional via project)
- ✗ No Filament resources (guidance provided in docs)
- ✗ No pre-built components (Flowbite, etc.)

**Components (Structure):**
- `<x-app-layout>` — Main authenticated layout (wrapper only)
- `<x-guest-layout>` — Guest/login layout (wrapper only)
- `<x-navigation>` — Navigation bar (no styling, semantic HTML)
- `<x-nav-link>` — Single nav link (no styling)
- `<x-responsive-nav-link>` — Mobile nav link (no styling)
- `<x-blocks.hero.main>` — Hero section placeholder
- `<x-blocks.features.grid>` — Features grid placeholder
- `<x-blocks.cta.banner>` — CTA section placeholder
- `<x-blocks.testimonials.carousel>` — Testimonials placeholder
- `<x-blocks.stats.overview>` — Stats section placeholder
- `<x-blocks.sidebar.quick-links>` — Sidebar links placeholder
- `<x-layouts.main>` — Main layout wrapper

**Rationale for Minimalism:**
- One project uses Bootstrap, another Tailwind, another custom CSS
- Forcing a CSS framework would limit flexibility
- Better to provide semantic HTML + documentation
- Projects can adopt Zero's styling as-is or customize freely

**Documentation:**
- `README.md` — Theme overview
- `component-guide.md` — Component reference (no styling)
- `customization.md` — How to extend (without Vite/Tailwind)
- `naming-conventions.md` — Coding standards (shared with Zero)
- `architecture-rules.md` — Governance rules

**Targeted Use Cases:**
- API-only backend with separate frontend (Vue, React, Next.js)
- Traditional server-side rendering (plain CSS, Bootstrap, UIKit)
- Custom design system project (Storybook integration)
- Headless CMS integration
- Progressive enhancement with minimal JavaScript

**Known Limitations:**
- No out-of-the-box styling (intentional)
- No responsive utilities built-in
- Dark mode unsupported (projects add if needed)
- RTL language support not included
- Accessibility hints provided, but implementation is per-project

**Relation to Zero:**
- **Same**: Component names, slot signatures, props structure
- **Different**: Zero has styling, One doesn't
- **Migration**: Moving from One to Zero is additive (no breaking changes)

---

## Component Lifecycle

### Introduced in v1.0.0

| Component | Status | Type | File |
|-----------|--------|------|------|
| `<x-app-layout>` | Active | Layout wrapper | `resources/views/components/layouts/app.blade.php` |
| `<x-guest-layout>` | Active | Layout wrapper | `resources/views/components/layouts/guest.blade.php` |
| `<x-navigation>` | Active | Navigation | `resources/views/components/navigation.blade.php` |
| `<x-nav-link>` | Active | Navigation | `resources/views/components/nav-link.blade.php` |
| `<x-responsive-nav-link>` | Active | Navigation | `resources/views/components/responsive-nav-link.blade.php` |
| `<x-blocks.hero.main>` | Active | Block | `resources/views/components/blocks/hero/main.blade.php` |
| `<x-blocks.features.grid>` | Active | Block | `resources/views/components/blocks/features/grid.blade.php` |
| `<x-blocks.cta.banner>` | Active | Block | `resources/views/components/blocks/cta/banner.blade.php` |
| `<x-blocks.testimonials.carousel>` | Active | Block | `resources/views/components/blocks/testimonials/carousel.blade.php` |
| `<x-blocks.stats.overview>` | Active | Block | `resources/views/components/blocks/stats/overview.blade.php` |
| `<x-blocks.sidebar.quick-links>` | Active | Block | `resources/views/components/blocks/sidebar/quick-links.blade.php` |
| `<x-layouts.main>` | Active | Wrapper | `resources/views/components/layouts/main.blade.php` |

### Deprecated Components

None yet.

---

## Breaking Changes

None in v1.0.0. One is new and stable.

**Future considerations (v2.0+):**
- Possible: Slot signature changes for clarity
- Possible: Component reorganization for clarity
- Possible: New block types addition (non-breaking)

---

## Dependency Strategy

One theme has **NO runtime dependencies**:

- ✗ No `composer.json` per-theme (inherits from Laraxot PTVX)
- ✗ No `package.json` (no npm packages)
- ✓ Requires: PHP 8.0+ (Laravel standard)
- ✓ Requires: Laravel 10+ (Laraxot PTVX baseline)

**Projects extending One must provide:**
1. CSS framework (Tailwind, Bootstrap, custom)
2. JavaScript framework (Alpine, Vue, React, or none)
3. Asset bundler (Vite, Webpack, or none)

---

## Release Checklist

When preparing a release:

- [ ] Verify all Blade components are in `resources/views/`
- [ ] Verify no unintended CSS/JS files in package
- [ ] Update version in root `README.md` (if it exists)
- [ ] Update `CHANGELOG.md` (this file) with new version
- [ ] Update `docs/README.md` with index of new docs (if added)
- [ ] Run PHPStan level 10 (if checking syntax)
- [ ] Run Blade linter/formatting check
- [ ] Create git tag: `git tag -a v1.0.0 -m "Release v1.0.0"`
- [ ] Push to remote: `git push origin v1.0.0`

---

## Migration from One to Zero

If a project using One wants to adopt Zero's styling:

1. **Copy Tailwind + Vite setup** from Zero's `package.json`
2. **Copy Tailwind config** from Zero's `tailwind.config.js`
3. **Copy CSS imports** from Zero's `resources/css/app.css`
4. **Component names** stay the same (no refactoring needed)
5. **Props/slots** are compatible (no breaking changes)

Example:
```bash
# One: minimal, no styling
<x-navigation :menu="$menu" />

# Zero: same component, with Tailwind styling
<x-navigation :menu="$menu" />  <!-- CSS classes added by Zero's setup -->
```

---

## Migration from Zero to One

If a project using Zero wants to strip styling:

1. **Keep all component Blade files** (they work standalone)
2. **Remove Tailwind classes** from components
3. **Remove `package.json` & build tools**
4. **Document your CSS solution** in project README

Components will still work with custom CSS.

---

## FAQ: One vs Zero

**Q: Which theme should I use?**
A: Use **Zero** if you like the included styling. Use **One** if you want to provide your own CSS/design.

**Q: Can I mix One and Zero?**
A: Yes. Components are compatible. One + Zero styling = same result.

**Q: Is One maintained?**
A: Yes, One is an official theme alongside Zero.

**Q: Can One use Tailwind?**
A: Yes, projects can add Tailwind to One. It's just not included by default.

**Q: How do I add Filament to One?**
A: Filament is separate from the theme. Follow [Filament installation guide](https://filamentphp.com/docs/installation).

---

## Related Files

- [README.md](./README.md) — Theme overview
- [Component Guide](./component-guide.md) — Components reference
- [Customization Guide](./customization.md) — How to extend
- [../README.md](../README.md) — Root theme README
- [../../Zero/docs/changelog.md](../../../Zero/docs/changelog.md) — Zero version history
- [../../../../docs/wiki/themes/](../../../../docs/wiki/themes/) — Project-wide theme docs
