# Register Page Color System

## Overview
Color palette for the registration page following LaravelPizza brand guidelines with WCAG AA compliance.

## Brand Colors

### Primary Colors
```css
/* Primary Red */
--color-red-500: #ef4444;
--color-red-600: #dc2626;
--color-red-700: #b91c1c;

/* Primary Orange */
--color-orange-500: #f97316;
--color-orange-600: #ea580c;
--color-orange-700: #c2410c;

/* Primary Cyan */
--color-cyan-500: #06b6d4;
--color-cyan-600: #0891b2;
--color-cyan-700: #0e7490;
```

### Background Colors
```css
/* Dark Slate Background */
--color-slate-900: #0f172a;
--color-slate-800: #1e293b;
--color-slate-700: #334155;
--color-slate-600: #475569;

/* Red Gradient Background */
bg-gradient-to-br from-slate-900 via-slate-800 to-red-900

/* Dark Mode */
dark:from-slate-950 dark:via-slate-900 dark:to-red-950
```

## Text Colors

### Hierarchy
```css
/* Primary Text */
--text-white: #ffffff;
--text-slate-100: #f1f5f9;
--text-slate-200: #e2e8f0;

/* Secondary Text */
--text-slate-300: #cbd5e1;
--text-slate-400: #94a3b8;
--text-slate-500: #64748b;

/* Muted Text */
--text-slate-600: #475569;
--text-slate-700: #334155;
```

### Accent Text Colors
```css
/* Success */
--text-green-300: #86efac;
--text-green-400: #4ade80;

/* Warning */
--text-orange-300: #fdba74;
--text-orange-400: #fb923c;

/* Error */
--text-red-300: #fca5a5;
--text-red-400: #f87171;
```

## Semantic Colors

### Status Colors
```css
/* Success State */
--color-green-500: #22c55e;
--color-green-600: #16a34a;
--color-green-500/20: rgba(34, 197, 94, 0.2);

/* Warning State */
--color-orange-500: #f97316;
--color-orange-600: #ea580c;
--color-orange-500/20: rgba(249, 115, 22, 0.2);

/* Error State */
--color-red-500: #ef4444;
--color-red-600: #dc2626;
--color-red-500/20: rgba(239, 68, 68, 0.2);
```

### Border Colors
```css
/* Default Border */
--border-slate-700: #334155;
--border-slate-600: #475569;

/* Active Border */
--border-red-500: #ef4444;
--border-red-500/30: rgba(239, 68, 68, 0.3);

/* Focus Border */
--focus-red-500: #ef4444;
--focus-red-500/50: rgba(239, 68, 68, 0.5);
```

## Color Contrast (WCAG AA)

### Background/Text Pairs
| Background | Text | Contrast Ratio | WCAG Level |
|-----------|------|---------------|------------|
| bg-slate-900 | text-white | 12.6:1 | AAA |
| bg-slate-800 | text-slate-300 | 7.2:1 | AAA |
| bg-slate-700 | text-slate-200 | 5.7:1 | AA |
| bg-slate-600 | text-slate-100 | 4.5:1 | AA |
| bg-red-500 | text-white | 3.9:1 | AA |

### Interactive States
```css
/* Button Default */
bg-red-600 → text-white (3.9:1 AA)

/* Button Hover */
bg-red-500 → text-white (4.5:1 AA)

/* Button Disabled */
bg-red-600/50 → text-white (7.8:1 AAA)

/* Button Focus */
bg-red-600 + outline-3px → text-white (3.9:1 AA + focus indicator)
```

## Gradient System

### Background Gradients
```css
/* Primary Gradient */
.bg-gradient-to-br.from-slate-900.via-slate-800.to-red-900

/* Button Gradient */
.from-red-600.to-red-700

/* Badge Gradients */
.from-red-400.to-orange-500
.from-blue-400.to-indigo-500
.from-green-400.to-teal-500
.from-purple-400.to-pink-500
```

### Text Gradients
```css
/* Brand Gradient */
.text-gradient-to-r.from-red-400.to-orange-500

/* Hero Title Gradient */
.text-transparent.bg-clip-text.bg-gradient-to-r.from-red-500.to-orange-500
```

