#!/bin/bash

# Responsive Breakpoints Reference
# Standard breakpoints for mobile-first responsive design

cat << 'EOF'
================================================================================
                        RESPONSIVE BREAKPOINTS REFERENCE
================================================================================

STANDARD BREAKPOINTS (Mobile-First)
--------------------------------------------------------------------------------

Mobile (Extra Small)
  Range:        320px - 767px
  Target:       Phones in portrait and landscape
  Columns:      1 column layout
  Container:    100% width, 16px padding
  Font base:    16px
  Touch target: ≥ 44px × 44px
  Media query:  @media (min-width: 320px) { /* base styles */ }

Tablet (Medium)
  Range:        768px - 1023px
  Target:       Tablets in portrait, large phones in landscape
  Columns:      2 column layout
  Container:    100% width, 24px padding
  Font base:    16px
  Touch target: ≥ 44px × 44px (still touch-capable)
  Media query:  @media (min-width: 768px) { /* tablet styles */ }

Desktop (Large)
  Range:        1024px - 1439px
  Target:       Laptops, small desktops
  Columns:      3-4 column layout
  Container:    960px - 1200px max-width, centered
  Font base:    18px
  Click target: ≥ 40px × 40px (mouse-capable)
  Media query:  @media (min-width: 1024px) { /* desktop styles */ }

Desktop XL (Extra Large)
  Range:        1440px+
  Target:       Large desktops, high-res displays
  Columns:      4-6 column layout
  Container:    1200px - 1440px max-width, centered
  Font base:    18px
  Click target: ≥ 40px × 40px
  Media query:  @media (min-width: 1440px) { /* xl desktop styles */ }

================================================================================

DETAILED BREAKPOINT SPECIFICATIONS
--------------------------------------------------------------------------------

320px - 479px (Small Mobile)
  • Single column, full width
  • Stack all content vertically
  • Large buttons (min 48px height)
  • Hide non-essential UI elements
  • Simplified navigation (hamburger menu)
  • Images: 100% width
  • Font: 16px base (prevents iOS zoom)

480px - 767px (Large Mobile)
  • Still single column
  • Can introduce 2-column grids for small items
  • Show more content above fold
  • Larger text possible
  • Images: 100% width or 2-column grid

768px - 1023px (Tablet)
  • 2-3 column layouts
  • Sidebar can be visible
  • Navigation can expand (not hamburger)
  • Touch targets still 44px minimum
  • Images: 2-3 column grid
  • More whitespace

1024px - 1439px (Desktop)
  • 3-4 column layouts
  • Full navigation bar
  • Sidebars for auxiliary content
  • Hover states active
  • Images: 3-4 column grid
  • Max content width: 1200px

1440px+ (Large Desktop)
  • 4-6 column layouts
  • Wider containers
  • More whitespace/margins
  • Enhanced graphics/imagery
  • Max content width: 1440px
  • Prevent excessive line length

================================================================================

CSS MEDIA QUERIES (Mobile-First Approach)
--------------------------------------------------------------------------------

/* Base styles (mobile 320px+) */
.container {
  width: 100%;
  padding: 0 16px;
}

.grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 16px;
}

/* Tablet (768px+) */
@media (min-width: 768px) {
  .container {
    padding: 0 24px;
  }

  .grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
  }
}

/* Desktop (1024px+) */
@media (min-width: 1024px) {
  .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 32px;
  }

  .grid {
    grid-template-columns: repeat(3, 1fr);
    gap: 32px;
  }
}

