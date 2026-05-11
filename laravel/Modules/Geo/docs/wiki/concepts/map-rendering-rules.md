---
name: map-rendering-rules
description: Best practices, bad practices and false friends for rendering maps in Filament wizard components.
type: concept
---

# Map Rendering Rules for Filament Wizard

## Golden Rule
- **Render maps only after the container becomes visible** (depth ≥ 12 MutationObserver for Filament 5 wizard steps).  
- **Always set an explicit height** (`height="400px"` or via CSS) on the Leaflet pane.  
- **Force tile redraw** after size changes: `map.invalidateSize({animate:false})` + `forceTileRedraw()`.

## Common Failure Modes

| Symptom | Typical Cause | Fix |
|---------|---------------|-----|
| Blank gray area | Container hidden (`class="hidden"` or `display:none`) when Leaflet initializes | Use `MutationObserver` watching **≥ 12** ancestors for `class`, `style`, `hidden` attributes; trigger `invalidateSize()` only when `offsetParent !== null`. |
| Tiles load but map stays empty | Tile layer not re‑drawn after resize | Call `map.off('tileload')` then `map.on(' tileload', …)` or `map.invalidateSize()` after a **debounced** delay array `[0,80,180,350,700,1200]ms`. |
| Map flickers on step navigation | `ResizeObserver` fires too early or too often | Throttle with `debounce` (≥ 350 ms) and guard with `visibility && offsetParent`. |
| No reverse‑geocode results | `showSearch` disabled or API key missing | Keep `showSearch="true"` globally; configure `User-Agent` and `timeout` on Nominatim calls; fallback to default coordinates (41.9028, 12.4964). |
| Controller errors `Cannot redeclare final method __construct()` | Custom `__construct()` in field class | **Never** declare `__construct()` in custom fields; use `setUp()` for initialization only. |

## Best Practices

1. **Depth‑aware MutationObserver**  
   ```js
   let parent = this.element;
   for (let i = 0; i < 14 && parent; i++) {
       observer.observe(parent, { attributes: true, attributeFilter: ['class','style','hidden'] });
       parent = parent.parentElement;
   }
   ```
2. **Visibility Guard**  
   ```js
   if (this.offsetParent === null) return; // skip hidden ancestors
   ```
3. **Explicit Height & CSS**  
   ```css
   .map-picker-leaflet-pane { min-height:400px; }
   ```
4. **Tile Layer Redraw**  
   ```js
   setTimeout(() => this._map.invalidateSize(false), 350);
   ```
5. **Fallback Geolocation**  
   ```js
   if (!this._lat && !this._lng && this.geolocateWhenEmpty) this._requestGeolocation();
   ```
6. **No CDN Markers**  
   Use `createMapPickerLeafletIcon(L)` with **inline SVG**; never rely on `L.Icon.Default` or unpkg URLs.

## Bad Practices ❌

- Using `IntersectionObserver` to detect wizard step activation (fails with `class="hidden"` toggles).  
- Omitting explicit `height` – Leaflet defaults to `0×0`.  
- Directly editing `leaflet.css` inside component – breaks theming and prevents overrides.  
- Hardcoding API keys in client‑side code – violates CSP and security policies.  
- Defining a custom `__construct()` in a field extending `Field` – triggers fatal “final method” error.  

## False Friends ⚠️

| Term | Misconception | Reality |
|------|---------------|---------|
| `showSearch="false"` | Saves bandwidth | Actually disables address lookup, breaking fallback geolocation when coordinates are null. |
| `depth=6` observer | Sufficient for Filament 5 | Wizard step wrapper is **≥ 12** levels deep; depth 6 never reaches the `x-show` toggle. |
| `OMNICLASS` CSS selector | One‑size‑fits‑all styling | Must target `.map-picker-leaflet-pane` *and* any `.bg-gray-900` overlays that suppress pointer events. |
| `L.Icon.Default` | Default Leaflet marker | Loads assets from CDN; blocked in offline or enterprise environments. Use locale‑owned SVG via `divIcon`. |

## Documentation Ingestion

- Add this file to the module’s wiki index: `qmd index --path Modules/Geo/docs/wiki/concepts/map-rendering-rules.md`.  
- Update `docs/wiki/concepts/index.md` with a link to **Map Rendering Rules**.  
- Run `ctx_batch_execute` to re‑index the concepts collection for fast search.
