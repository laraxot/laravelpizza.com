---
name: map-picker-admin-visibility
description: Specific troubleshooting steps for missing map on the admin ticket‑creation page
---

# Admin Ticket Creation – Map Not Visible

## Symptom
When navigating to `http://127.0.0.1:8000/fixcity/admin/tickets/create` the Leaflet map inside the **CoordinatePicker** component does not appear. The page loads without any errors in the console, but the map container is empty and no tiles are rendered.

## Root Causes (identified)
1. **Component not initialized** – The `<coordinate-picker-lit>` custom element is inserted **after** the wizard step is made visible, so Leaflet is instantiated while the container has a size of `0×0`.
2. **CSS interference** – Bootstrap Italia adds `.dropdown-menu { display: none !important }` and a dark background (`bg-gray-900`) that hides the map controls and prevents pointer events.
3. **Asset path errors** – The map’s custom marker SVG was missing from the expected `resources/svg/` location, causing Leaflet to fall back to an unstyled default icon that is hidden by the theme.

## Fixes Applied
- Added a **MutationObserver** with depth `≥12` in `map-picker-lit.js` to detect when the parent wizard step exits the `hidden` class and then call `map.invalidateSize()` with a 700‑1200 ms delay.
- Updated the map wrapper’s CSS: added `bg-white` for the admin page and forced `pointer-events: auto` on `.map-container`.
- Ensured the custom SVG marker `map-marker.svg` exists under `laravel/Modules/Geo/resources/svg/` and referenced it via `L.divIcon`.
- Re‑built the theme assets: `cd laravel/Themes/Sixteen && npm run build && npm run copy`.

## Verification Checklist
- [ ] Open the URL in a browser and confirm the map container has a non‑zero width/height.
- [ ] Verify at least one tile loads (`.leaflet-tile` without `leaflet-tile-error`).
- [ ] Click on the map – latitude/longitude fields should update.
- [ ] Capture a screenshot (`admin-tickets-create-map.png`) and compare with the reference `docs/design-comuni/screenshots/admin-tickets-create-map.png`.

## Reference
- `laravel/Modules/Geo/docs/wiki/concepts/map-picker-troubleshooting.md` – general guide.
- `laravel/Modules/Geo/resources/js/components/map-picker-lit.js` – MutationObserver implementation.
- `laravel/Modules/Geo/resources/svg/map-marker.svg` – custom marker asset.

---
*Keep this guide up‑to‑date whenever the admin ticket creation UI changes. It is part of the LLM‑Wiki operational discipline.*