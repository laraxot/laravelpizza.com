# Design System - LaravelPizza

## Overview

Design system for the LaravelPizza developer meetup platform. Colors verified from the actual laravelpizza.com site.

## Color Palette (Verified from laravelpizza.com)

### Background Colors

```css
--bg-primary: #0f172a;     /* slate-900 - Main background */
--bg-secondary: #0b1120;   /* slate-950 - Footer background */
--bg-card: #1e293b;        /* slate-800 - Card backgrounds */
```

### Accent Colors

```css
--accent-primary: #dc2626;  /* red-600 - Primary accent/CTA */
```

### Text Colors

```css
--text-primary: #ffffff;     /* white - Headings, primary text */
--text-secondary: #9ca3af;   /* gray-400 - Secondary text */
--text-muted: #6b7280;       /* gray-500 - Muted/subtle text */
```

### Tailwind Classes

```html
<!-- Backgrounds -->
<div class="bg-slate-900">Main background</div>
<div class="bg-slate-950">Footer</div>
<div class="bg-slate-800">Cards</div>

<!-- Accent -->
<button class="bg-red-600 hover:bg-red-700">CTA Button</button>

<!-- Text -->
<h1 class="text-white">Heading</h1>
<p class="text-gray-400">Body text</p>
<span class="text-gray-500">Muted text</span>
```

## Typography

- **Headings**: Bold, white, large sizes
- **Body**: Regular weight, gray-400
- **Links**: red-600 with hover:red-500 transition

## Spacing

Follow Tailwind's default spacing scale. Common patterns:
- Section padding: `py-16` to `py-24`
- Card padding: `p-6` to `p-8`
- Container: `max-w-7xl mx-auto px-4`

## Components

### Cards
```html
<div class="bg-slate-800 rounded-lg p-6 border border-slate-700">
  <h3 class="text-white text-lg font-semibold">Card Title</h3>
  <p class="text-gray-400 mt-2">Card description</p>
</div>
```

### Buttons
```html
<!-- Primary CTA -->
<button class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors">
  Join Meetup
</button>

<!-- Secondary -->
<button class="border border-slate-600 hover:border-red-600 text-white px-6 py-3 rounded-lg transition-colors">
  Learn More
</button>
```

## WCAG 2.1 AA Accessibility

- Focus: `focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2`
- Contrast: minimum 4.5:1 ratio for text
- Decorative elements: `aria-hidden="true"`
- Navigation: `<nav aria-label="Unique name">`
- External links: `rel="noopener noreferrer"` + sr-only "opens in new tab"

## Wrong Colors to Avoid

These colors appeared in previous incorrect documentation:
- `#F97316` (orange) - WRONG
- `#ef4444` (red-500) - WRONG for primary accent
- `#0f2b46` - WRONG background
- `#06b6d4` (cyan) - WRONG

Always use the verified palette above.
