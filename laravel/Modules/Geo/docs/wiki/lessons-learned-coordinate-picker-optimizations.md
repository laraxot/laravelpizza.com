# Lessons Learned – Coordinate Picker Optimizations

## Best Practices
- Always initialize map **after** container becomes visible (`DOMContentLoaded` + MutationObserver on 12 ancestors to reach wizard step x‑show).
- Enforce **minimum CSS size** (`min-height:400px; min-width:100%`) to guarantee non‑zero dimensions for Leaflet.
- Use **placeholder tile layer** (low opacity) while real tiles load, then remove it on first `tileload`.
- **Geolocate‑when‑empty** should be an always‑on behavior, not a toggle – trigger automatically when `latitude`/`longitude` are null.
- Use **boolean property change** (`geolocateWhenEmpty`) instead of string/number binding for flags.
- Prefer **`:state`** over `x-bind:state.prop` for Lit state bindings (cleaner, idiomatic Lit).
- **Never** use `IntersectionObserver` for hidden‑by‑CSS (`display: none / x‑show`) toggles – use `MutationObserver` on `class`, `style`, `hidden` attributes.

## Bad Practices
- Omitting `min-height/min-width` → map stays zero‑sized → blank tiles.
- Relying on `IntersectionObserver` for wizard step visibility.
- Initializing Leaflet before container is visible.
- Using `x-bind:state.prop` instead of `:state` for Lit component state.
- Treating geolocation as a one‑time toggle rather than a fallback when coordinates are missing.

## False Friends
- **"IntersectionObserver works for hidden wizard steps"** – it only reacts to viewport intersection, not CSS `display`/`visibility` changes.
- **"Geolocation can be a user‑controlled switch"** – if data is missing, auto‑locate; don’t leave the map blank.
- **"x‑bind:state.prop is equivalent to :state"** – `.prop` forces string coercion; prefer native Lit binding.