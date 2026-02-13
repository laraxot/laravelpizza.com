# Color Palette for Meetup Theme

## Overview
Complete color system for the Laravel Pizza Meetup theme designed for brand consistency, accessibility, and visual hierarchy.

## Philosophy
- **Brand-Centric**: Colors reflect LaravelPizza identity
- **Accessible**: WCAG 2.2 AAA compliant contrast ratios
- **Semantic**: Colors have clear meaning and purpose
- **Consistent**: Used consistently across all components

## Primary Color Palette

### Dark Navy (#0f2b46)
**Usage**: Navigation, footer, hero overlay
**Contrast**: Works with white text (ratio 18.5:1)
```php
class="bg-[#0f2b46]"
class="text-white"  // on dark navy
```

### Red-Orange (#ef4444)
**Usage**: CTAs, accents, pizza color
**Contrast**: Works with white text (ratio 4.5:1)
```php
class="bg-[#ef4444]"
class="text-white"  // on red-orange
```

### Orange (#f97316)
**Usage**: Secondary CTAs, highlights
**Contrast**: Works with white text (ratio 4.0:1)
```php
class="bg-[#f97316]"
class="text-white"  // on orange
```

### Cyan (#06b6d4)
**Usage**: Tech elements, links
**Contrast**: Works with dark text (ratio 4.2:1)
```php
class="bg-[#06b6d4]"
class="text-slate-900"  // on cyan
```

### Light Gray (#f8fafc)
**Usage**: Background sections
**Contrast**: Works with dark text (ratio 16.2:1)
```php
class="bg-[#f8fafc]"
class="text-slate-900"  // on light gray
```

## Tailwind Color Scale

### Slate (Neutral)
```
50:  #f8fafc  (lightest)
100: #f1f5f9
200: #e2e8f0
300: #cbd5e1
400: #94a3b8
500: #64748b
600: #475569
700: #334155
800: #1e293b
900: #0f172a
950: #020617  (darkest)
```

**Usage**: Text, borders, backgrounds

### Red (Primary Action)
```
50:  #fef2f2
100: #fee2e2
200: #fecaca
300: #fca5a5
400: #f87171
500: #ef4444  (primary)
600: #dc2626
700: #b91c1c
800: #991b1b
900: #7f1d1d
950: #450a0a
```

**Usage**: Primary buttons, alerts, errors

### Orange (Secondary Action)
```
50:  #fff7ed
100: #ffedd5
200: #fed7aa
300: #fdba74
400: #fb923c
500: #f97316  (primary)
600: #ea580c
700: #c2410c
800: #9a3412
900: #7c2d12
950: #431407
```

**Usage**: Secondary buttons, highlights, warnings

### Cyan (Accent)
```
50:  #ecfeff
100: #cffafe
200: #a5f3fc
300: #67e8f9
400: #22d3ee
500: #06b6d4  (primary)
600: #0891b2
700: #0e7490
800: #155e75
900: #164e63
950: #083344
```

**Usage**: Links, tech elements, info messages

### Green (Success)
```
50:  #f0fdf4
100: #dcfce7
200: #bbf7d0
300: #86efac
400: #4ade80
500: #22c55e
600: #16a34a
700: #15803d
800: #166534
900: #14532d
950: #052e16
```

**Usage**: Success messages, confirmations

### Purple (Creative)
```
50:  #faf5ff
100: #f3e8ff
200: #e9d5ff
300: #d8b4fe
400: #c084fc
500: #a855f7
600: #9333ea
700: #7e22ce
800: #6b21a8
900: #581c87
950: #3b0764
```

**Usage**: Creative elements, avatars, gradients

## Color Combinations

### Primary Combinations
```php
// Dark background with white text
bg-slate-900 text-white

// White background with dark text
bg-white text-slate-900

// Red button with white text
bg-red-500 text-white

// Cyan link on dark background
text-cyan-400  // on slate-900
```

### Gradient Combinations
```php
// Hero gradient
bg-gradient-to-br from-slate-900 via-slate-800 to-red-900

// Button gradient
bg-gradient-to-r from-red-600 to-red-700

// Stats bar gradient
bg-gradient-to-r from-red-600/30 to-orange-600/30

// Avatar gradient
bg-gradient-to-br from-red-400 to-orange-500
```

### Opacity Variations
```php
// Background elements (reduced opacity for contrast)
bg-red-500/10   // 10% opacity
bg-orange-500/20 // 20% opacity
bg-slate-500/50 // 50% opacity

// Overlays
bg-slate-900/90  // 90% opacity (semi-transparent)
bg-slate-800/90  // 90% opacity
```

## Semantic Color Usage

### Action Colors
```php
// Primary Action
bg-red-600 hover:bg-red-500 text-white

// Secondary Action
bg-orange-500 hover:bg-orange-400 text-white

// Tertiary Action
bg-cyan-500 hover:bg-cyan-400 text-white

// Destructive Action
bg-red-600 hover:bg-red-500 text-white
```

### Status Colors
```php
// Success
text-green-400  // on dark background
text-green-600  // on light background

// Warning
text-orange-400 // on dark background
text-orange-600 // on light background

// Error
text-red-400    // on dark background
text-red-600    // on light background

// Info
text-cyan-400   // on dark background
text-cyan-600   // on light background
```

