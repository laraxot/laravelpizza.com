---
name: map-picker-lit-admin-fix-8-56
description: 5 bug risolti in map-picker-lit.js per il panel admin Filament (story 8-56)
type: concept
---

# map-picker-lit.js — Admin Panel Fix (Story 8-56)

## Bug e fix applicati (2026-04-27)

### BUG 1 — `map-picker-lit.js` assente da `vite.config.js`

`<map-picker-lit>` non veniva mai registrato come custom element.

**Fix**: aggiunto a `vite.config.js`:
```js
resolve(__dirname, 'resources/js/components/map-picker-lit.js')
```

### BUG 2 — CDN Leaflet CSS

`render()` includeva `<link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">`.

**Fix**: rimosso CDN, aggiunto in cima al file:
```js
import 'leaflet/dist/leaflet.css';
```

### BUG 3 — IntersectionObserver (false friend)

`connectedCallback()` usava `IntersectionObserver` che NON rileva `class="hidden"` di Tailwind/wizard Filament.

**Fix**: `MutationObserver` depth 15:
```js
this._mutationObserver = new MutationObserver(() => {
    if (this.offsetParent !== null && this._map) {
        setTimeout(() => this._map.invalidateSize(), 150);
    }
});
let parent = this.parentElement;
for (let i = 0; i < 15 && parent; i++) {
    this._mutationObserver.observe(parent, { attributes: true, attributeFilter: ['class', 'style', 'hidden'] });
    parent = parent.parentElement;
}
```

### BUG 4 — marker dragend (non bug)

Già presente e corretto in `_syncMarkerToState()`.

### BUG 5 — SVG lente enorme

`_renderSearch()` SVG senza `width`/`height` → ereditava dimensioni enormi dal contesto CSS.

**Fix**: aggiunto `width="20" height="20"` all'SVG inline.

## File modificati

| File | Motivo |
|------|--------|
| `vite.config.js` | BUG 1: aggiunto map-picker-lit.js input |
| `resources/js/components/map-picker-lit.js` | BUG 2+3+5 |
| `app/Providers/Filament/AdminPanelProvider.php` | registrazione JS asset map-picker |

## Regole collegate

- `bashscripts/ai/.claude/rules/leaflet-wizard-invalidate-size.md`
- `bashscripts/ai/.claude/rules/map-marker-custom-asset.md`
