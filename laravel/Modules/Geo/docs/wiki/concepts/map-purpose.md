---
name: map-purpose
description: Purpose and functionality of the map component in the FixCity admin ticket creation wizard.
---

# Map Component Purpose in FixCity Admin Ticket Wizard

**Location:** `http://127.0.0.1:8000/fixcity/admin/tickets/create?step=form.data::data::wizard-step`

## Goal
The map allows city staff to accurately locate a reported issue when creating a ticket. It serves four main functions:

1. **Geospatial input:** Users can set the latitude and longitude of the incident by clicking on the map or dragging the marker.
2. **Geolocation fallback:** When the form is opened with empty coordinates, the component requests the user's current position (if permitted) and centers the map on it, ensuring a sensible default location.
3. **Contextual UI controls:** Full‑screen toggle, zoom, and layer switching let staff explore the area around the incident, improving situational awareness.
4. **Address search:** A Lit-based search input (`search-input.js`) allows staff to look up an address via Nominatim API and automatically center the map on the result.

## Technical Overview
- Implemented as a LitElement (`coordinate-picker-lit.js` / `map-picker-lit.js`).
- Uses **Leaflet** with custom SVG marker assets located in `Modules/Geo/resources/svg/`.
- Handles Filament 5 wizard visibility via a deep `MutationObserver` (depth ≥ 12) that triggers `invalidateSize()` when the step becomes visible.
- Provides a search box (`search-input.js`) for address lookup via the Nominatim API.
- State is stored in the component’s `state` object (`latitude`, `longitude`).

## Why It Matters
- Precise location data is essential for routing field teams and for downstream analytics.
- The fallback geolocation prevents empty coordinates, which otherwise would break map rendering.
- UI controls ensure staff can verify the exact spot, reducing mis‑placements.

## Related Documentation
- `admin-map-visibility-fix.md` – details of the visibility fix.
- `leaflet-wizard-invalidate-size.md` – explains the `invalidateSize` strategy.
- `map-marker-custom-asset.md` – outlines the custom SVG marker assets.
- `map-picker-default-coordinates.md` – default coordinate handling.

---
*This entry follows the LLM‑Wiki discipline: concise purpose, technical details, and links to related concepts.*