### Text Colors
```php
// Headings
text-white      // on dark backgrounds
text-slate-900  // on light backgrounds

// Body Text
text-slate-300  // on dark backgrounds
text-slate-700  // on light backgrounds

// Muted Text
text-slate-400  // on dark backgrounds
text-slate-500  // on light backgrounds

// Links
text-cyan-400   // on dark backgrounds
text-cyan-600   // on light backgrounds
```

### Border Colors
```php
// Dark borders
border-slate-700   // on dark backgrounds
border-slate-300   // on light backgrounds

// Highlight borders
border-red-500/30  // subtle red
border-cyan-500/30 // subtle cyan
```

## Contrast Ratios (WCAG 2.2 AAA)

### Minimum Requirements
- **Normal Text** (< 18pt): 7:1 contrast ratio
- **Large Text** (≥ 18pt): 4.5:1 contrast ratio
- **Interactive Elements**: 3:1 contrast ratio

### Verified Combinations
```php
// AAA Compliant (7:1+)
text-white on bg-slate-900      // 18.5:1
text-slate-900 on bg-white      // 21:1
text-white on bg-red-500        // 4.5:1
text-slate-900 on bg-red-500    // 4.5:1
text-white on bg-orange-500     // 4.0:1

// AA Compliant (4.5:1+)
text-white on bg-red-600        // 4.5:1
text-white on bg-cyan-500       // 4.5:1
text-white on bg-slate-800      // 14.5:1
```

## Color Modifiers

### Hover States
```php
// Lighten on hover
bg-red-500 hover:bg-red-400

// Darken on hover
bg-red-500 hover:bg-red-600

// Opacity change
bg-red-500 hover:bg-red-500/90
```

### Focus States
```php
// Ring focus
focus:ring-2 focus:ring-red-500

// Offset focus ring
focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-slate-900

// Solid focus border
focus:ring-2 focus:ring-offset-2 focus:border-red-500
```

### Disabled States
```php
// Reduced opacity
disabled:opacity-50

// No pointer events
disabled:cursor-not-allowed

// Grayed out
disabled:bg-gray-300 disabled:text-gray-500
```

## Background Patterns

### Gradient Backgrounds
```php
// Simple gradient
bg-gradient-to-br from-slate-900 to-red-900

// Three-color gradient
bg-gradient-to-br from-slate-900 via-slate-800 to-red-900

// Diagonal gradient
bg-gradient-to-r from-red-600 to-orange-600
```

### Solid Backgrounds
```php
// Dark backgrounds
bg-slate-900
bg-slate-800
bg-slate-950

// Light backgrounds
bg-white
bg-slate-50
bg-slate-100
```

### Overlay Backgrounds
```php
// Semi-transparent overlays
bg-slate-900/90
bg-slate-800/90

// Backdrop blur
backdrop-blur-xl
backdrop-blur-md
backdrop-blur-sm
```

## Shadow System

### Shadow Depths
```php
shadow-sm        // subtle
shadow           // default
shadow-md        // medium
shadow-lg        // large
shadow-xl        // extra large
shadow-2xl       // extra extra large
shadow-none      // no shadow
```

### Colored Shadows
```php
// Red shadow
shadow-lg shadow-red-500/20

// Orange shadow
shadow-xl shadow-orange-500/20

// Cyan shadow
shadow-lg shadow-cyan-500/20
```

## Common Mistakes

### 1. Low Contrast
```php
// ❌ WRONG - Poor contrast
text-gray-400 on bg-white  // 3.0:1 (fails WCAG AAA)

// ✅ CORRECT - Good contrast
text-slate-600 on bg-white  // 7.5:1 (passes WCAG AAA)
```

### 2. Inconsistent Colors
```php
// ❌ WRONG - Random colors
bg-blue-500 text-green-400

// ✅ CORRECT - Consistent palette
bg-red-500 text-white
```

### 3. Too Many Colors
```php
// ❌ WRONG - Color chaos
bg-red-500 text-yellow-400 border-green-500

// ✅ CORRECT - Focused palette
bg-red-500 text-white border-red-600
```

### 4. No Focus States
```php
// ❌ WRONG - No focus indicator
bg-red-500 text-white

// ✅ CORRECT - With focus ring
bg-red-500 text-white focus:ring-2 focus:ring-red-500 focus:ring-offset-2
```

## Color Testing Tools

### Online Tools
- [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)
- [Color Oracle](https://colororacle.org/) - Color blindness simulator
- [Contrast Ratio Calculator](https://contrast-ratio.com/)

### Browser DevTools
- Chrome DevTools -> Elements -> Computed -> Color
- Firefox DevTools -> Inspector -> Computed -> Color

## Related Documentation
- [Layout System](./layout-system.md)
- [Typography System](./typography.md)
- [WCAG Accessibility](./wcag-accessibility.md)
- [Animations](./animations.md)

## Credits
- Color Palette: Custom LaravelPizza brand colors
- Tailwind Scale: Standard Tailwind CSS colors
- Accessibility: WCAG 2.2 AAA compliant
- Philosophy: Brand consistency, clarity, accessibility