# Lit Web Components in Geo Module

**Data creazione:** 2026-04-15  
**Status:** Documentazione  
**Argomento:** Architettura componenti Lit, integrazione con Vite, bundle strategy

---

## Cosa è Lit?

**Lit** (https://lit.dev) è una libreria leggera per creare Web Components riusabili basati su standard web. Specificatamente:

- **Ultralieve:** ~5KB minificato (vs React ~40KB)
- **Reattivo:** Template literals reactive binding
- **Dichiarativo:** Sintassi HTML con data binding
- **Standard Web:** Basato su Web Components (Custom Elements, Shadow DOM, Slots)
- **Zero dipendenze:** Nessuna dipendenza esterna

### Caratteristiche Chiave

```javascript
import { LitElement, html, css } from 'lit';

export class MyComponent extends LitElement {
  static properties = {
    name: { type: String },
    count: { type: Number },
  };

  static styles = css`
    :host { display: block; }
    .button { background: blue; }
  `;

  render() {
    return html`
      <h1>Hello ${this.name}</h1>
      <button @click=${this.handleClick}>Click me</button>
    `;
  }

  handleClick() {
    this.count++;
  }
}

customElements.define('my-component', MyComponent);
```

---

## Caso d'Uso: MyMap Component

**File:** `Geo/resources/js/components/my-map-lit.js`

### Scopo Attuale

Componente Lit che incapsula una mappa Leaflet con:
- Proprietà reattive: `lat`, `lng`, `zoom`, `markerTitle`
- Marker sincronizzato con le coordinate correnti
- Integrazione Leaflet (libreria mappe)
- Rendering in **light DOM** quando usa CSS globali di librerie terze

### Problema di Integrazione

Il componente **è importato da Sixteen** ma **non ha dipendenze dichiarate in Geo**:

```javascript
// Sixteen/resources/js/app.js (riga 17)
import '../../../../Modules/Geo/resources/js/components/my-map-lit.js';
```

Quando Vite processa questo import:
1. Legge `my-map-lit.js`
2. Vede: `import { LitElement, html, css } from 'lit';`
3. Prova a risolvere il modulo "lit" nel contesto di Geo
4. **Fallisce:** il resolver parte dal file Geo e non vede automaticamente `Sixteen/node_modules/lit`
5. Build interrotto

---

## Strategia di Risoluzione

### Opzione 1: Shared Dependencies + Theme Alias (Consigliato)

**Idea:** Lit è una libreria condivisa tra moduli. Dovrebbe essere in una zona "centrale" accessibile da tutti.

**Implementazione:**
1. ✅ `lit` è dichiarato nella toolchain del tema
2. ✅ `Sixteen` è il bundle root che esegue Vite
3. ⚠️ **Problema reale:** `Geo/my-map-lit.js` è un modulo del **Geo**, quindi i bare imports devono essere aliasati dal tema

**Soluzione Ibrida:**
- Geo documenta ownership e dipendenze concettuali del componente
- Sixteen espone alias Vite per `lit`, `leaflet` e relativo CSS quando consuma file JS fuori root

### Opzione 2: Modulo Autonomo (Long-term)

Geo avrebbe il suo build pipeline e esporterebbe componenti come npm package:

```json
// Geo/package.json
{
  "name": "@fixcity/geo-components",
  "version": "1.0.0",
  "exports": {
    "./my-map": "./resources/js/components/my-map-lit.js"
  },
  "peerDependencies": {
    "lit": "^3.0.0",
    "leaflet": "^1.9.0"
  }
}
```

Sixteen diventerebbe client:
```json
// Sixteen/package.json
{
  "dependencies": {
    "@fixcity/geo-components": "workspace:*",
    "lit": "^3.3.2",
    "leaflet": "^1.9.4"
  }
}
```

### Opzione 3: Alias Vite Configuration

Configurare Vite per risolvere "lit" globalmente per tutti i moduli:

```javascript
// Sixteen/vite.config.js
export default defineConfig({
  resolve: {
    alias: {
      'lit': path.resolve(__dirname, 'node_modules/lit/index.js')
    }
  }
})
```

---

## Regola Operativa Corrente

**Nel repository attuale:**

1. `Sixteen` resta il bundle root
2. I componenti JS di Geo possono essere importati dal tema
3. Le dipendenze esterne (`lit`, `leaflet`, `leaflet.css`) vanno rese raggiungibili dal tema tramite alias Vite
4. Se il componente usa una libreria con CSS globali come Leaflet, evitare Shadow DOM oppure reiniettare esplicitamente la stylesheet nello shadow root

### Caso reale: `my-map`

Il problema non era uno solo:

1. Il bundle pubblicato non conteneva davvero `customElements.define('my-map', ...)`
2. Il file Geo usava bare imports (`lit`, `leaflet`) da fuori root tema
3. Anche dopo la build corretta, Leaflet restava visualmente rotto perché i CSS globali non entrano nello Shadow DOM

### Soluzione adottata

- alias Vite nel tema per `lit`, `leaflet`, `leaflet.css`
- import del componente Geo dentro `Sixteen/resources/js/app.js`
- pipeline obbligatoria `npm run build` + `npm run copy` da `laravel/Themes/Sixteen`
- `my-map` reso in **light DOM** per consentire a Leaflet di usare i suoi CSS globali

## Uso in Filament Fields

`Lit` non sostituisce Filament. Nel modulo Geo la regola corretta e':

- il **field PHP** decide il renderer (`blade` o `lit`)
- la **Blade del field** fa da bridge verso il renderer JS
- il **Web Component** renderizza la UI mappa

Caso concreto:

- `LatitudeLongitudeInput` usa `blade` come default
- `LatitudeLongitudeInput::make(...)->jsFramework('lit')` seleziona una Blade alternativa
- la Blade Lit monta `<my-map>` e mantiene il sync con gli input Filament/Livewire

Questo evita di spostare la governance del field nel tema o nella pagina.

---

## Architettura Consigliata: Modular Web Components

### Struttura Ideale

```
laravel/Modules/Geo/
├── package.json                    ← Dichiarare "lit" + "leaflet"
├── resources/
│   └── js/
│       └── components/
│           ├── my-map-lit.js       ← Export default: MyMap classe
│           ├── geocoder.js
│           └── index.js            ← Re-export tutti i componenti
└── docs/
    └── COMPONENTS.md               ← Guida uso componenti

laravel/Themes/Sixteen/
├── package.json                    ← Dipendenze tema + shared libs
├── resources/
│   └── js/
│       └── app.js                  ← Import e registrazione componenti
└── docs/
    └── ARCHITECTURE.md             ← Strategia integrazione moduli
```

### Pattern di Registrazione

```javascript
// Geo/resources/js/components/index.js
export { MyMap } from './my-map-lit.js';
export { GeocodeWidget } from './geocoder.js';

// Sixteen/resources/js/app.js
import { MyMap, GeocodeWidget } from 'modules/geo/components/index.js';
// I componenti si registrano automaticamente via customElements.define()
```

---

## Performance & Bundle Size

**Impatto su bundle:**
- **Lit:** ~5KB minificato (già incluso in Sixteen)
- **Leaflet:** ~40KB (già incluso in Sixteen per latitudine-longitudine)
- **Total aggiunto:** 0KB (dipendenze già presenti)

**Ottimizzazioni:**
- Lazy load componenti Lit solo se usati
- Code splitting: componenti in chunk separati
- Tree-shake componenti inutilizzati

---

## Letture Consigliate

- https://lit.dev/docs/ — Documentazione ufficiale
- https://lit.dev/docs/components/overview/ — Panoramica componenti
- https://lit.dev/docs/components/properties/ — Reattività e proprietà
- https://lit.dev/docs/components/rendering/ — Rendering e templating

---

## Prossimi Passi

1. **Fix build immediato:** Aggiungere "lit" a Geo/package.json
2. **Documentare pattern:** Creare guida per creare nuovi componenti Lit in moduli
3. **Testare componente:** Verificare MyMap funziona correttamente nel browser
4. **Architettura moduli:** Definire regole per interdipendenze moduli/temi
5. **Memory & Rules:** Aggiornare memories e skill rules per Web Components pattern

---
