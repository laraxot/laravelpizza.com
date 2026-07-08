---
name: Epic 1 - Foundation & Homepage
about: Epic issue for tracking Foundation & Homepage phase
title: 'Epic #1: Foundation & Homepage - Design Comuni Replication'
labels: ['epic', 'design-comuni', 'priority-high']
assignees: ''
milestone: 'v1.0 - Design Comuni Replication'
---

## Epic Overview
Replicate the Design Comuni homepage achieving 100% HTML and visual parity with the original template.

**Source**: https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html  
**Target**: http://fixcity.local/it/tests/homepage  
**Timeline**: Weeks 1-2 (April 1-14, 2026)  
**Status**: 🟡 IN PROGRESS

---

## Objectives

### Primary Goal
Achieve 100% HTML parity (inside `<body>` tag, excluding scripts) between:
- ✅ Source: `view-source:https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html`
- ✅ Target: `view-source:http://fixcity.local/it/tests/homepage`

### Secondary Goals
1. Header matches exactly (colors, spacing, logo, navigation)
2. Footer matches exactly (all sections, contacts, social links)
3. Main content sections match (hero, topics, news, events, services)
4. Visual appearance is pixel-perfect
5. Responsive design works on mobile, tablet, desktop
6. WCAG 2.1 AA accessibility compliance
7. Lighthouse scores >90 (all categories)

---

## Technical Requirements

### Architecture
- [ ] Use `<x-layouts.app>` (NOT `<x-layouts.design-comuni>`)
- [ ] Use `<x-section slug="header" />` for header
- [ ] Use `<x-section slug="footer" />` for footer
- [ ] Use single `[slug].blade.php` with Folio + Volt
- [ ] Use JSON content blocks (NOT hardcoded HTML)
- [ ] Use Tailwind @apply (NOT Bootstrap Italia CDN)

### File Structure
```
laravel/Themes/Sixteen/
├── resources/
│   ├── views/
│   │   ├── pages/
│   │   │   └── tests/
│   │   │       └── [slug].blade.php          # Single dynamic route
│   │   ├── components/
│   │   │   └── blocks/
│   │   │       ├── header/
│   │   │       │   └── main.blade.php        # Universal header
│   │   │       └── footer/
│   │   │           └── full.blade.php        # Universal footer
│   │   └── components/layouts/
│   │       ├── main.blade.php                # Base HTML structure
│   │       └── app.blade.php                 # Public frontend wrapper
│   └── css/
│   │       └── style-apply.css               # Tailwind @apply styles
└── docs/
    ├── HEADER_FOOTER_ARCHITECTURE.md         # Header/footer patterns
    └── screenshots/
        └── homepage-comparison.md            # Screenshot analysis
```

### JSON Content Structure
```json
{
  "slug": "tests.homepage",
  "title": "Homepage - Comune di FixCity",
  "meta_description": "Sito ufficiale del Comune di FixCity",
  "blocks": [
    {
      "type": "header",
      "view": "pub_theme::components.blocks.header.main",
      "data": {
        "institution_name": "Comune di FixCity",
        "tagline": "Un comune da vivere",
        "logo_url": "/themes/sixteen/images/logo.svg"
      }
    },
    {
      "type": "hero",
      "view": "pub_theme::components.blocks.hero.default",
      "data": {
        "title": "Benvenuto nel Comune di FixCity",
        "subtitle": "Scopri i servizi, le novità e le opportunità",
        "background_image": "/images/hero-bg.jpg"
      }
    },
    {
      "type": "topics-grid",
      "view": "pub_theme::components.blocks.topics-grid.default",
      "data": { ... }
    },
    {
      "type": "footer",
      "view": "pub_theme::components.blocks.footer.full",
      "data": { ... }
    }
  ]
}
```

---

## Child Issues

### Component Issues
- [ ] #2 - Component: Header Main (Universal)
- [ ] #3 - Component: Footer Full (Universal)
- [ ] #4 - Component: Hero Section
- [ ] #5 - Component: Topics Grid
- [ ] #6 - Component: News Card
- [ ] #7 - Component: Event Card
- [ ] #8 - Component: Service Card

### Implementation Issues
- [ ] #9 - Create tests.homepage.json content file
- [ ] #10 - Achieve HTML parity for homepage
- [ ] #11 - Achieve visual parity for homepage
- [ ] #12 - Create screenshot comparison analysis
- [ ] #13 - Accessibility audit for homepage
- [ ] #14 - Performance optimization for homepage

---

## Acceptance Criteria

### Code Quality
- [ ] PHPStan Level 10 compliance (no errors)
- [ ] Pint code style (PSR-12)
- [ ] Pest test coverage >80%
- [ ] No duplicate code (DRY principle)
- [ ] Simple, readable code (KISS principle)

### Design Quality
- [ ] HTML inside `<body>` is 100% identical to source (excluding scripts)
- [ ] Visual appearance matches 100% (colors, spacing, typography)
- [ ] Header uses correct Bootstrap Italia classes (replicated with Tailwind @apply)
- [ ] Footer uses correct Bootstrap Italia classes (replicated with Tailwind @apply)
- [ ] Responsive design works on mobile (320px), tablet (768px), desktop (1200px)
- [ ] WCAG 2.1 AA accessibility compliance (color contrast, keyboard navigation, ARIA labels)
- [ ] Lighthouse scores: Performance >90, Accessibility >90, Best Practices >90, SEO >90

