# MCP Tools Integration — Geo Module

**Data:** 2026-06-03  
**Scope:** AI-powered UI/UX tools for map and geolocation features  
**Related:** `docs/mcp-tools-master-guide.md`

---

## Overview

This document describes how MCP (Model Context Protocol) tools integrate with the Geo module for enhanced UI/UX development.

---

## Recommended Tools for Geo Module

### 1. Playwright MCP

**Purpose:** Automated testing of map-lit component

**Usage:**
```bash
# Test map rendering
npx @playwright/mcp@latest
```

**Prompts:**
```
Navigate to http://127.0.0.1:8000/it/# and verify map-lit is visible
Check that markers load from /data/tickets.json
Verify cluster behavior on zoom
```

**Configuration:** See `docs/playwright-mcp-config.json`

---

### 2. Impeccable

**Purpose:** Design refinement for map components

**Commands:**
```
/impeccable polish the map legend
/impeccable critique the cluster hover interactions
/impeccable layout fix the map container spacing
/impeccable colorize add strategic colors to marker pins
```

**Anti-Patterns to Avoid:**
- No gray text on colored map markers
- Verify contrast on popup content
- Smooth transitions for cluster animations (150-300ms)
- prefers-reduced-motion support

---

### 3. UI UX Pro Max

**Purpose:** Design system generation for map components

**Prompts:**
```
Generate a design system for the Geo module map component
Focus on: interactive markers, cluster visualization, filter integration
Style: Clean, accessible, mobile-responsive
```

**Expected Output:**
- Color palette for marker states (pending/in-progress/completed)
- Typography for map popups
- Spacing for legend and controls
- Responsive breakpoints

---

### 4. Flowbite MCP

**Purpose:** UI components for map controls and sidebar

**Components Useful for Geo:**
- Dropdowns for filter menus
- Modals for marker details
- Buttons for map controls
- Cards for location info
- Tooltips for marker hover

**Prompts:**
```
Create a Flowbite dropdown for map filter types
Generate a responsive sidebar for map legend using Flowbite
Build a modal component for ticket details popup
```

---

## Integration Examples

### Map Legend with Impeccable

```
/impeccable polish the map legend component
Requirements:
- Collapsible design
- Shows status colors (not types)
- Matches Sixteen theme
- Mobile-responsive
```

### Marker Clusters with UI UX Pro Max

```
/ui-ux-pro-max Design marker cluster visualization
Context:
- Using Leaflet.markercluster
- Status colors: pending (orange), in-progress (blue), completed (green)
- Need hover states
- Accessibility: WCAG AA
```

### Filter Sidebar with Flowbite

```
use flowbite mcp to create a collapsible filter sidebar
Requirements:
- Checkbox filters for ticket types
- Mobile drawer on small screens
- Smooth transitions
- Accessible focus states
```

---

## Testing with Playwright MCP

### Map Component Tests

```
Navigate to http://127.0.0.1:8000/it/#
Verify map-lit element is visible
Check that at least 10 markers are loaded
Verify cluster groups are visible at default zoom
Click on a cluster and verify zoom-in
Click on a marker and verify popup opens
```

### Legend Tests

```
Navigate to http://127.0.0.1:8000/it/#
Verify map legend is visible
Check that legend shows status colors
Verify legend is collapsible on mobile
```

---

## Configuration Files

Copy relevant configs from project root `docs/`:

| File | Purpose |
|------|---------|
| `playwright-mcp-config.json` | Browser automation |
| `flowbite-mcp-config.json` | Flowbite components |

---

## Best Practices

### For Map Components

1. **Accessibility First**
   - Use Impeccable's contrast rules (≥4.5:1)
   - Ensure keyboard navigation for controls
   - Provide prefers-reduced-motion alternatives

2. **Mobile-Responsive**
   - Test with Playwright MCP at 375px width
   - Use UI UX Pro Max for mobile-first design
   - Legend collapsible on small screens

3. **Performance**
   - Use Impeccable's optimize command
   - Lazy load map markers
   - Debounce cluster refreshes

4. **Consistent Design**
   - Match Sixteen theme colors
   - Use Flowbite components for controls
   - Follow Impeccable anti-pattern rules

---

## References

- Master Guide: `docs/mcp-tools-master-guide.md`
- Playwright MCP: `docs/playwright-mcp-setup.md`
- Impeccable: `docs/impeccable-complete-guide.md`
- UI UX Pro Max: `docs/ui-ux-pro-max-guide.md`
- Flowbite MCP: `docs/flowbite-mcp-guide.md`

---

**Status:** Documented and ready for integration

**Last Updated:** 2026-06-03
