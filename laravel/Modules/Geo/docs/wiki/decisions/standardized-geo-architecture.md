# ADR: Standardized Geo Architecture (2026.1)

## Status
**Proposed / Accepted** (2026-04-22)

## Context
The project shifted towards complex, multi-step wizards for resource creation (e.g., Ticket Creation). Legacy geographic components using standard Shadow DOM and raw initialization suffered from:
1. "Blank map" syndrome when placed in hidden steps.
2. Disappearing map instances on Livewire state updates.
3. Inconsistent UI controls and missing icons due to escaping.

## Decision
We standardize all geographic components on the **"Guarded Light DOM"** pattern.

### Key Rules
1. **Light DOM**: Components must use `createRenderRoot() { return this; }`.
2. **Guarded Pane**: The Leaflet map container must be wrapped in Lit's `guard` directive with an empty dependency array `[]` to prevent re-renders of the map pane.
3. **Responsive Invalidation**: Implementation of `ResizeObserver` + `invalidateSize()` is mandatory for all map-based components.
4. **Template Icons**: Icons must be exported as `html` template results, not raw strings, to ensure proper SVG rendering.
5. **Agnostic Components**: Remove legacy Laravel controllers; rely on Actions and direct model-based interaction for data persistence.

## Consequences
- **Positive**: 100% stability in Wizards and Tabs. Shared styles (Vanilla CSS) are easier to apply (no more `:host` and `::part` complexity for basic layout).
- **Negative**: Greater care needed with global CSS namespace (since components are in Light DOM), but minimized by using specific BEM classes like `.map-picker-leaflet-pane`.
- **Neutral**: Unified visual language across all pickers (Coordinate, Place, Geopoint, Map).

## Participants
- Antigravity AI
- Project Lead (USER)
