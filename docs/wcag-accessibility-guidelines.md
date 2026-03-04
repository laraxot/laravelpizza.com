# WCAG Accessibility Guidelines

## Overview

This document outlines WCAG 2.2 AA compliance standards. For technique-by-technique resolution (H44, F78, G195, H30, C8, C38, G18, H98, ARIA6) see [W3C Techniques](https://www.w3.org/WAI/WCAG21/Techniques/) and theme-specific plan in `laravel/Themes/Two/docs/wcag-techniques-resolution.md`.

## Critical Requirements

### 1. Focus Management
- All interactive elements must have visible focus indicators
- Focus order must be logical (tab order matches visual order)
- Skip links for keyboard navigation

```blade
<!-- Skip link -->
<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4">
    Skip to content
</a>

<!-- Focus visible -->
<button class="focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
    Action
</button>
```

### 2. Color Contrast
- Minimum 4.5:1 for normal text
- Minimum 3:1 for large text (18px+ bold or 24px+)
- 7:1 for AAA compliance (recommended)

### 3. Touch Targets
- Minimum 44×44px for mobile
- Adequate spacing between clickable elements

### 4. Semantic HTML
- Use proper heading hierarchy (h1 → h2 → h3)
- ARIA landmarks: main, nav, footer, aside
- Form labels always associated with inputs

```blade
<main role="main">
    <nav role="navigation" aria-label="Main">
    <form aria-labelledby="form-title">
        <label for="email">Email</label>
        <input id="email" type="email" aria-required="true">
    </form>
</main>
```

### 5. Error Handling
- Clear error messages
- Associated with form fields via aria-describedby
- aria-live for dynamic errors

```blade
<input id="email" aria-describedby="email-error" aria-invalid="true">
<p id="email-error" class="text-red-500" role="alert">Invalid email</p>
```

### 6. Screen Reader Support
- aria-label for icon-only buttons
- aria-hidden for decorative elements
- alt text for images

```blade
<button aria-label="Close menu">
    <svg aria-hidden="true">...</svg>
</button>

<img src="chart.png" alt="Registration growth chart">
```

## Accessibility Checklist

- [ ] Skip to content link
- [ ] Logical heading hierarchy
- [ ] Focus indicators visible
- [ ] Color contrast ≥4.5:1
- [ ] Touch targets ≥44px
- [ ] Form labels associated
- [ ] Error messages linked
- [ ] ARIA landmarks
- [ ] Alt text for images
- [ ] Keyboard navigable
- [ ] No keyboard traps

## ARIA Best Practices

| Pattern | Implementation |
|---------|---------------|
| Modal | `role="dialog"`, `aria-modal="true"`, focus trap |
| Tabs | `role="tablist"`, `role="tab"`, `role="tabpanel"` |
| Accordion | `aria-expanded`, `aria-controls` |
| Dropdown | `aria-haspopup`, `aria-expanded` |

## Testing Tools

- Lighthouse Accessibility Audit
- axe DevTools
- WAVE Web Accessibility Evaluation Tool
- NVDA (screen reader)

## Related Documentation
- [UI/UX Guidelines](./ui-ux-guidelines.md)
- [SEO Guidelines](./seo-guidelines.md)
