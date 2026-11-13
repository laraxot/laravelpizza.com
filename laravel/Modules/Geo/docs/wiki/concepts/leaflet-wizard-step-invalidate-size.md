---
name: leaflet-wizard-step-invalidate-size
description: Leaflet map in Filament wizard must call invalidateSize() when step container becomes visible
type: concept
---

# Leaflet Map in Filament Wizard — invalidateSize() Rule

## REGOLA PERMANENTE: Leaflet in wizard Filament deve richiamare invalidateSize() al cambio step

### Problema

Quando un componente `coordinate-picker-lit` viene montato nel DOM mentre il wizard è sullo step 1 (container step 2 è `display:none` o `class="hidden"`), Leaflet vede un container 0×0 e non carica i tile. Quando si clicca "Avanti" e lo step diventa visibile, la mappa rimane vuota.

### Root Cause

- `firstUpdated()` di Lit chiama `_initMap()` al mount del componente
- Se il container padre è nascosto via CSS, Leaflet ottiene dimensioni 0×0
- `ResizeObserver` non scatta per cambi CSS senza variazione dimensionale
- `IntersectionObserver` (threshold 0.01) può non scattare se il padre ha `overflow:hidden`

### Fix applicato (coordinate-picker-lit.js)

```javascript
// In firstUpdated(): MutationObserver sui 6 antenati diretti
this._mutationObserver = new MutationObserver(() => {
    if (this.offsetParent !== null) {
        setTimeout(() => this._refreshMapSize(), 150);
    }
});
let parent = this.parentElement;
for (let i = 0; i < 6 && parent; i++) {
    this._mutationObserver.observe(parent, {
        attributes: true,
        attributeFilter: ['class', 'style', 'hidden']
    });
    parent = parent.parentElement;
}

// In disconnectedCallback():
this._mutationObserver?.disconnect();
```

### Perché MutationObserver e non IntersectionObserver

Filament wizard nasconde gli step con `class="hidden"` (Tailwind). Questa è una modifica di attributo CSS, non una variazione di dimensione. Solo `MutationObserver` con `attributeFilter: ['class']` intercetta questo cambio.

### CDN violation fix contestuale

La stessa sessione ha rimosso il CDN violation:
```javascript
// RIMOSSO (linea 67 originale):
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" ...>

// AGGIUNTO (import Vite-bundled):
import 'leaflet/dist/leaflet.css';
```

### File coinvolti

- `laravel/Modules/Geo/resources/js/components/coordinate-picker-lit.js` — fix MutationObserver + import CSS
- `laravel/Themes/Sixteen/resources/js/app.js` — entry point che include coordinate-picker-lit
- Build: `cd laravel/Themes/Sixteen && npm run build && npm run copy`

### Regole collegate

- `bashscripts/ai/.claude/rules/map-marker-custom-asset.md` — no CDN, no unpkg
- `bashscripts/ai/.claude/rules/map-interaction-transparency-rule.md` — visibilità controlli mappa