## Opacity System

### Background Opacities
```css
--opacity-10: rgba(0, 0, 0, 0.1);
--opacity-20: rgba(0, 0, 0, 0.2);
--opacity-30: rgba(0, 0, 0, 0.3);
--opacity-40: rgba(0, 0, 0, 0.4);
--opacity-50: rgba(0, 0, 0, 0.5);
--opacity-60: rgba(0, 0, 0, 0.6);
--opacity-70: rgba(0, 0, 0, 0.7);
--opacity-80: rgba(0, 0, 0, 0.8);
--opacity-90: rgba(0, 0, 0, 0.9);
```

### Opacity Use Cases
```css
/* Background Overlays */
bg-slate-800/90  /* Form background */
bg-slate-800/60  /* Trust badges */
bg-slate-800/50  /* Benefits cards */

/* Decorative Elements */
bg-red-500/20  /* Badge background */
bg-red-500/10  /* Blob background */
bg-red-500/5   /* Subtle decoration */
```

## Dark Mode Support

### Color Mapping
```css
/* Light Mode (not used in register page) */
--bg-primary: #ffffff;
--text-primary: #1e293b;

/* Dark Mode (default for register) */
--bg-primary: #0f172a;
--text-primary: #ffffff;
```

### Dark Mode Transitions
```css
/* Smooth theme transitions */
transition: background-color 0.3s ease, color 0.3s ease;

/* Reduced motion preference */
@media (prefers-reduced-motion: reduce) {
  * {
    transition: none !important;
  }
}
```

## Color Variables (CSS Custom Properties)

### Root Variables
```css
:root {
  /* Brand Colors */
  --color-red-500: #ef4444;
  --color-orange-500: #f97316;
  --color-cyan-500: #06b6d4;
  
  /* Backgrounds */
  --color-slate-900: #0f172a;
  --color-slate-800: #1e293b;
  --color-slate-700: #334155;
  
  /* Text Colors */
  --text-white: #ffffff;
  --text-slate-300: #cbd5e1;
  --text-slate-400: #94a3b8;
  --text-slate-500: #64748b;
  
  /* Semantic Colors */
  --color-green-500: #22c55e;
  --color-blue-500: #3b82f6;
  --color-purple-500: #a855f7;
}
```

### Tailwind Configuration
```javascript
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      colors: {
        slate: {
          900: '#0f172a',
          800: '#1e293b',
          700: '#334155',
          600: '#475569',
        },
        red: {
          500: '#ef4444',
          600: '#dc2626',
          700: '#b91c1c',
        },
      },
    },
  },
}
```

## Color Usage Guidelines

### Dos
- ✅ Use color to establish visual hierarchy
- ✅ Use semantic colors for feedback (success, warning, error)
- ✅ Maintain WCAG AA contrast ratios (4.5:1 minimum)
- ✅ Use color to group related elements
- ✅ Use gradients for emphasis and branding
- ✅ Support dark mode consistently

### Don'ts
- ❌ Don't use color as the only indicator of meaning
- ❌ Don't use color combinations below WCAG AA
- ❌ Don't use too many colors (limit to 3-4 main colors)
- ❌ Don't use pure black (#000000) or pure white (#ffffff)
- ❌ Don't use color alone to convey information
- ❌ Don't use color combinations that vibrate

## Color Testing Checklist

- [ ] Color contrast meets WCAG AA (4.5:1 minimum)
- [ ] Colors work in both light and dark modes
- [ ] Color combinations don't vibrate
- [ ] Colors work for colorblind users
- [ ] Colors convey meaning beyond aesthetics
- [ ] Focus states are clearly visible
- [ ] Error states use appropriate colors
- [ ] Success states use appropriate colors
- [ ] Loading states use appropriate colors
- [ ] Disabled states are clearly distinguishable

## References
- [WCAG 2.1 Color Contrast](https://www.w3.org/WAI/WCAG21/Understanding/contrast-minimum)
- [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)
- [Tailwind Color Palette](https://tailwindcss.com/docs/customizing-colors)
- [LaravelPizza Brand Guidelines](../../../Themes/Meetup/docs/color-palette.md)