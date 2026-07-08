---
title: Changelog — Zero Theme
module: Zero
type: reference
status: approved
tags: [version, history, releases, changelog]
updated: "2026-06-18"
related:
  - README.md
  - ../README.md
---

# Changelog — Zero Theme

Version history for Zero theme. Follows Semantic Versioning (MAJOR.MINOR.PATCH).

## Release Strategy

- **Semantic Versioning**: MAJOR.MINOR.PATCH (e.g., 1.2.3)
- **Source**: Git tags + conventional commits
- **Auto-generation**: Potential via `.releaserc.json` (commitizen)
- **Documentation**: Maintained in this file + root CHANGELOG.md
- **Breaking changes**: Always marked with ⚠️ emoji

## Current Version

**v1.0.0** — Released 2026-06-18

- Full-featured frontend theme for Laraxot PTVX
- Tailwind CSS 3.4.17 + Flowbite 1.8.1
- Alpine.js 3.13.5 for interactivity
- Vite 6.3.3 for asset bundling
- Responsive navigation + page blocks

## Version History

### v1.0.0 — 2026-06-18

**Initial Release**

**Features:**
- Complete frontend implementation
- Responsive navigation system
  - Desktop nav with Flowbite integration
  - Mobile-responsive hamburger menu (Alpine.js)
  - Active link highlighting
- Page layouts
  - App layout (authenticated views)
  - Guest layout (auth pages)
  - Main layout wrapper
- Page blocks system
  - Hero section with background image
  - Features grid
  - CTA (Call-to-Action) banner
  - Testimonials carousel (if implemented)
  - Stats overview section
  - Sidebar quick-links
- Filament admin theme integration
  - Custom login page styling
  - Auth flow customization
- Tailwind utilities
  - @tailwindcss/forms plugin
  - @tailwindcss/typography plugin
  - Flowbite pre-built components

**Components (Initial):**
- `<x-app-layout>` — Main authenticated layout
- `<x-guest-layout>` — Guest/login layout
- `<x-navigation>` — Main navigation bar
- `<x-nav-link>` — Single navigation link
- `<x-responsive-nav-link>` — Mobile-responsive nav link
- `<x-blocks.hero.main>` — Hero section
- `<x-blocks.features.grid>` — Features grid
- `<x-blocks.cta.banner>` — CTA banner
- `<x-blocks.testimonials.carousel>` — Testimonials (if present)
- `<x-blocks.stats.overview>` — Stats section
- `<x-blocks.sidebar.quick-links>` — Sidebar links
- `<x-ui.logo>` — Logo component

**Dependencies:**
- `tailwindcss@3.4.17`
- `@tailwindcss/forms@0.5.9`
- `@tailwindcss/typography@0.5.14`
- `flowbite@1.8.1`
- `alpine@3.13.5`
- `vite@6.3.3`
- `laravel-vite-plugin@1.0.0`
- `postcss@8.4.48`

**Documentation:**
- `README.md` — Theme overview
- `components.md` — Component reference
- `customization.md` — Customization guide
- `naming-conventions.md` — Coding standards
- `architecture.md` — Theme architecture
- `philosophy.md` — Design philosophy

**Quality:**
- PHPStan level 10 compliance
- PSR-12 coding standards
- Blade best practices
- Accessibility considerations (WCAG 2.1)

**Known Limitations:**
- Dark mode support documented but not fully implemented
- RTL (right-to-left) language support not included
- CSS-in-JS solutions (Emotion, Styled Components) not supported
- Server-side rendering (SSR) not applicable for frontend theme

---

## Component Lifecycle

### Introduced in v1.0.0

| Component | Status | File |
|-----------|--------|------|
| `<x-app-layout>` | Active | `resources/views/components/layouts/app.blade.php` |
| `<x-guest-layout>` | Active | `resources/views/components/layouts/guest.blade.php` |
| `<x-navigation>` | Active | `resources/views/components/navigation.blade.php` |
| `<x-nav-link>` | Active | `resources/views/components/nav-link.blade.php` |
| `<x-responsive-nav-link>` | Active | `resources/views/components/responsive-nav-link.blade.php` |
| `<x-blocks.hero.main>` | Active | `resources/views/components/blocks/hero/main.blade.php` |
| `<x-blocks.features.grid>` | Active | `resources/views/components/blocks/features/grid.blade.php` |
| `<x-ui.logo>` | Active | `resources/views/components/ui/logo.blade.php` |

### Deprecated Components

None yet.

---

## Breaking Changes

### Migration Guide: Future (v2.0.0)

If major version bump occurs, breaking changes will be documented here.

**Expected breaking changes for v2.0:**
- Possible: Component slot renames for clarity
- Possible: Tailwind config consolidation
- Possible: Alpine event handler standardization

---

## Dependency Updates

### Tailwind CSS
- **Latest**: 3.4.17
- **Next major**: Tailwind 4.0 (breaking changes expected)
- **Migration path**: See `customization.md` for overrides

### Flowbite
- **Latest**: 1.8.1
- **EOL**: Check Flowbite roadmap for deprecations
- **Alternative**: Consider Headless UI or Shadcn for custom components

### Alpine.js
- **Latest**: 3.13.5
- **Support**: Active development
- **Note**: v4.0 planned, but no breaking changes confirmed

---

## Deprecation Timeline

Current status: **No deprecations** (v1.0.0)

Future deprecations will follow this timeline:

| Component | Deprecated | Removal Target | Migration |
|-----------|-----------|-----------------|-----------|
| (None) | - | - | - |

---

## Release Checklist

When preparing a release:

- [ ] Update version in `composer.json` (if applicable)
- [ ] Update version in `package.json`
- [ ] Update `CHANGELOG.md` (this file) with new version
- [ ] Update `../README.md` with release notes (marketing)
- [ ] Update `docs/README.md` with index of new docs (if added)
- [ ] Run `npm run build` to generate optimized assets
- [ ] Run `composer audit` for security vulnerabilities
- [ ] Run tests (if applicable)
- [ ] Create git tag: `git tag -a v1.0.0 -m "Release v1.0.0"`
- [ ] Push to remote: `git push origin v1.0.0`

---

## FAQ: Versioning

**Q: How does Zero versioning relate to Laraxot PTVX?**
A: Zero theme is versioned independently. Major PTVX updates may require Zero updates, but Zero can release features on its own schedule.

**Q: Will Zero follow the same version as other themes?**
A: No. Zero, One, and Three have independent version tracks. Check each theme's CHANGELOG.md.

**Q: How do I report a bug or request a feature?**
A: Create a GitHub issue in the Laraxot PTVX repo with:
- Theme: Zero
- Type: Bug / Feature Request
- Description: Clear, minimal reproduction steps
- Expected behavior: What should happen

**Q: What's the support window for old versions?**
A: Only the latest version receives support. Patch releases (v1.0.x) are maintained for 1 year after release. Minor releases (v1.x.0) are maintained for 2 years.

---

## Security & Vulnerabilities

If a security vulnerability is discovered:

1. **Do not** open a public GitHub issue
2. Email security concerns to the maintainers
3. Wait for patch release before disclosure
4. Follow [Responsible Disclosure Policy](../../../docs/wiki/security/responsible-disclosure.md)

Current known issues:
- None

---

## Related Files

- [README.md](./README.md) — Theme overview
- [Component Guide](./component-guide.md) — Components reference
- [Customization Guide](./customization.md) — How to extend
- [../README.md](../README.md) — Root theme README (marketing)
- [../../docs/wiki/themes/](../../../../docs/wiki/themes/) — Project-wide theme docs
