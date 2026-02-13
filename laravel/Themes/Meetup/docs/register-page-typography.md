# Register Page Typography System

## Overview
Typography system for the registration page optimized for readability, accessibility, and mobile-first experience.

## Font Family

### Primary Font
```css
/* Inter - Modern sans-serif */
font-family: 'Inter', system-ui, -apple-system, sans-serif;

/* Fallback stack */
system-ui → -apple-system → BlinkMacSystemFont → 'Segoe UI' → Roboto → sans-serif
```

### Font Loading
```html
<!-- Preload Inter font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
```

### Font Weights
```css
--font-weight-normal: 400;
--font-weight-medium: 500;
--font-weight-semibold: 600;
--font-weight-bold: 700;
--font-weight-extrabold: 800;
```

## Typography Scale

### Font Size Scale (Responsive)
| Scale | Mobile | Tablet | Desktop | Use Case |
|-------|--------|--------|---------|----------|
| text-xs | 12px | 13px | 14px | Captions, metadata |
| text-sm | 14px | 15px | 16px | Body text |
| text-base | 16px | 17px | 18px | Standard text |
| text-lg | 18px | 20px | 22px | Subheadings |
| text-xl | 20px | 24px | 30px | Section titles |
| text-2xl | 24px | 28px | 36px | Page headings |
| text-3xl | 30px | 36px | 45px | Hero titles |

### Line Height Scale
```css
--leading-tight: 1.25;    /* Headings */
--leading-snug: 1.375;   /* Subheadings */
--leading-normal: 1.5;   /* Body text */
--leading-relaxed: 1.625; /* Long-form text */
--leading-loose: 2;      /* Loose text */
```

## Typography Hierarchy

### H1 - Page Title
```css
.h1 {
  font-size: text-xl md:text-2xl lg:text-3xl;
  font-weight: font-extrabold;
  line-height: leading-tight;
  color: text-white;
  letter-spacing: -0.025em;
}
```

### H2 - Section Heading
```css
.h2 {
  font-size: text-lg md:text-xl lg:text-2xl;
  font-weight: font-bold;
  line-height: leading-tight;
  color: text-white;
  letter-spacing: -0.025em;
}
```

### H3 - Subheading
```css
.h3 {
  font-size: text-base md:text-lg lg:text-xl;
  font-weight: font-semibold;
  line-height: leading-tight;
  color: text-white;
}
```

### Body Text
```css
.body {
  font-size: text-sm md:text-base lg:text-lg;
  font-weight: font-normal;
  line-height: leading-relaxed;
  color: text-slate-300;
}
```

### Caption
```css
.caption {
  font-size: text-xs md:text-sm lg:text-base;
  font-weight: font-normal;
  line-height: leading-relaxed;
  color: text-slate-500;
}
```

## Letter Spacing

### Spacing Scale
```css
--tracking-tighter: -0.05em;  /* Display text */
--tracking-tight: -0.025em;   /* Headings */
--tracking-normal: 0em;       /* Body text */
--tracking-wide: 0.025em;     /* Uppercase text */
--tracking-wider: 0.05em;     /* Labels */
--tracking-widest: 0.1em;     /* Navigation */
```

### Use Cases
```css
/* Uppercase labels */
.uppercase-label {
  text-transform: uppercase;
  letter-spacing: tracking-wider;
  font-weight: font-semibold;
}

/* Form labels */
.form-label {
  letter-spacing: tracking-normal;
  font-weight: font-medium;
}
```

## Responsive Typography

### Mobile-First Approach
```css
/* Base styles (mobile) */
.title {
  font-size: 20px;
  line-height: 1.25;
}

/* Tablet (768px+) */
@media (min-width: 768px) {
  .title {
    font-size: 24px;
    line-height: 1.25;
  }
}

/* Desktop (1024px+) */
@media (min-width: 1024px) {
  .title {
    font-size: 30px;
    line-height: 1.25;
  }
}
```

### Fluid Typography (Optional)
```css
/* Fluid font sizing between breakpoints */
.fluid-text {
  font-size: clamp(1.25rem, 2.5vw, 1.875rem);
  line-height: clamp(1.5rem, 3vw, 2.25rem);
}
```

## Text Alignment

### Alignment Rules
```css
/* Left alignment (default) */
.text-left {
  text-align: left;
}

/* Center alignment */
.text-center {
  text-align: center;
}

/* Right alignment (RTL support) */
.text-right {
  text-align: right;
}

/* Justified text */
.text-justify {
  text-align: justify;
  hyphens: auto;
}
```

### Use Cases
- **Headings**: Center alignment (visual hierarchy)
- **Body text**: Left alignment (readability)
- **Labels**: Left alignment (form fields)
- **Captions**: Left alignment (metadata)

