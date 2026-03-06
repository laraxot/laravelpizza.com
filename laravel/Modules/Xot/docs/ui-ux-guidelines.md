# UI/UX Design Guidelines

## Overview

This document outlines the UI/UX standards for <nome progetto> Meetups frontend development.

## Mobile-First Design

### Responsive Breakpoints
```css
/* Mobile-first: base styles */
/* sm: 640px - Tablets */
/* md: 768px - Small laptops */
/* lg: 1024px - Desktops */
/* xl: 1280px - Large screens */
```

### Mobile Optimization Rules
1. **Touch targets**: Minimum 44×44px for clickable elements
2. **Viewport**: Always use responsive meta tag
3. **Font sizes**: Use `rem` units, minimum 16px for body text
4. **Spacing**: Use consistent spacing scale (4px base)
5. **Forms**: Stack vertically on mobile, side-by-side on desktop

### Example Pattern
```blade
<!-- Mobile-first form layout -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <input class="w-full px-4 py-3 rounded-lg">
</div>
```

## Color System

### Primary Colors
- **Primary**: `red-500` (#EF4444) - CTAs, highlights
- **Background Dark**: `slate-900` (#0F172A)
- **Background Light**: `slate-100` (#F1F5F9)
- **Text Primary**: `white` on dark, `slate-900` on light

### Contrast Requirements
- Minimum 4.5:1 for normal text
- Minimum 3:1 for large text
- 7:1 for AAA compliance (recommended)

## Typography

### Font Stack
```css
font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
```

### Scale
- h1: 2.5rem (40px) - bold
- h2: 2rem (32px) - bold
- h3: 1.5rem (24px) - semibold
- body: 1rem (16px)
- small: 0.875rem (14px)

## Animations

### Performance Rules
1. Use CSS transforms instead of `top`/`left`
2. Prefer `opacity` for fades
3. Limit to 60fps animations
4. Use `will-change` sparingly

### Recommended Animations
```css
/* Subtle hover effect */
.hover\:scale-105 { transition: transform 0.2s ease; }

/* Page load animation */
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

/* Floating background elements */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}
```

## Layout Patterns

### Full-Width Mobile Layout
```blade
<main class="min-h-screen px-4 py-8 md:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Content -->
    </div>
</main>
```

### Card Component
```blade
<div class="bg-slate-800/90 backdrop-blur-xl rounded-2xl p-6 md:p-8 border border-slate-700/50">
    <!-- Card content -->
</div>
```

## Component Checklist

- [ ] Touch targets ≥44px
- [ ] Focus states visible
- [ ] Loading states for async actions
- [ ] Error states with clear messaging
- [ ] Empty states for lists
- [ ] Responsive images with srcset
- [ ] Consistent spacing

## Related Documentation
- [WCAG Accessibility Guidelines](./wcag-accessibility-guidelines.md)
- [SEO Guidelines](./seo-guidelines.md)
- [Clickbait & Conversion](./clickbait-conversion-guidelines.md)
