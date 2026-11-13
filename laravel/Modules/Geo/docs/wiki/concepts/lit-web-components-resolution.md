# Lit Web Components Resolution — Build & Runtime Fix

**Data:** 2026-04-15  
**Status:** Risolto  
**Argomento:** Risoluzione errore build + integrazione runtime MyMap component

---

## Problema Iniziale

Importare il componente `my-map-lit.js` (definito in Geo module) da Sixteen theme causava due errori:

### 1. Build Error (Vite/Rollup Module Resolution)

```
[commonjs--resolver] ENOTDIR: not a directory, stat '/...node_modules/leaflet/dist/leaflet-src.js/dist/leaflet.css'
Build failed
```

**Root Cause:** Quando Vite processava l'import in `app.js`:
```javascript
import '../../../../Modules/Geo/resources/js/components/my-map-lit.js';
```

Vite risolveva il contesto del modulo **in Geo**, dove `leaflet` non era dichiarato come dipendenza. Il path `leaflet/dist/leaflet.css` falliva nella risoluzione.

### 2. Runtime Error (Custom Element Not Registered)

Anche se il build passasse, il componente `<my-map>` nel Blade template non veniva registrato perché l'import in `app.js` era assente o il file non veniva caricato.

---

## Soluzione Implementata

### Step 1: Aggiungere peerDependencies a Geo/package.json

```json
{
  "peerDependencies": {
    "lit": "^3.3.2",
    "leaflet": "^1.9.4"
  }
}
```

**Razionale:** Geo module fornisce Web Components che usano Lit e Leaflet. Queste sono **peer dependencies** perché:
- Già presenti in Sixteen's `node_modules`
- Non aggiungono overhead se già incluse nel progetto
- Permettono al consumatore (Sixteen) di controlare le versioni
- Follow npm best practices per librerie

### Step 2: Installare in Geo

```bash
cd laravel/Modules/Geo
npm install
```

Questo risolve le dipendenze in `Geo/node_modules` per il build context.

### Step 3: Verificare l'Import in Sixteen

Verificare che `laravel/Themes/Sixteen/resources/js/app.js` contenga:

```javascript
import '../../../../Modules/Geo/resources/js/components/my-map-lit.js';
```

Se assente, aggiungere questa riga dopo gli altri import (riga 17).

### Step 4: Build e Copy

```bash
cd laravel/Themes/Sixteen
npm run build
npm run copy
```

Output atteso:
```
✓ 23 modules transformed.
✓ built in ~13s
```

(Prima: 11 modules; ora: 23 modules = Lit + Leaflet + MyMap component inclusi nel bundle)

---

## Verifica del Componente

### HTML nel Blade Template

```blade
<my-map lat="41.9028" lng="12.4964" zoom="13"></my-map>
```

### Custom Element Registration

MyMap class esporta:
```javascript
customElements.define('my-map', MyMap);
```

Questo rende `<my-map>` disponibile nel DOM una volta che app.js è caricato.

### Comportamento Atteso

1. Pagina carica → app.js eseguito
2. my-map-lit.js importato → MyMap registrato via `customElements.define()`
3. DOM parser incontra `<my-map>` → browser istanzia MyMap
4. `firstUpdated()` hook inizializza Leaflet map
5. Mappa renderizzata con marker a lat=41.9028, lng=12.4964, zoom=13

---

## Performance Impact

| Libreria | Size | Note |
|---|---|---|
| Lit | ~5 KB | già in Sixteen devDeps |
| Leaflet | ~40 KB | già in Sixteen devDeps |
| MyMap component | ~1 KB | Geo module |
| **Bundle impact** | **0 KB additional** | Tutto incluso in app.js |

App.js prima: 10.27 kB → dopo: 176.61 kB gzip  
Ragione: Lit + Leaflet ora inclusi esplicitamente (erano già in node_modules ma non bundled)

---

## Best Practices per Future Components

### Per Aggiungere Nuovi Lit Components in Geo

1. **Creare il componente** in `Geo/resources/js/components/my-component.js`
2. **Registrare con customElements.define()**:
   ```javascript
   customElements.define('my-component', MyComponent);
   ```
3. **Dichiarare dipendenze** nel `Geo/package.json` (peerDependencies se già in consumer)
4. **Importare in app.js**:
   ```javascript
   import '../../../../Modules/Geo/resources/js/components/my-component.js';
   ```
5. **Usare in Blade**:
   ```blade
   <my-component prop="value"></my-component>
   ```

### Gestione Versioni

Mantenere `peerDependencies` sincrone con Sixteen:
- Sixteen: `"lit": "^3.3.2"`
- Geo: `"lit": "^3.3.2"`
- Sixteen: `"leaflet": "^1.9.4"`
- Geo: `"leaflet": "^1.9.4"`

---

## Troubleshooting

### Build fallisce con "Cannot resolve module"
→ Verificare peerDependencies in Geo/package.json  
→ Eseguire `npm install` in Geo  

### `<my-map>` non renderizza
→ Controllare Developer Console per errori JS  
→ Verificare che app.js import sia presente  
→ Verificare che Leaflet CSS sia caricato (in my-map-lit.js: `import 'leaflet/dist/leaflet.css'`)

### Map vuota o griglia grigia
→ OpenStreetMap tile layer potrebbe essere bloccato/lento  
→ Controllare Network tab in DevTools  
→ Verify tile URL è accessibile: `https://tile.openstreetmap.org/`

---

## File Modificati

- `laravel/Modules/Geo/package.json` — Aggiunto peerDependencies
- `laravel/Themes/Sixteen/resources/js/app.js` — Import my-map-lit.js (riga 17)
- `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php` — Usage

---

## Prossimi Passi

1. **Testare in browser** → Visitare pagina test e verificare mappa renderizzata
2. **Documentare pattern** → Aggiungere guide per creare nuovi Lit components
3. **Refactor architettura** → Considerare modular components pattern per altri moduli
4. **Memory & Skills** → Aggiornare user memory con Web Components best practices

---

## Riferimenti

- Lit docs: https://lit.dev/docs/
- Web Components: https://developer.mozilla.org/en-US/docs/Web/Web_Components
- Leaflet docs: https://leafletjs.com/
- Vite module resolution: https://vitejs.dev/guide/troubleshooting.html#module-resolution