/* Desktop XL (1440px+) */
@media (min-width: 1440px) {
  .container {
    max-width: 1440px;
  }

  .grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

================================================================================

RESPONSIVE TYPOGRAPHY SCALE
--------------------------------------------------------------------------------

Mobile (320px+):
  H1:     28px / 1.75rem  (line-height: 1.2)
  H2:     24px / 1.5rem   (line-height: 1.25)
  H3:     20px / 1.25rem  (line-height: 1.3)
  H4:     18px / 1.125rem (line-height: 1.4)
  Body:   16px / 1rem     (line-height: 1.5)
  Small:  14px / 0.875rem (line-height: 1.5)

Tablet (768px+):
  H1:     36px / 2.25rem  (line-height: 1.2)
  H2:     28px / 1.75rem  (line-height: 1.25)
  H3:     22px / 1.375rem (line-height: 1.3)
  H4:     18px / 1.125rem (line-height: 1.4)
  Body:   16px / 1rem     (line-height: 1.5)
  Small:  14px / 0.875rem (line-height: 1.5)

Desktop (1024px+):
  H1:     48px / 3rem     (line-height: 1.2)
  H2:     36px / 2.25rem  (line-height: 1.25)
  H3:     24px / 1.5rem   (line-height: 1.3)
  H4:     20px / 1.25rem  (line-height: 1.4)
  Body:   18px / 1.125rem (line-height: 1.6)
  Small:  16px / 1rem     (line-height: 1.5)

Desktop XL (1440px+):
  H1:     56px / 3.5rem   (line-height: 1.2)
  H2:     40px / 2.5rem   (line-height: 1.25)
  H3:     28px / 1.75rem  (line-height: 1.3)
  H4:     22px / 1.375rem (line-height: 1.4)
  Body:   18px / 1.125rem (line-height: 1.6)
  Small:  16px / 1rem     (line-height: 1.5)

================================================================================

COMPONENT BEHAVIOR BY BREAKPOINT
--------------------------------------------------------------------------------

Navigation:
  Mobile:   Hamburger menu, full-screen overlay
  Tablet:   Expanded menu or visible sidebar
  Desktop:  Horizontal navigation bar with dropdowns

Cards:
  Mobile:   1 column, 100% width, stacked
  Tablet:   2 columns, 50% width each (minus gap)
  Desktop:  3-4 columns, equal width grid

Forms:
  Mobile:   100% width inputs, stacked
  Tablet:   Some inline (e.g., first/last name)
  Desktop:  Max 400px width, inline where appropriate

Modals:
  Mobile:   Full screen, slide from bottom
  Tablet:   80% width, centered overlay
  Desktop:  Max 600px width, centered overlay

Tables:
  Mobile:   Card view or horizontal scroll
  Tablet:   Visible columns with scroll if needed
  Desktop:  Full table layout

Sidebar:
  Mobile:   Hidden or bottom drawer
  Tablet:   Collapsible or always visible
  Desktop:  Always visible, fixed or sticky

Images:
  Mobile:   100% width, stacked
  Tablet:   50% width, 2-column grid
  Desktop:  33% width, 3-column grid

================================================================================

TESTING CHECKLIST
--------------------------------------------------------------------------------

[ ] Test at each breakpoint: 320px, 768px, 1024px, 1440px
[ ] Test in-between sizes: 480px, 900px, 1200px
[ ] Test zoom at 200% (WCAG requirement)
[ ] Test portrait and landscape orientations
[ ] Test touch targets ≥ 44px on mobile/tablet
[ ] Test no horizontal scroll at 320px width
[ ] Test content reflow and readability
[ ] Test images scale appropriately
[ ] Test navigation works at all sizes
[ ] Test forms are usable on mobile
[ ] Test modals/overlays on mobile
[ ] Test performance on mobile networks

================================================================================

COMMON DEVICES (For Testing)
--------------------------------------------------------------------------------

Phones:
  iPhone SE:           375 × 667 (2x)
  iPhone 12/13/14:     390 × 844 (3x)
  iPhone 14 Pro Max:   430 × 932 (3x)
  Samsung Galaxy S21:  360 × 800 (3x)
  Google Pixel 5:      393 × 851 (2.75x)

Tablets:
  iPad:                768 × 1024 (2x)
  iPad Air:            820 × 1180 (2x)
  iPad Pro 11":        834 × 1194 (2x)
  iPad Pro 12.9":      1024 × 1366 (2x)
  Samsung Tab S7:      800 × 1280 (2.5x)

Desktops:
  Small laptop:        1366 × 768
  MacBook Air:         1440 × 900 (2x)
  MacBook Pro 14":     1512 × 982 (2x)
  Full HD:             1920 × 1080
  4K:                  3840 × 2160

================================================================================

MOBILE-FIRST DEVELOPMENT WORKFLOW
--------------------------------------------------------------------------------

1. Design for mobile (320px) first
   - Simplest layout
   - Essential content only
   - Large touch targets

2. Add tablet styles (768px+)
   - 2-column layouts where appropriate
   - Reveal more content
   - Expand navigation

3. Add desktop styles (1024px+)
   - Multi-column layouts
   - Sidebars and auxiliary content
   - Hover states and interactions

4. Enhance for large screens (1440px+)
   - Wider containers
   - More whitespace
   - Enhanced visuals

5. Test at all breakpoints
   - Real devices when possible
   - Browser DevTools device emulation
   - Responsive design mode

================================================================================

BEST PRACTICES
--------------------------------------------------------------------------------

✓ Design mobile-first (smallest screen first)
✓ Use min-width media queries
✓ Test at actual breakpoints and in-between
✓ Use relative units (rem, em, %, vw/vh)
✓ Consider touch vs. mouse interactions
✓ Ensure content reflows, doesn't break
✓ Maintain readability at all sizes
✓ Keep line length 45-75 characters
✓ Use flexible images (max-width: 100%)
✓ Test with real content, not lorem ipsum

✗ Don't use max-width queries (mobile-first uses min-width)
✗ Don't design for specific devices (design for ranges)
✗ Don't hide important content on mobile
✗ Don't rely only on hover states
✗ Don't use fixed widths everywhere
✗ Don't forget landscape orientations
✗ Don't ignore performance on mobile
✗ Don't forget touch target sizes

================================================================================

QUICK REFERENCE
--------------------------------------------------------------------------------

Minimum widths:  320px (mobile), 768px (tablet), 1024px (desktop)
Maximum widths:  767px (mobile), 1023px (tablet), no max (desktop)
Touch targets:   ≥ 44px × 44px (mobile/tablet), ≥ 40px × 40px (desktop)
Font size:       ≥ 16px (prevents iOS zoom)
Line length:     45-75 characters for readability
Contrast:        ≥ 4.5:1 (text), ≥ 3:1 (UI components) - WCAG AA

================================================================================

For more information, see:
  - REFERENCE.md (responsive design strategies)
  - resources/design-tokens.md (breakpoint variables)

================================================================================
EOF
