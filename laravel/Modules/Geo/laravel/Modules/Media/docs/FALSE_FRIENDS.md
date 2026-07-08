# False Friends – Media Module

| Concept | Misconception | Correction |
|---------|---------------|------------|
| **SVG Location** | `resources/img/markers/` is acceptable | Must be `resources/svg/` only - CDN references forbidden |
| **Asset Versioning** | Hardcoded CDN URLs like `unpkg.com` are okay | Must use internal versioned assets from `resources/svg/` |
| **Inline SVG** | Inline SVG in Blade is required for customization | Must use Blade `@svg()` helper or Vite raw imports |
| **SVG Size** | Width/height only matter visually | Must define maintainable `viewBox` and explicit `width`/`height` |
| **Icon Templates** | `L.Icon.Default` works for all cases | Must use custom SVG icons following `map-marker-custom-asset.md` |

## Examples of Errors

### Error 1: Improper Asset Path
```javascript
// ❌ FALSE FRIEND - CDN dependency
const iconUrl = 'https://unpkg.com/leaflet@1.9.4/dist/marker-icon.png';
```

### Error 2: Inline SVG Misuse
```blade
{{-- ❌ FALSE FRIEND - Invalid placement --}}
<div class="map-marker" style="background-image:url({{ asset('img/markers.svg') }})"></div>
```

### Error 2: Correct Approach
```blade
{{-- ✅ CORRECT - Standard approach --}}
@svg('map-marker.svg', ['class' => 'map-marker'])
```