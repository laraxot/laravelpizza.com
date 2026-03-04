# Typography System for Meetup Theme

## Overview
Comprehensive typography system for the Laravel Pizza Meetup theme ensuring readability, accessibility, and brand consistency.

## Philosophy
- **Readable**: Optimized for screen reading (16px base)
- **Accessible**: WCAG 2.2 AAA compliant font sizes and line heights
- **Hierarchical**: Clear visual hierarchy through scale
- **Responsive**: Adapts to screen size

## Font Family

### Primary Font: Inter
```php
// Import
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

// Tailwind Config
font-family: 'Inter', sans-serif;
```

### Font Weights
```
400 (Regular) - Body text
500 (Medium)  - Secondary headings
600 (SemiBold) - Primary headings
700 (Bold)    - Emphasis
800 (ExtraBold) - Display headings
```

## Font Scale

### Responsive Font Sizes
```php
// Display (Hero headings)
text-4xl sm:text-5xl lg:text-6xl
// Mobile: 36px (2.25rem)
// Tablet: 48px (3rem)
// Desktop: 60px (3.75rem)

// H1 (Main headings)
text-3xl sm:text-4xl lg:text-5xl
// Mobile: 30px (1.875rem)
// Tablet: 36px (2.25rem)
// Desktop: 48px (3rem)

// H2 (Section headings)
text-2xl sm:text-3xl lg:text-4xl
// Mobile: 24px (1.5rem)
// Tablet: 30px (1.875rem)
// Desktop: 36px (2.25rem)

// H3 (Subheadings)
text-xl sm:text-2xl lg:text-3xl
// Mobile: 20px (1.25rem)
// Tablet: 24px (1.5rem)
// Desktop: 30px (1.875rem)

// Body (Paragraph text)
text-base sm:text-lg lg:text-xl
// Mobile: 16px (1rem)
// Tablet: 18px (1.125rem)
// Desktop: 20px (1.25rem)

// Small (Secondary text)
text-sm sm:text-base lg:text-lg
// Mobile: 14px (0.875rem)
// Tablet: 16px (1rem)
// Desktop: 18px (1.125rem)

// Extra Small (Muted text)
text-xs sm:text-sm lg:text-base
// Mobile: 12px (0.75rem)
// Tablet: 14px (0.875rem)
// Desktop: 16px (1rem)
```

## Line Heights

### Scale
```php
// Tight (headings)
leading-none      // 1
leading-tight     // 1.25
leading-snug      // 1.375

// Normal (body text)
leading-normal    // 1.5

// Relaxed (long text)
leading-relaxed   // 1.625
leading-loose     // 2
```

### Recommended Usage
```php
// Headings
leading-tight

// Body text
leading-normal

// Long paragraphs
leading-relaxed
```

## Letter Spacing

### Scale
```php
tracking-tighter    // -0.05em
tracking-tight      // -0.025em
tracking-normal     // 0em
tracking-wide       // 0.025em
tracking-wider      // 0.05em
tracking-widest     // 0.1em
```

### Recommended Usage
```php
// Headings (uppercase)
tracking-tight

// Body text
tracking-normal

// Labels (uppercase)
tracking-wide
```

## Text Alignment

### Responsive Alignment
```php
// Center on mobile, left on desktop
text-center lg:text-left

// Always centered
text-center

// Always left-aligned
text-left
```

## Text Transformations

### Usage
```php
// Uppercase for labels
uppercase tracking-wide font-semibold

// Title case for headings
capitalize

// Sentence case for body text
normal-case
```

## Text Colors

### Dark Backgrounds
```php
// Headings
text-white

// Body text
text-slate-300

// Muted text
text-slate-400

// Links
text-cyan-400 hover:text-cyan-300
```

### Light Backgrounds
```php
// Headings
text-slate-900

// Body text
text-slate-700

// Muted text
text-slate-500

// Links
text-cyan-600 hover:text-cyan-700
```

## Text Decorations

### Links
```php
// Default links
text-cyan-400 hover:text-cyan-300 transition-colors

// Underlined links
underline hover:text-cyan-300 transition-colors

// No underline
no-underline hover:underline
```

## Text Truncation

### Single Line
```php
truncate
// Ellipsis (...) on overflow
```

### Multiple Lines
```php
line-clamp-2  // Show 2 lines
line-clamp-3  // Show 3 lines
```

