# Design Tokens

Complete design system tokens for consistent, scalable UI design.

---

## What are Design Tokens?

Design tokens are named variables that store visual design attributes. They ensure consistency across your design system and make updates easy - change one token, update everywhere.

**Benefits:**
- Consistency across all screens
- Easy theme switching
- Scalable design system
- Single source of truth
- Developer-friendly

---

## Table of Contents

1. [Color System](#color-system)
2. [Typography](#typography)
3. [Spacing](#spacing)
4. [Breakpoints](#breakpoints)
5. [Shadows](#shadows)
6. [Border Radius](#border-radius)
7. [Z-Index](#z-index)
8. [Transitions](#transitions)
9. [Usage Examples](#usage-examples)

---

## Color System

### Primary Colors

Used for main brand identity, primary actions, and interactive elements.

```
primary-50:   #E3F2FD   (lightest - backgrounds, hover states)
primary-100:  #BBDEFB   (light - subtle backgrounds)
primary-200:  #90CAF9   (light - hover on light backgrounds)
primary-300:  #64B5F6   (medium-light - borders, secondary UI)
primary-400:  #42A5F5   (medium - secondary elements)
primary-500:  #0066CC   (base - main brand color, primary buttons) ⭐
primary-600:  #0052A3   (medium-dark - button hover)
primary-700:  #003D7A   (dark - button active, dark text)
primary-800:  #002952   (darker - headings on light bg)
primary-900:  #001429   (darkest - high contrast text)
```

**Contrast Ratios (on white #FFFFFF):**
- primary-500: 7.56:1 ✓ (WCAG AA text, AAA large text)
- primary-600: 9.67:1 ✓ (WCAG AA text, AAA)
- primary-700: 12.07:1 ✓ (WCAG AAA all text)

---

### Secondary Colors

Used for accent elements, highlighting, and visual interest.

```
secondary-50:   #FFF3E0
secondary-100:  #FFE0B2
secondary-200:  #FFCC80
secondary-300:  #FFB74D
secondary-400:  #FFA726
secondary-500:  #FF6B35   (base) ⭐
secondary-600:  #F4511E
secondary-700:  #E64A19
secondary-800:  #D84315
secondary-900:  #BF360C
```

---

### Semantic Colors

#### Success (Green)

Used for positive feedback, successful actions, confirmation.

```
success-50:   #F0FDF4
success-100:  #DCFCE7
success-200:  #BBF7D0
success-300:  #86EFAC
success-400:  #4ADE80
success-500:  #22C55E   (base) ⭐
success-600:  #16A34A
success-700:  #15803D
success-800:  #166534
success-900:  #14532D
```

**Usage:**
- Success messages
- Confirmation indicators
- Positive status badges
- Valid form inputs

---

#### Warning (Yellow/Orange)

Used for caution, warnings, important information.

```
warning-50:   #FFFBEB
warning-100:  #FEF3C7
warning-200:  #FDE68A
warning-300:  #FCD34D
warning-400:  #FBBF24
warning-500:  #F59E0B   (base) ⭐
warning-600:  #D97706
warning-700:  #B45309
warning-800:  #92400E
warning-900:  #78350F
```

**Usage:**
- Warning messages
- Caution indicators
- Pending status
- Important notices

---

#### Error (Red)

Used for errors, destructive actions, validation failures.

```
error-50:   #FEF2F2
error-100:  #FEE2E2
error-200:  #FECACA
error-300:  #FCA5A5
error-400:  #F87171
error-500:  #EF4444   (base) ⭐
error-600:  #DC2626
error-700:  #B91C1C
error-800:  #991B1B
error-900:  #7F1D1D
```

**Usage:**
- Error messages
- Form validation errors
- Delete/destructive actions
- Failed status

---

#### Info (Blue)

Used for informational messages, neutral feedback.

```
info-50:   #EFF6FF
info-100:  #DBEAFE
info-200:  #BFDBFE
info-300:  #93C5FD
info-400:  #60A5FA
info-500:  #3B82F6   (base) ⭐
info-600:  #2563EB
info-700:  #1D4ED8
info-800:  #1E40AF
info-900:  #1E3A8A
```

**Usage:**
- Info messages
- Neutral notifications
- Help text
- Informational badges

---

### Neutral Colors (Grayscale)

Used for text, backgrounds, borders, and UI elements.

```
neutral-50:   #FAFAFA   (lightest backgrounds)
neutral-100:  #F5F5F5   (subtle backgrounds, disabled states)
neutral-200:  #E5E5E5   (borders, dividers)
neutral-300:  #D4D4D4   (input borders, subtle borders)
neutral-400:  #A3A3A3   (placeholder text, disabled text)
neutral-500:  #737373   (secondary text, captions)
neutral-600:  #525252   (body text on light backgrounds)
neutral-700:  #404040   (headings, emphasis)
neutral-800:  #262626   (strong emphasis, dark headings)
neutral-900:  #171717   (highest contrast, primary text)
neutral-950:  #0A0A0A   (darkest, maximum contrast)
```

**Contrast Ratios (on white #FFFFFF):**
- neutral-500: 4.54:1 ✓ (WCAG AA text)
- neutral-600: 6.98:1 ✓ (WCAG AA text, AAA large text)
- neutral-700: 9.73:1 ✓ (WCAG AAA all text)
- neutral-900: 15.30:1 ✓ (WCAG AAA all text)

**Usage:**
- neutral-50/100: Backgrounds, subtle highlights
- neutral-200/300: Borders, dividers, input borders
- neutral-400/500: Secondary text, placeholders, disabled states
- neutral-600/700: Body text, readable text
- neutral-800/900: Headings, emphasis, high contrast

---

### Special Colors

#### White & Black

```
white:  #FFFFFF   (pure white - backgrounds)
black:  #000000   (pure black - text on dark themes)
```

#### Transparent

```
transparent:  transparent
current:      currentColor (inherits text color)
```

---

## Typography

### Font Families

```
font-sans:   system-ui, -apple-system, BlinkMacSystemFont,
             "Segoe UI", Roboto, "Helvetica Neue", Arial,
             sans-serif, "Apple Color Emoji", "Segoe UI Emoji"

font-serif:  Georgia, Cambria, "Times New Roman", Times, serif

font-mono:   "Fira Code", ui-monospace, SFMono-Regular, Menlo,
             Monaco, Consolas, "Liberation Mono", "Courier New",
             monospace
```

**Default:** `font-sans` (system fonts for best performance)

---

### Font Sizes

Based on a modular scale with 1rem = 16px base.

```
text-xs:     12px / 0.75rem      (very small text, captions)
text-sm:     14px / 0.875rem     (small text, helper text)
text-base:   16px / 1rem         (body text, default) ⭐
text-lg:     18px / 1.125rem     (large body, emphasized)
text-xl:     20px / 1.25rem      (H4, large UI text)
text-2xl:    24px / 1.5rem       (H3, section headings)
text-3xl:    30px / 1.875rem     (H2, subsection headings)
text-4xl:    36px / 2.25rem      (H2 large, page titles)
text-5xl:    48px / 3rem         (H1, hero headings) ⭐
text-6xl:    60px / 3.75rem      (H1 large, display)
text-7xl:    72px / 4.5rem       (Display, marketing)
text-8xl:    96px / 6rem         (Extra large display)
```

---

### Font Weights

```
font-thin:        100
font-extralight:  200
font-light:       300
font-normal:      400   (body text) ⭐
font-medium:      500   (emphasis, labels)
font-semibold:    600   (subheadings, buttons)
font-bold:        700   (headings, strong emphasis) ⭐
font-extrabold:   800
font-black:       900
```

**Common usage:**
- Body text: 400 (normal)
- UI labels: 500 (medium)
- Buttons: 500-600 (medium/semibold)
- Headings: 600-700 (semibold/bold)

---

### Line Heights

```
leading-none:      1.0    (tight, display text)
leading-tight:     1.25   (headings)
leading-snug:      1.375  (compact text)
leading-normal:    1.5    (body text) ⭐
leading-relaxed:   1.625  (comfortable reading)
leading-loose:     2.0    (very spacious)
```

**Recommended:**
- Headings: 1.2 - 1.3
- Body text: 1.5 - 1.6
- Small text: 1.4 - 1.5

---

### Letter Spacing

```
tracking-tighter:  -0.05em
tracking-tight:    -0.025em
tracking-normal:   0em      ⭐
tracking-wide:     0.025em
tracking-wider:    0.05em
tracking-widest:   0.1em
```

**Usage:**
- Headings: -0.025em (tight)
- Body: 0em (normal)
- All caps: 0.05em (wider)

---

### Typography Scale (Semantic)

**Headings:**

```
H1:
  size: text-5xl (48px)
  weight: font-bold (700)
  line-height: 1.2
  letter-spacing: -0.025em
  color: neutral-900

H2:
  size: text-4xl (36px)
  weight: font-bold (700)
  line-height: 1.25
  letter-spacing: -0.025em
  color: neutral-900

H3:
  size: text-2xl (24px)
  weight: font-semibold (600)
  line-height: 1.3
  color: neutral-800

H4:
  size: text-xl (20px)
  weight: font-semibold (600)
  line-height: 1.4
  color: neutral-800
```

**Body text:**

```
Body large:
  size: text-lg (18px)
  weight: font-normal (400)
  line-height: 1.6
  color: neutral-700

Body:
  size: text-base (16px)
  weight: font-normal (400)
  line-height: 1.5
  color: neutral-700

Body small:
  size: text-sm (14px)
  weight: font-normal (400)
  line-height: 1.5
  color: neutral-600

Caption:
  size: text-xs (12px)
  weight: font-normal (400)
  line-height: 1.5
  color: neutral-500
```

---

## Spacing

Based on 8px base unit for vertical rhythm and consistency.

### Spacing Scale

```
space-0:   0px     (no space)
space-1:   4px     (0.25rem)  - tight spacing
space-2:   8px     (0.5rem)   - base unit ⭐
space-3:   12px    (0.75rem)  - small gaps
space-4:   16px    (1rem)     - standard spacing ⭐
space-5:   20px    (1.25rem)  - medium gaps
space-6:   24px    (1.5rem)   - comfortable spacing
space-8:   32px    (2rem)     - large spacing
space-10:  40px    (2.5rem)   - extra large
space-12:  48px    (3rem)     - section spacing
space-16:  64px    (4rem)     - major sections
space-20:  80px    (5rem)     - hero sections
space-24:  96px    (6rem)     - page sections
```

### Common Spacing Patterns

**Component padding:**
- Tight: 8px (space-2)
- Normal: 16px (space-4)
- Comfortable: 24px (space-6)

**Component gaps:**
- Tight: 8px (space-2)
- Normal: 16px (space-4)
- Wide: 24px (space-6)

**Section margins:**
- Small: 32px (space-8)
- Medium: 48px (space-12)
- Large: 64px (space-16)

**Container padding:**
- Mobile: 16px (space-4)
- Tablet: 24px (space-6)
- Desktop: 32px (space-8)

---

## Breakpoints

Mobile-first responsive breakpoints.

```
sm:   640px    (small tablets, large phones landscape)
md:   768px    (tablets portrait) ⭐
lg:   1024px   (laptops, small desktops) ⭐
xl:   1280px   (desktops)
2xl:  1536px   (large desktops)
```

### Standard Ranges

```
Mobile:        < 768px   (320px - 767px)
Tablet:        768px - 1023px
Desktop:       1024px+
Desktop Large: 1440px+
```

### Container Max Widths

```
Mobile:    100% (with 16px padding)
Tablet:    100% (with 24px padding)
Desktop:   1200px (centered)
Wide:      1440px (centered)
Full:      100% (no max-width)
```

---

## Shadows

Elevation system using box shadows.

```
shadow-xs:   0 1px 2px rgba(0, 0, 0, 0.05)
             (subtle, borders)

shadow-sm:   0 2px 4px rgba(0, 0, 0, 0.05)
             (buttons, small cards)

shadow-md:   0 4px 8px rgba(0, 0, 0, 0.1)
             (cards, dropdowns) ⭐

shadow-lg:   0 8px 16px rgba(0, 0, 0, 0.1)
             (modals, large dropdowns)

shadow-xl:   0 12px 24px rgba(0, 0, 0, 0.15)
             (popovers, floating panels)

shadow-2xl:  0 24px 48px rgba(0, 0, 0, 0.2)
             (dialogs, overlays)

shadow-inner:  inset 0 2px 4px rgba(0, 0, 0, 0.06)
               (pressed buttons, input fields)

shadow-none:   none
```

### Focus Shadows

```
focus-ring:  0 0 0 3px rgba(0, 102, 204, 0.2)
             (primary focus indicator)

focus-ring-error:  0 0 0 3px rgba(239, 68, 68, 0.2)
                   (error state focus)
```

---

## Border Radius

```
rounded-none:   0px      (sharp corners)
rounded-sm:     2px      (subtle rounding)
rounded:        4px      (slight rounding)
rounded-md:     6px      (medium rounding)
rounded-lg:     8px      (comfortable rounding) ⭐
rounded-xl:     12px     (large rounding)
rounded-2xl:    16px     (extra large rounding)
rounded-3xl:    24px     (very round)
rounded-full:   9999px   (pill shape, circular)
```

**Common usage:**
- Buttons: 8px (rounded-lg)
- Cards: 8px (rounded-lg)
- Inputs: 4px (rounded)
- Modals: 8px (rounded-lg)
- Avatars: 9999px (rounded-full)
- Tags/badges: 4px or 9999px

---

## Z-Index

Layering system for stacking context.

```
z-0:       0      (base layer)
z-10:      10     (dropdowns, tooltips)
z-20:      20     (sticky headers)
z-30:      30     (fixed elements)
z-40:      40     (overlays)
z-50:      50     (modals, dialogs)
z-60:      60     (popovers above modals)
z-70:      70     (notifications, toasts)
z-80:      80     (critical alerts)
z-90:      90     (loading overlays)
z-100:     100    (maximum, dev tools)
```

**Common usage:**
- Tooltips: z-10
- Sticky header: z-20
- Dropdown menus: z-10
- Modal backdrop: z-40
- Modal content: z-50
- Toast notifications: z-70

---

## Transitions

Timing and easing for animations.

### Duration

```
duration-75:    75ms    (instant)
duration-100:   100ms   (very fast)
duration-150:   150ms   (fast)
duration-200:   200ms   (normal) ⭐
duration-300:   300ms   (comfortable)
duration-500:   500ms   (slow)
duration-700:   700ms   (very slow)
duration-1000:  1000ms  (extra slow)
```

### Easing

```
ease-linear:      linear
ease-in:          cubic-bezier(0.4, 0, 1, 1)
ease-out:         cubic-bezier(0, 0, 0.2, 1) ⭐
ease-in-out:      cubic-bezier(0.4, 0, 0.2, 1)
```

**Recommended:**
- Hover effects: 200ms ease-out
- Modal open/close: 300ms ease-out
- Dropdown: 200ms ease-out
- Loading spinners: 1000ms linear (infinite)

### Common Transitions

```
Button hover:
  transition: all 200ms ease-out

Modal backdrop:
  transition: opacity 300ms ease-out

Dropdown menu:
  transition: opacity 200ms ease-out,
              transform 200ms ease-out

Tooltip:
  transition: opacity 150ms ease-out

Accordion expand:
  transition: max-height 300ms ease-out
```

---

## Usage Examples

### CSS Variables

```css
:root {
  /* Colors */
  --color-primary: #0066CC;
  --color-primary-hover: #0052A3;
  --color-primary-active: #003D7A;

  --color-success: #22C55E;
  --color-warning: #F59E0B;
  --color-error: #EF4444;
  --color-info: #3B82F6;

  --color-neutral-50: #FAFAFA;
  --color-neutral-900: #171717;

  /* Typography */
  --font-sans: system-ui, -apple-system, sans-serif;
  --text-base: 1rem;
  --text-lg: 1.125rem;
  --font-normal: 400;
  --font-bold: 700;
  --leading-normal: 1.5;

  /* Spacing */
  --space-2: 0.5rem;
  --space-4: 1rem;
  --space-6: 1.5rem;
  --space-8: 2rem;

  /* Shadows */
  --shadow-md: 0 4px 8px rgba(0, 0, 0, 0.1);
  --shadow-lg: 0 8px 16px rgba(0, 0, 0, 0.1);

  /* Border radius */
  --rounded-lg: 8px;

  /* Transitions */
  --duration-200: 200ms;
  --ease-out: cubic-bezier(0, 0, 0.2, 1);
}
```

### Using Tokens

```css
/* Button */
.button {
  background: var(--color-primary);
  color: white;
  padding: var(--space-3) var(--space-6);
  border-radius: var(--rounded-lg);
  font-weight: var(--font-medium);
  font-size: var(--text-base);
  box-shadow: var(--shadow-sm);
  transition: all var(--duration-200) var(--ease-out);
}

.button:hover {
  background: var(--color-primary-hover);
  box-shadow: var(--shadow-md);
}

/* Card */
.card {
  background: white;
  padding: var(--space-6);
  border-radius: var(--rounded-lg);
  box-shadow: var(--shadow-md);
}

/* Typography */
.heading-1 {
  font-size: var(--text-5xl);
  font-weight: var(--font-bold);
  line-height: 1.2;
  color: var(--color-neutral-900);
}

.body-text {
  font-size: var(--text-base);
  font-weight: var(--font-normal);
  line-height: var(--leading-normal);
  color: var(--color-neutral-700);
}
```

---

## Design System Checklist

When creating a design, ensure you use:

```
Color:
[ ] Primary color for main actions
[ ] Semantic colors (success, warning, error, info) appropriately
[ ] Neutral colors for text and backgrounds
[ ] All color combinations meet WCAG AA contrast (4.5:1)

Typography:
[ ] Consistent font family (system fonts)
[ ] Proper heading hierarchy (H1 → H2 → H3)
[ ] Body text 16px minimum
[ ] Line height 1.5 for body text
[ ] Appropriate font weights (400 body, 600-700 headings)

Spacing:
[ ] All spacing multiples of 8px
[ ] Consistent component padding
[ ] Consistent gaps between elements
[ ] Responsive spacing (smaller on mobile)

Components:
[ ] Border radius consistent (8px recommended)
[ ] Shadows for elevation (cards, modals)
[ ] Proper transitions (200ms ease-out)
[ ] All states defined (hover, focus, active, disabled)

Responsive:
[ ] Mobile-first approach
[ ] Breakpoints at 768px and 1024px
[ ] Container max-width on desktop
[ ] Responsive typography

Accessibility:
[ ] Touch targets 44px minimum
[ ] Focus indicators visible (2px outline)
[ ] Color not sole indicator
[ ] Semantic HTML with tokens
```

---

## Token Naming Convention

```
[category]-[property]-[variant]

Examples:
- color-primary-500
- space-4
- text-lg
- shadow-md
- rounded-lg
- duration-200
```

---

## Resources

**Verify color contrast:**
```bash
python scripts/contrast-check.py #0066CC #FFFFFF
```

**View responsive breakpoints:**
```bash
bash scripts/responsive-breakpoints.sh
```

**More details:**
- design-patterns.md - UI patterns using these tokens
- accessibility-guide.md - Accessibility requirements
- REFERENCE.md - Complete design reference

---

## Summary

**Core Tokens to Remember:**

- **Primary color:** #0066CC (primary-500)
- **Base font size:** 16px (text-base)
- **Base spacing:** 8px (space-2)
- **Body line height:** 1.5 (leading-normal)
- **Border radius:** 8px (rounded-lg)
- **Transition:** 200ms ease-out
- **Breakpoints:** 768px (md), 1024px (lg)
- **Shadow:** 0 4px 8px rgba(0,0,0,0.1) (shadow-md)

**Remember:** Tokens create consistency. Use them everywhere, don't hardcode values.
