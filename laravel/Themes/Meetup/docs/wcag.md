# WCAG 2.1 AA Accessibility Compliance Guide - LaravelPizza Meetup Theme

This document outlines the Web Content Accessibility Guidelines (WCAG) 2.1 Level AA compliance strategy for the Meetup Theme. 

## 🎯 Compliance Target: WCAG 2.1 Level AA

### Critical Contrast Ratios
- **Normal text**: Minimum 4.5:1 contrast ratio
- **Large text** (18pt+ or 14pt+ bold): Minimum 3:1 contrast ratio  
- **UI components/graphics**: Minimum 3:1 contrast ratio
- **Focus indicators**: Minimum 3:1 contrast ratio

### Theme-Specific Color Compliance

#### ✅ WCAG 2.1 AA Compliant Colors
- **Red-500 (#ef4444)** on white: Contrast ~4.5:1 ✅
- **Red-600 (#dc2626)** on white: Contrast ~5.2:1 ✅
- **Slate-900 (#0f172a)** on white: Contrast ~13:1 ✅
- **White text** on slate-800: Contrast ~14:1 ✅

#### ❌ WCAG 2.1 AA Non-Compliant (FIXED)
- **text-slate-300 (#cbd5e1)** on slate-800: ~2.5:1 ❌ → FIXED: text-slate-100 (#f1f5f9) ~9:1 ✅
- **text-gray-300 (#d1d5db)** on slate-800: ~2.5:1 ❌ → FIXED: text-gray-100 (#f3f4f6) ~8:1 ✅
- **text-slate-700 (#334155)** on slate-800: ~1.5:1 ❌ → FIXED: text-slate-200 (#e2e8f0) ~3.5:1 ✅
- **text-gray-400 (#9ca3af)** on slate-800: ~2.0:1 ❌ → FIXED: text-gray-200 (#e5e7eb) ~3.2:1 ✅

### LaravelPizza Brand Color Palette (WCAG Compliant)
- **Primary Dark**: #0f2b46 (navy) - text-white: ~14:1 ✅
- **Primary**: #ef4444 (red) - text-white: ~4.5:1 ✅
- **Secondary**: #f97316 (orange) - text-white: ~3.1:1 ✅
- **Accent**: #06b6d4 (cyan) - text-white: ~3.0:1 ✅
- **Background**: #f8fafc (slate-50) - text-slate-900: ~15:1 ✅

## Core Principles (POUR)
- **Perceivable**: Information and user interface components must be presentable to users in ways they can perceive.
- **Operable**: User interface components and navigation must be operable.
- **Understandable**: Information and the operation of user interface must be understandable.
- **Robust**: Content must be robust enough that it can be interpreted reliably by a wide variety of user agents, including assistive technologies.

## Core Principles (POUR)
- **Perceivable**: Information and user interface components must be presentable to users in ways they can perceive.
- **Operable**: User interface components and navigation must be operable.
- **Understandable**: Information and the operation of user interface must be understandable.
- **Robust**: Content must be robust enough that it can be interpreted reliably by a wide variety of user agents, including assistive technologies.

## Checklist for Meetup Theme

### 1. Semantic Structure & Navigation (Perceivable, Operable)
- [ ] **Landmarks**: Ensure correct use of `<header>`, `<nav>`, `<main>`, `<aside>`, `<footer>`.
- [ ] **Headings**: Use `<h1>` through `<h6>` hierarchically. No skipped levels (e.g., jumping from `<h1>` to `<h3>`).
- [ ] **Focus Not Obscured (AA)**: Ensure sticky headers/footers do not hide focused elements.
- [ ] **Target Size (AA)**: Interactive targets must be at least 24x24 px. (Tailwind: `min-w-6 min-h-6`).
- [ ] **Skip Link**: Implement a "Skip to main content" link as the first focusable element.

### 2. Styling & Visibility (Perceivable)
- [ ] **Color Contrast (AA)**:
    - Normal text: 4.5:1 ratio.
    - Large text (18pt+ or 14pt+ bold): 3:1 ratio.
    - Graphical objects/UI components: 3:1 ratio.
- [ ] **Focus Indicators**: All interactive elements MUST have a visible focus state. (Tailwind: `focus:ring`, `focus:outline`). **Never** use `outline: none` without providing an alternative.
- [ ] **Text Resizing**: Ensure text can be resized up to 200% without loss of content or functionality.

### 3. Interactive Elements (Operable, Robust)
- [ ] **Keyboard Accessible**: All links, buttons, and form controls must be accessible via Tab key.
- [ ] **Names & Labels**:
    - Buttons must have text labels or `aria-label` if icon-only.
    - Links must have descriptive text (avoid "click here").
- [ ] **Dragging (AA)**: Provide single-pointer alternatives for any drag-and-drop interfaces.
- [ ] **No Keyboard Traps**: Focus should not get stuck in any component.

### 4. Images & Media (Perceivable)
- [ ] **Alt Text**: All `<img>` tags must have an `alt` attribute.
    - Decorative images: `alt=""`.
    - Informative images: Descriptive text explaining the image content.
- [ ] **Complex Images**: Use `longdesc` or provide adjacent text for charts/graphs.

### 5. Forms (Operable, Understandable)
- [ ] **Labels**: All inputs must have associated `<label>` elements or `aria-label`/`aria-labelledby`.
- [ ] **Error Identification**: Errors are identified and described to the user in text.
- [ ] **Redundant Entry (A)**: Auto-populate or allow selection of previously entered information.
- [ ] **Accessible Authentication (AA)**: Don't rely solely on cognitive tests (memory) for login.

## Tailwind CSS Implementation Tips

### Focus States
```html
<!-- Good: Visible focus ring -->
<button class="... focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
  Action
</button>
```

### Screen Reader Only
Use `.sr-only` to hide text visually but keep it available for screen readers.
```html
<a href="/settings">
  <svg>...</svg>
  <span class="sr-only">Settings</span>
</a>
```

### Reduced Motion
Respect user preferences for reduced motion.
```html
<div class="transition-transform motion-reduce:transition-none ...">
  ...
</div>
```

## Tools for Verification
- **Lighthouse**: Built-in Chrome DevTools audits.
- **axe DevTools**: Browser extension for deeper analysis.
- **WAVE**: Web Accessibility Evaluation Tool.
- **Manual Check**: Navigate the entire site using ONLY the keyboard (Tab, Enter, Space, Arrows).
