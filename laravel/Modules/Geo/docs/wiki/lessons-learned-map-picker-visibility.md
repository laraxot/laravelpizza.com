# Lessons Learned – Map Picker Visibility

## Best Practices
- Ensure the map container has a solid background (e.g., `bg-white`) when rendered in dynamic wizard steps to prevent transparent areas that hide tiles.
- Initialize the Leaflet map after the DOM is ready (`DOMContentLoaded` or within a `setTimeout` after the step becomes visible) to guarantee correct dimensions.
- Use `pointer-events: auto` on the map wrapper to allow interaction with dropdowns and controls.

## Bad Practices
- Relying on inherited transparent backgrounds (`bg-transparent`) which cause the map to render invisibly.
- Initializing the map before the container is visible (e.g., while a step is still hidden), leading to zero‑size maps.
- Forgetting to expose the map controls (`fullscreen`, `zoom`, `layer switcher`) via proper z‑index and `pointer-events`.

## False Friends
- **Leaflet CSS alone is sufficient** – you also need the JavaScript initialization code; otherwise the map remains empty.
- **Any div with `class="map-wrapper"` will work** – specific styling may be required to override Tailwind/ Bootstrap utilities that set `opacity` or `visibility`.
- **Hard‑coding coordinates** – use the dynamic geolocation fallback (`getCurrentCoordinates()`) for robust default centering.

## References
- MapPicker Default Coordinates Rule (`laravel/Modules/Geo/docs/wiki/map-picker-default-coordinates.md`)
- SVG Asset Location (`laravel/Modules/Geo/docs/wiki/svg-asset-location.md`)
- Leaflet initialization in `coordinate-picker-lit.js`