# Auth Pages UI/UX Guidelines

## Overview

This document defines the design standards for authentication pages (login, register, password reset).

## Layout Principles

### Mobile-First
- Form always full-width on mobile/tablet
- Side-by-side layout only on desktop (>1024px)
- Touch targets minimum 44×44px

### Responsive Breakpoints
```css
/* Mobile: 0-639px */
.sm: /* 640px+ */
.md: /* 768px+ */
.lg: /* 1024px+ */
.xl: /* 1280px+ */
```

## Color Palette

| Purpose | Color | Usage |
|---------|-------|-------|
| Primary | red-500/red-600 | CTAs, accents |
| Background | slate-900/slate-800 | Dark mode |
| Surface | slate-800/white | Cards, forms |
| Text | white/slate-300 | Content |
| Muted | slate-400/slate-500 | Secondary |

## Typography

- Headings: `font-extrabold`, `tracking-tight`
- Body: `text-base`, `leading-relaxed`
- Mobile: Smaller sizes, tighter spacing

## Animations

### Allowed
- Subtle fade-in on load
- Hover transitions (scale, color)
- Focus ring animations

### Forbidden (WCAG)
- Flashing/blinking >3Hz
- Unnecessary movement
- No `prefers-reduced-motion` support

## Form Design

### Fields
- Full-width on mobile
- Clear labels above inputs
- Error messages below fields
- Password visibility toggle

### Buttons
- Primary: Full-width on mobile
- Minimum height 44px (touch target)
- Clear focus states

## Trust Signals

### Use Instead of Fake Numbers
- ✅ Trust badges with real benefits
- ✅ Security icons (lock, shield)
- ✅ Privacy compliance indicators

### Never Use
- ❌ "5,000+ members" (fake)
- ❌ "100+ meetups" (fake)
- ❌ "24/7 support" (unverified)

## Accessibility (WCAG 2.2)

### Requirements
- [ ] Color contrast 4.5:1 minimum
- [ ] Focus visible indicators
- [ ] Keyboard navigation
- [ ] ARIA labels
- [ ] Form labels associated
- [ ] Error messages linked

### ARIA Pattern
```html
<main role="main" aria-labelledby="heading-id">
  <form aria-labelledby="form-heading">
    <label for="email">Email</label>
    <input id="email" aria-describedby="email-error">
    <span id="email-error" role="alert"></span>
  </form>
</main>
```

## SEO Requirements

### Meta Tags
- Unique title per page
- Description from translation
- Canonical URL

### Structure
- Single `<h1>` per page
- Logical heading hierarchy
- Semantic HTML5 tags

## Files

```
Themes/Meetup/resources/views/pages/auth/
├── login.blade.php
├── register.blade.php
└── password/
```

## Related Docs
- [WCAG Guidelines](./wcag.md)
- [SEO Guidelines](./seo.md)
- [GDPR Compliance](./gdpr-compliance.md)