## Font Loading

### Preconnect
```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
```

### Display Strategy
```php
// Optimize font loading
font-display: swap;
```

## Typography Patterns

### Hero Section
```php
<h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight">
    Laravel Pizza Meetups
</h1>
<p class="text-lg lg:text-xl text-slate-300 leading-relaxed mt-4">
    Join 5,000+ developers for exclusive meetups, tutorials, and networking.
</p>
```

### Card Header
```php
<h2 class="text-2xl font-bold text-white leading-tight mb-2">
    Section Title
</h2>
<p class="text-sm text-slate-400 leading-normal">
    Description text goes here.
</p>
```

### Form Labels
```php
<label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
    Field Label
</label>
```

### Button Text
```php
<button class="text-base font-bold text-white">
    Button Text
</button>
```

### Navigation Links
```php
<a class="text-sm font-medium text-slate-300 hover:text-white transition-colors">
    Navigation Link
</a>
```

## Responsive Typography

### Mobile-First Approach
```php
// Start with mobile base size
text-base

// Enhance for tablet
sm:text-lg

// Enhance for desktop
lg:text-xl
```

### Container Queries (Future)
```php
// When container queries are supported
@container (min-width: 640px) {
    text-lg;
}
```

## Accessibility Guidelines

### Minimum Font Sizes
```php
// Body text minimum
text-base  // 16px (never smaller)

// Small text minimum
text-sm    // 14px (use sparingly)

// Extra small text minimum
text-xs    // 12px (only for labels)
```

### Contrast Requirements
```php
// Dark background
text-white        // 21:1 ratio
text-slate-300    // 5.4:1 ratio

// Light background
text-slate-900    // 21:1 ratio
text-slate-700    // 6.3:1 ratio
```

### Line Height Guidelines
```php
// Headings (tight)
leading-tight     // 1.25

// Body text (comfortable)
leading-normal    // 1.5

// Long text (readable)
leading-relaxed   // 1.625
```

## Common Mistakes

### 1. Font Too Small
```php
// ❌ WRONG - Below 16px
text-xs  // 12px (hard to read)

// ✅ CORRECT - Minimum 16px
text-base  // 16px
```

### 2. Line Height Too Tight
```php
// ❌ WRONG - Cramped text
leading-none  // 1.0

// ✅ CORRECT - Comfortable reading
leading-normal  // 1.5
```

### 3. Poor Contrast
```php
// ❌ WRONG - Low contrast
text-gray-400 on bg-white  // 3.0:1

// ✅ CORRECT - Good contrast
text-slate-600 on bg-white  // 7.5:1
```

### 4. Inconsistent Scale
```php
// ❌ WRONG - Random sizes
text-[17px] text-[23px]

// ✅ CORRECT - Consistent scale
text-base text-lg text-xl
```

### 5. No Responsive Design
```php
// ❌ WRONG - One size fits all
text-2xl

// ✅ CORRECT - Responsive
text-xl sm:text-2xl lg:text-3xl
```

## Font Optimization

### Subset Fonts
```php
// Only load needed weights
family=Inter:wght@400;500;600;700;800

// Latin subset only
subset=latin
```

### Font Display
```php
// Prevent FOIT (Flash of Invisible Text)
font-display: swap;
```

### Font Formats
```php
// WOFF2 (most efficient)
// WOFF (fallback)
// TTF (last resort)
```

## Testing Checklist

### Readability
- [ ] Body text ≥ 16px
- [ ] Line height 1.5 for body text
- [ ] Line height 1.25 for headings
- [ ] Consistent font scale
- [ ] Appropriate letter spacing

### Accessibility
- [ ] WCAG 2.2 AAA contrast ratios
- [ ] Responsive font sizes
- [ ] No text on images
- [ ] Text can be resized 200%
- [ ] Font loading doesn't block render

### Cross-Platform
- [ ] Windows (ClearType)
- [ ] Mac (font smoothing)
- [ ] iOS (system fonts)
- [ ] Android (system fonts)

## Related Documentation
- [Layout System](./layout-system.md)
- [Color Palette](./color-palette.md)
- [WCAG Accessibility](./wcag-accessibility.md)

## Credits
- Font: Inter (Variable Font)
- Designer: Rasmus Andersson
- License: SIL Open Font License
- Philosophy: Clarity, readability, accessibility