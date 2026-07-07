# Argomenti Page Analysis

## Status: IN PROGRESS

### Screenshot Comparison

| Reference | Local |
|-----------|-------|
| ![Reference](/tmp/argomenti-ref.png) | ![Local](/tmp/argomenti-local.png) |

## HTML Diff - Structural Differences

1. **Hero Section**: Same structure ✓
2. **Topics Grid**: Reference has cards with images, Local has text-only list
3. **"In Evidenza" section**: Cards with images in grid (3 columns) - Local shows but layout differs

## CSS Differences

1. Grid layout for topics cards (3 columns)
2. Card styling with images
3. Icons per topic

## Files to Check

- JSON: `tests.argomenti.json`
- Blade: topics-grid component
- CSS: comune-custom.css

## Status: NEEDS FIX

**Priority**: Medium - Per workflow "HTML FIRST" valutare se strukturale o CSS

---

*Created: 2026-04-07*
*Page: argomenti*
*Category: design-comuni*