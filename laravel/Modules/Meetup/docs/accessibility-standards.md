# Accessibility Standards - Meetup Module

## Standard: WCAG 2.1 Level AA

All frontend components in the Meetup theme follow WCAG 2.1 AA. See `Themes/Meetup/docs/wcag-accessibility-implementation.md` for the full implementation reference.

## Quick Rules for New Components

### Every interactive element needs:
- `focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2` classes
- Keyboard operability (Enter/Space for buttons, Escape to dismiss overlays)

### Every decorative image/icon needs:
- `aria-hidden="true"` on the element or its container

### Every navigation region needs:
- `<nav aria-label="Descriptive name">` (unique labels when multiple navs exist)

### Every `target="_blank"` link needs:
- `rel="noopener noreferrer"` attribute
- `<span class="sr-only"> (opens in new tab)</span>` for screen readers

### Every toggle/switch needs:
- `role="switch"` + `:aria-checked` for binary toggles
- Dynamic `aria-label` reflecting current state

### Animations must respect:
- `@media (prefers-reduced-motion: reduce)` — already handled globally in CSS

### Color contrast requirements:
- Normal text: 4.5:1 minimum
- Large text (18pt+): 3:1 minimum
- UI components: 3:1 against adjacent colors

## Translation Support

All user-facing accessibility labels use `__()` for i18n:
- `{{ __('Main navigation') }}`
- `{{ __('Toggle mobile menu') }}`
- `{{ __('Switch to dark mode') }}`
- `{{ __('opens in new tab') }}`
