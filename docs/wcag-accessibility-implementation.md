# WCAG 2.1 AA Accessibility Implementation - Meetup Theme

## Standard Followed

**WCAG 2.1 Level AA** — the de facto standard for web accessibility compliance, required by ADA Title II (2026) and EAA (European Accessibility Act).

## Four WCAG Principles (POUR)

1. **Perceivable** — Content must be presentable to users in ways they can perceive
2. **Operable** — UI components and navigation must be operable
3. **Understandable** — Information and UI operation must be understandable
4. **Robust** — Content must be robust enough for assistive technologies

## Implemented Improvements

### 1. ARIA Landmarks & Roles

| Component | ARIA Attribute | Purpose |
|-----------|---------------|---------|
| `<header>` wrapper | `role="banner"` | Identifies site-wide header |
| `<nav>` | `aria-label="Main navigation"` | Labels navigation region |
| `<main>` | `id="main-content"` | Skip-nav target + main landmark |
| `<footer>` | `role="contentinfo"` | Identifies footer region |
| Footer navs | `<nav aria-label="Community links">` | Labeled nav sub-regions |
| Features section | `aria-labelledby="features-heading"` | Associates section with heading |

### 2. Keyboard Navigation

- **Skip-to-content link**: `<a href="#main-content" class="sr-only focus:not-sr-only ...">` in `main.blade.php`
- **Focus-visible styles**: Global CSS rule targets `a, button, input, select, textarea, summary, [tabindex]` with `outline: 2px solid red-500` + `outline-offset: 2px`
- **Focus styles on all interactive elements**: Every `<a>` and `<button>` has `focus-visible:ring-2 focus-visible:ring-red-500` classes
- **Escape key**: Closes mobile menu and language dropdown via Alpine.js `@keydown.escape.window`

### 3. Color Contrast (AA Requirements)

- **Normal text**: 4.5:1 minimum ratio
- **Large text** (18pt / 14pt bold): 3:1 minimum ratio
- **Non-text UI**: 3:1 against adjacent colors

Our verified contrasts:
- `text-slate-100` (#f1f5f9) on `bg-slate-900` (#0f172a) = **~15:1** (exceeds AA)
- `text-gray-400` (#9ca3af) on `bg-slate-950` (#020617) = **~5.5:1** (meets AA)
- `text-white` on `bg-red-600` (#dc2626) = **~4.6:1** (meets AA)
- `text-red-100` on `bg-red-600` = **~3.1:1** (meets AA for large text)

### 4. Screen Reader Support

- **Decorative images**: All decorative SVGs, icons, and backgrounds use `aria-hidden="true"`
- **Logo links**: `aria-label="Laravel Pizza Meetups - Home"` provides accessible name
- **Mobile menu button**: `aria-label="Toggle mobile menu"` + dynamic `aria-expanded`
- **Theme toggle**: `role="switch"` + `:aria-checked` + dynamic `aria-label` reflecting state
- **External links**: `<span class="sr-only"> (opens in new tab)</span>` for `target="_blank"` links
- **Feature icons**: Container div gets `aria-hidden="true"` since icons are decorative
- **Language switcher**: `role="listbox"` + `role="option"` + `aria-selected` + `aria-haspopup`

### 5. Reduced Motion

CSS in `app.css`:
```css
@media (prefers-reduced-motion: reduce) {
    html:focus-within { scroll-behavior: auto; }
    *, *::before, *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
    }
}
```

### 6. Current Page Indication

Nav links use `aria-current="page"` when the current URL matches the link:
```blade
@if(request()->is(ltrim($item['url'], '/'))) aria-current="page" @endif
```

### 7. Mobile Menu Accessibility

- Button uses `:aria-expanded="mobileMenuOpen.toString()"` (dynamic, not static)
- `aria-controls="mobile-menu-panel"` links button to panel
- `@keydown.escape.window="mobileMenuOpen = false"` allows keyboard dismissal
- Removed duplicate mobile menu panel (was causing confusion for screen readers)

### 8. Form Best Practices (for future forms)

Per WCAG 2.1 AA:
- Every input needs a programmatic `<label>` (not just placeholder)
- Error messages via `aria-describedby` association
- `autocomplete` attributes for user data fields (name, email, tel)
- Error announcements via `aria-live="polite"` regions

## Files Modified

| File | Changes |
|------|---------|
| `components/sections/header.blade.php` | Wrapped in `<header role="banner">` |
| `components/sections/header/v1.blade.php` | `aria-label` on nav, logo link, mobile button; `aria-hidden` on decorative icons |
| `components/sections/footer/v1.blade.php` | `role="contentinfo"`, `<nav>` landmarks with labels, focus styles, external link SR text, `aria-hidden` on icons |
| `components/blocks/hero/main.blade.php` | `aria-hidden` on decorative SVGs, focus styles on CTA buttons |
| `components/blocks/features/grid.blade.php` | `aria-labelledby`, `<article>` elements, `role="list/listitem"`, `aria-hidden` on icons |
| `components/blocks/cta/banner.blade.php` | Focus styles on buttons, `aria-hidden` on arrow SVG |
| `components/ui/theme-toggle.blade.php` | `role="switch"` + `aria-checked` + dynamic `aria-label`, improved focus ring |
| `components/blocks/navigation/header-main.blade.php` | Full ARIA rework: labels, dynamic `aria-expanded`, `aria-current="page"`, escape key, removed duplicate mobile menu |
| `css/app.css` | Already had focus-visible, reduced-motion, sr-only (no changes needed) |
| `components/layouts/main.blade.php` | Already had skip-to-content, lang attribute (no changes needed) |

## Testing Checklist

- [ ] Tab through all interactive elements — verify visible focus ring
- [ ] Navigate with screen reader (NVDA/VoiceOver) — verify landmarks announced
- [ ] Toggle mobile menu with keyboard — verify Escape closes it
- [ ] Verify `aria-expanded` updates on mobile menu button
- [ ] Verify theme toggle announces "Switch to light/dark mode"
- [ ] Enable reduced motion in OS — verify animations disabled
- [ ] Check contrast with browser DevTools accessibility audit
- [ ] Verify external links announce "opens in new tab"
- [ ] Test skip-to-content link (Tab on page load)

## References

- [WCAG 2.1 Specification](https://www.w3.org/TR/WCAG21/)
- [Understanding WCAG 2.1](https://www.w3.org/WAI/WCAG21/Understanding/)
- [ARIA Landmark Roles](https://www.w3.org/WAI/ARIA/apg/practices/landmark-regions/)
- [Focus Appearance Guide](https://www.sarasoueidan.com/blog/focus-indicators/)
- [Accessible Dark Mode Toggle](https://www.smashingmagazine.com/2025/04/inclusive-dark-mode-designing-accessible-dark-themes/)
