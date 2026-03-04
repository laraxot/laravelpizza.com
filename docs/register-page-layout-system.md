# Register Page Layout System

## Overview
Layout system for the registration page optimized for mobile-first experience and accessibility.

## Design Principles

### Mobile-First Approach
- **Primary viewport**: Mobile (320px - 768px)
- **Breakpoints**:
  - Mobile: 320px - 768px
  - Tablet: 768px - 1024px
  - Desktop: 1024px+

### Container Sizing
```css
/* Mobile */
max-w-3xl (768px)
padding: py-4, px-3

/* Tablet */
max-w-4xl (896px)
padding: py-6, px-4

/* Desktop */
max-w-5xl (1152px)
padding: py-8, px-4
```

## Layout Structure

### Vertical Stack
```
┌─────────────────────────────────┐
│ Header (compact)                 │
│ - Logo                         │
│ - Title (text-xl)              │
│ - Subtitle (text-sm)            │
├─────────────────────────────────┤
│ Registration Form (full-width)   │
│ - Form heading                   │
│ - Livewire Widget               │
│ - Terms notice                  │
├─────────────────────────────────┤
│ Benefits (compact)               │
│ - Benefit 1 (title + CTA)       │
│ - Benefit 2 (title + CTA)       │
│ - Benefit 3 (title + CTA)       │
└─────────────────────────────────┘
```

## Layout Rules

### 1. No Side-by-Side on Mobile
- Single column layout on mobile (< 768px)
- All elements stacked vertically
- No horizontal scrolling

### 2. Form Width
- Mobile: 100% - 20px (padding x2)
- Tablet: 100% - 32px (padding x2)
- Desktop: 100% - 32px (padding x2)

### 3. Spacing System
```css
/* Mobile spacing */
gap-2 (0.5rem) - between compact elements
space-y-2 - vertical stack
py-4 - vertical padding

/* Desktop spacing */
gap-3 (0.75rem) - between elements
space-y-4 - vertical stack
py-8 - vertical padding
```

### 4. Touch Targets (WCAG)
```css
/* Minimum touch target: 44x44px */
button, input, checkbox {
  min-height: 44px;
  min-width: 44px;
}
```

## Responsive Typography

### Font Sizes
| Element | Mobile | Tablet | Desktop |
|---------|--------|--------|---------|
| H1 (title) | text-xl (20px) | text-2xl (24px) | text-3xl (30px) |
| H2 (form heading) | text-lg (18px) | text-xl (20px) | text-2xl (24px) |
| Body text | text-sm (14px) | text-base (16px) | text-lg (18px) |
| Caption | text-xs (12px) | text-sm (14px) | text-base (16px) |

### Line Heights
```css
/* Mobile */
leading-tight (1.25) - headings
leading-relaxed (1.625) - body

/* Desktop */
leading-tight (1.25) - headings
leading-relaxed (1.625) - body
```

## Color Contrast (WCAG AA)

### Background/Text Combinations
```css
/* Primary text on dark background */
text-white on bg-slate-900: contrast 12.6:1 (AAA)

/* Secondary text */
text-slate-300 on bg-slate-900: contrast 7.2:1 (AAA)

/* Tertiary text */
text-slate-500 on bg-slate-900: contrast 4.8:1 (AA)

/* Accent text */
text-red-400 on bg-slate-900: contrast 5.9:1 (AA)
```

### Focus Indicators
```css
/* WCAG 2.1 AAA focus indicator */
:focus-visible {
  outline: 3px solid #ef4444;
  outline-offset: 3px;
  box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2);
}
```

## Animation Performance

### GPU-Accelerated Animations
```css
/* Use transform and opacity only */
transform: translate3d(x, y, 0);
opacity: 0.5;

/* Avoid animating */
- width, height (use transform: scale() instead)
- left, top (use transform: translate() instead)
- margin, padding (use transform: scale() instead)
```

### Reduced Motion Support
```css
@media (prefers-reduced-motion: reduce) {
  /* Disable all animations */
  *,
  *::before,
  *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
  }
}
```

## Loading Performance

### Critical CSS
- Inline critical CSS above the fold
- Defer non-critical CSS
- Minify CSS for production

### Asset Loading
```html
<!-- Preload critical assets -->
<link rel="preload" href="fonts/inter.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="css/app.css" as="style">
```

## Mobile Optimization

### Viewport Meta Tag
```html
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes">
```

### Touch Actions
```css
/* Prevent double-tap zoom on buttons */
button, input[type="submit"] {
  touch-action: manipulation;
}
```

### Safe Areas (Notch/Island)
```css
/* iOS safe areas */
@supports (padding: max(0px)) {
  .container {
    padding-left: max(16px, env(safe-area-inset-left));
    padding-right: max(16px, env(safe-area-inset-right));
  }
}
```

## Accessibility Checklist

- [x] Semantic HTML5 structure
- [x] ARIA labels for interactive elements
- [x] Screen reader only headings
- [x] Skip navigation link
- [x] Focus management
- [x] Keyboard navigation
- [x] Touch targets 44x44px minimum
- [x] Color contrast WCAG AA (4.5:1)
- [x] Reduced motion support
- [x] Responsive images
- [x] Form labels associated with inputs
- [x] Error messages visible and accessible
- [x] Loading states communicated

## Testing Checklist

### Mobile
- [ ] Test on iPhone SE (320px)
- [ ] Test on iPhone 12 Pro (390px)
- [ ] Test on iPad (768px)
- [ ] Test on Pixel 5 (393px)

### Tablet
- [ ] Test on iPad Mini (768px)
- [ ] Test on iPad Pro (1024px)

### Desktop
- [ ] Test on 1366px
- [ ] Test on 1920px
- [ ] Test on 2560px

### Accessibility
- [ ] Test with NVDA (Windows)
- [ ] Test with VoiceOver (macOS)
- [ ] Test with TalkBack (Android)
- [ ] Test with high contrast mode
- [ ] Test with reduced motion

## Performance Metrics

### Core Web Vitals Targets
- **LCP (Largest Contentful Paint)**: < 2.5s
- **FID (First Input Delay)**: < 100ms
- **CLS (Cumulative Layout Shift)**: < 0.1

### Loading Metrics
- **First Contentful Paint**: < 1.8s
- **Time to Interactive**: < 3.5s
- **Speed Index**: < 3.0s

## References
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [Mobile Web Best Practices](https://web.dev/mobile/)
- [Lighthouse Performance](https://developer.chrome.com/docs/lighthouse/)