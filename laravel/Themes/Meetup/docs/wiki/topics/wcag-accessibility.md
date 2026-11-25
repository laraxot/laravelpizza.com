---
title: "Topic wcag-accessibility"
type: digest
status: active
qmd: "digest ceiling 100 wcag-accessibility"
---

# Topic wcag-accessibility

Sintesi automatica di 3 documenti (chiave `wcag-accessibility`).

## WCAG Accessibility Guide - Meetup Theme

_Fonte: `wcag-accessibility-guide.md`_

# WCAG Accessibility Guide - Meetup Theme

## Core Principles (POUR)

-   **Perceivable**: Information and user interface components must be presentable to users in ways they can perceive.
    -   Provide text alternatives for non-text content.
    -   Provide captions and other alternatives for multimedia.
    -   Create content that can be presented in different ways without losing information or structure.
    -   Make it easier for users to see and hear content including separating foreground from background.
-   **Operable**: User interface components and navigation must be operable.
    -   Make all functionality available from a keyboard.
    -   Provide users enough time to read and use content.
    -   Do not use content that is known to cause seizures.
    -   Provide ways to help users navigate, find content, and determine where they are.
-   **Understandable**: Information and the operation of user interface must be understandable.
    -   Make text readable and understandable.
    -   Make Web pages appear and operate in predictable ways.
    -   Help users avoid and correct mistakes.
-   **Robust**: Content must be robust enough that it can be interpreted by a wide variety of user agents, including assistive technologies.
    -   Maximize compatibility with current and future user agents, including assistive technologies.

## Implementation Guidelines

-   **Semantic HTML**: Use correct semantic HTML5 elements (e.g., `<header>`, `<nav>`, `<main>`, `<article>`, `

## WCAG 2.1 AA Accessibility Implementation - Meetup Theme

_Fonte: `wcag-accessibility-implementation.md`_

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

## WCAG 2.2 AAA Accessibility Guidelines

_Fonte: `wcag-accessibility.md`_

# WCAG 2.2 AAA Accessibility Guidelines

## Overview
Web Content Accessibility Guidelines (WCAG) 2.2 AAA compliance for the Laravel Pizza Meetup theme ensuring equal access for all users.

## Philosophy
- **Inclusive**: Design for everyone, including disabilities
- **Accessible**: Remove barriers to access
- **Standard-Based**: Follow WCAG 2.2 AAA guidelines
- **Tested**: Verified with real users and tools

## WCAG 2.2 AAA Requirements

### Level AAA Contrast Ratios
```
Normal Text (< 18pt): 7:1 contrast ratio
Large Text (≥ 18pt): 4.5:1 contrast ratio
Interactive Elements: 3:1 contrast ratio
```

### Verified Color Combinations
```php
// ✅ AAA Compliant (7:1+)
text-white on bg-slate-900      // 18.5:1
text-slate-900 on bg-white      // 21:1
text-white on bg-red-500        // 4.5:1 (fails AAA for normal text)
text-slate-900 on bg-red-500    // 4.5:1 (fails AAA for normal text)

// ✅ AAA Compliant for Large Text
text-white on bg-red-500        // 4.5:1 (OK for ≥ 18pt)