### Documentation
- [ ] Header/footer architecture documented
- [ ] Screenshot comparison analysis created
- [ ] Component catalog updated
- [ ] JSON structure documented
- [ ] Developer guide updated

---

## Screenshot Comparison Requirements

### Header Analysis
Create side-by-side screenshots comparing:
1. **Slim header** (top bar with language selector, login)
2. **Brand section** (logo, institution name, tagline)
3. **Social links** (Twitter, Facebook, YouTube, Instagram, LinkedIn)
4. **Search button** (icon, hover state)
5. **Navigation bar** (menu items, hover states)

**File**: `Themes/Sixteen/docs/screenshots/homepage-header-comparison.png`  
**Analysis**: `Themes/Sixteen/docs/screenshots/homepage-header-analysis.md`

### Footer Analysis
Create side-by-side screenshots comparing:
1. **Contact section** (address, phone, email)
2. **Useful links** (administration, services, news)
3. **Social media** (icons, links)
4. **Legal info** (privacy policy, cookies, credits)

**File**: `Themes/Sixteen/docs/screenshots/homepage-footer-comparison.png`  
**Analysis**: `Themes/Sixteen/docs/screenshots/homepage-footer-analysis.md`

### Main Content Analysis
Create side-by-side screenshots comparing:
1. **Hero section** (title, subtitle, background)
2. **Topics grid** (cards, icons, colors)
3. **Latest news** (news cards layout)
4. **Upcoming events** (event cards layout)
5. **Services** (service cards layout)

**File**: `Themes/Sixteen/docs/screenshots/homepage-content-comparison.png`  
**Analysis**: `Themes/Sixteen/docs/screenshots/homepage-content-analysis.md`

---

## Testing Strategy

### Visual Regression Tests
```php
// tests/Browser/Pages/HomepageTest.php
it('matches Design Comuni homepage screenshot', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/it/tests/homepage')
                ->waitFor('@header')
                ->waitFor('@footer')
                ->assertScreenshot('homepage-desktop');
    });
});

it('is responsive on mobile', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/it/tests/homepage')
                ->resize(375, 812) // iPhone X
                ->assertScreenshot('homepage-mobile');
    });
});
```

### Accessibility Tests
```php
// tests/Browser/Accessibility/HomepageTest.php
it('passes WCAG 2.1 AA audit', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/it/tests/homepage')
                ->assertAccessibility('wcag2aa');
    });
});

it('has correct color contrast', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/it/tests/homepage')
                ->assertColorContrast();
    });
});

it('supports keyboard navigation', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/it/tests/homepage')
                ->assertKeyboardAccessible();
    });
});
```

### Performance Tests
```php
// tests/Browser/Performance/HomepageTest.php
it('loads in under 2 seconds', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/it/tests/homepage')
                ->assertLoadTimeLessThan(2000);
    });
});

it('achieves Lighthouse score >90', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/it/tests/homepage')
                ->assertLighthouseScore(90);
    });
});
```

---

## Definition of Done

- [ ] All child issues completed
- [ ] HTML parity verified (side-by-side comparison)
- [ ] Visual parity verified (screenshot analysis)
- [ ] Accessibility audit passed (WCAG 2.1 AA)
- [ ] Performance audit passed (Lighthouse >90)
- [ ] All tests passing (Pest + Browser)
- [ ] Documentation complete (bidirectional links)
- [ ] Code reviewed and approved
- [ ] Deployed to staging
- [ ] Stakeholder approval

---

## References

### Design References
- **Design Comuni Homepage**: https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html
- **Bootstrap Italia Header**: https://italia.github.io/bootstrap-italia/docs/componenti/header/
- **Bootstrap Italia Footer**: https://italia.github.io/bootstrap-italia/docs/componenti/footer/
- **Tailwind CSS**: https://tailwindcss.com/docs
- **DaisyUI**: https://daisyui.com/components/

### Technical References
- **Laravel Folio**: https://laravel.com/docs/12.x/folio
- **Livewire Volt**: https://livewire.laravel.com/docs/volt
- **Alpine.js**: https://alpinejs.dev/
- **WCAG 2.1 AA**: https://www.w3.org/WAI/WCAG21/quickref/

### Documentation
- **Roadmap**: `.planning/ROADMAP.md`
- **Research**: `.planning/research/design-comuni-pages.md`
- **Block Analysis**: `_bmad-output/design-comuni-block-analysis.md`
- **Architecture**: `_bmad-output/design-comuni-architecture.md`

---

## Progress Tracking

| Week | Dates | Tasks | Status |
|------|-------|-------|--------|
| 1 | Apr 1-7 | Fix Livewire errors, create research, start header | 🟡 In Progress |
| 2 | Apr 8-14 | Complete header, footer, main content, tests | ⚪ Pending |

**Current Status**: 🟡 In Progress  
**Last Updated**: April 1, 2026  
**Next Milestone**: April 14, 2026 (Phase 1 complete)

---

## Comments

<!-- GitHub comments will be added here -->