## Text Transform

### Transform Cases
```css
/* Uppercase */
.uppercase {
  text-transform: uppercase;
  letter-spacing: tracking-wider;
}

/* Capitalize */
.capitalize {
  text-transform: capitalize;
}

/* Sentence case */
.sentence {
  text-transform: none;
}
```

### Use Cases
- **Labels**: Uppercase for emphasis
- **Buttons**: Uppercase for consistency
- **Headings**: Sentence case for readability
- **Captions**: Capitalize for titles

## Text Decoration

### Decoration Styles
```css
/* Underline */
.underline {
  text-decoration: underline;
  text-underline-offset: 4px;
}

/* Hover underline */
.hover-underline {
  text-decoration: none;
}

.hover-underline:hover {
  text-decoration: underline;
  text-underline-offset: 4px;
}

/* Line through */
.line-through {
  text-decoration: line-through;
}
```

### Use Cases
- **Links**: Hover underline
- **Deleted text**: Line through
- **Navigation**: Hover underline
- **Form errors**: Red underline

## Text Color Variants

### Color Palette
```css
/* Primary text */
.text-white { color: #ffffff; }
.text-slate-100 { color: #f1f5f9; }
.text-slate-200 { color: #e2e8f0; }

/* Secondary text */
.text-slate-300 { color: #cbd5e1; }
.text-slate-400 { color: #94a3b8; }
.text-slate-500 { color: #64748b; }

/* Muted text */
.text-slate-600 { color: #475569; }
.text-slate-700 { color: #334155; }
```

### Text Gradient
```css
.text-gradient {
  background: linear-gradient(to right, #ef4444, #f97316);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
}
```

## Typography Utilities

### Text Overflow
```css
/* Truncate single line */
.truncate {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

/* Truncate multiple lines */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
```

### Word Break
```css
/* Break long words */
.break-words {
  overflow-wrap: break-word;
  word-wrap: break-word;
}

/* Break all words */
.break-all {
  word-break: break-all;
}

/* Don't break words */
.whitespace-nowrap {
  white-space: nowrap;
}
```

## Accessibility Considerations

### Font Size
- Minimum font size: 14px (text-sm)
- Target font size: 16px (text-base)
- Maximum font size: 32px (text-3xl)

### Line Height
- Minimum line height: 1.25 (leading-tight)
- Target line height: 1.625 (leading-relaxed)
- Spacing between paragraphs: 1.5em

### Color Contrast
- Text on dark background: 7:1 contrast (WCAG AAA)
- Text on light background: 4.5:1 contrast (WCAG AA)

### Screen Reader Support
```html
<!-- Screen reader only text -->
<span class="sr-only">Required field</span>

<!-- Visual only text -->
<span aria-hidden="true">Visual decoration</span>
```

## RTL (Right-to-Left) Support

### RTL Typography
```css
[dir="rtl"] {
  direction: rtl;
  text-align: right;
}

/* Flip logical properties */
[dir="rtl"] .margin-left {
  margin-left: 0;
  margin-right: var(--spacing);
}
```

## Typography Best Practices

### Dos
- ✅ Use relative units (rem, em, %) for font sizes
- ✅ Maintain consistent line heights
- ✅ Use appropriate letter spacing for uppercase text
- ✅ Provide sufficient contrast for readability
- ✅ Test typography across all breakpoints
- ✅ Consider accessibility (color blind, low vision)
- ✅ Support dark mode consistently

### Don'ts
- ❌ Don't use pixel values for responsive fonts
- ❌ Don't use too many font families (max 2-3)
- ❌ Don't use tight letter spacing on lowercase text
- ❌ Don't use font sizes below 14px for body text
- ❌ Don't use color alone to convey meaning
- ❌ Don't justify text on narrow columns
- ❌ Don't use all uppercase for long text blocks

## Typography Testing Checklist

- [ ] Font loads correctly across all browsers
- [ ] Font sizes scale appropriately on all devices
- [ ] Line heights provide good readability
- [ ] Letter spacing is appropriate for each text style
- [ ] Text contrast meets WCAG AA (4.5:1)
- [ ] Text aligns correctly in RTL languages
- [ ] Text wraps correctly on all screen sizes
- [ ] Long text truncates appropriately
- [ ] Focus indicators are visible around text
- [ ] Typography works with screen readers

## References
- [Inter Font](https://rsms.me/inter/)
- [Typography in CSS](https://web.dev/typography/)
- [WCAG 2.1 Visual Presentation](https://www.w3.org/WAI/WCAG21/Understanding/visual-presentation)
- [Responsive Typography](https://www.smashingmagazine.com/2016/05/fluid-typography/)